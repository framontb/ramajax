<?php
/**
 * Ramajax
 * @version      $Id$
 * @package      ramajax
 * @copyright    Copyright (C) 2021 framontb. All rights reserved.
 * @license      GNU/GPL
 * @link         https://github.com/framontb/JoomlaBasicExtensions
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// RAM DEBUG
// use Joomla\CMS\Log\Log;
// if (JDEBUG) {
//     JLog::addLogger(
//         array(
//             // Sets file name
//             'text_file' => 'com_ramajax.log.php'
//         ),
//         // Sets messages of all log levels to be sent to the file.
//         JLog::ALL,
//         // The log category/categories which should be recorded in this file.
//         // In this case, it's just the one category from our extension.
//         // We still need to put it inside an array.
//         array('com_ramajax')
//     );
//     JLog::add('******** COM_RAMAJAX > MODEL: AJAX.PHP **********', JLog::INFO, 'com_ramajax');
// }

/**
 * Ajax Model
 *
 * @since  0.0.1
 */
class RamajaxModelAjax extends JModelItem
{
    /**
     * Buffer for Ramajax definition data
     *  [
     *      name                = "player" 
     *      type                = "ramajax" 
     *      masterFieldName     = "team"
     *      masterFieldTable    = "#__ramajax_league_team_map"
     *      slaveFieldName      = "player"
     *      slaveFieldTable     = "#__ramajax_use_example"
     *   ]
     */
    public array $ramajaxDefinition;

    public $existMasterField;

    // Constructor
    public function __construct($properties = null) 
    {
        $this->ramajaxDefinition = array();
        $this->existMasterField = null;

        parent::__construct($properties);
    }

    // ********************************************************************************
    // ********     RAMAJAX MODEL: SHARED METHODS TO MANAGE FIELDS IN BD     **********
    // ********************************************************************************

   /**
     * Update a ramajax row in the DB
     * 
     */
    public function updateRamajaxInDb(object $ramajaxField)
    {
        $updateNulls = true;

        // Add name for object
        $ramajaxField->name = $ramajaxField->ramajaxName;

        // Delete properties not to store in db
        unset($ramajaxField->ramajaxName);
        unset($ramajaxField->masterFieldValue);
        unset($ramajaxField->slaveFieldValue);

        // Actual update
        $result = JFactory::getDbo()->updateObject(
                    '#__ramajax_definition_tables', 
                    $ramajaxField, 
                    'name', 
                    $updateNulls);
    }

   /**
     * Store a ramajax Field in the DB
     * 
     */
    public function storeRamajaxInDb(array $ramDefForm)
    {
        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);

        // Insert columns.
        $columns = array(
            'name',
            'extensionName',
            'type',
            'masterFieldName',
            'masterFieldTable',
            'slaveFieldName',
            'slaveFieldTable',
            'emptyValueText'
        );

        // Values that could be NULL
        $masterFieldName  = !empty($ramDefForm['masterFieldName']) ? $db->quote($ramDefForm['masterFieldName']) : "NULL";
        $masterFieldTable = !empty($ramDefForm['masterFieldTable']) ? $db->quote($ramDefForm['masterFieldTable']) : "NULL";
        $emptyValueText   = !empty($ramDefForm['emptyValueText']) ? $db->quote($ramDefForm['emptyValueText']) : "NULL";

        // Insert values.
        $values = array(
            $db->quote($ramDefForm['ramajaxName']), 
            $db->quote($ramDefForm['extensionName']),
            $db->quote($ramDefForm['type']), 
            $masterFieldName, 
            $masterFieldTable, 
            $db->quote($ramDefForm['slaveFieldName']), 
            $db->quote($ramDefForm['slaveFieldTable']),
            $emptyValueText
        );

        // Prepare the insert query.
        $query
            ->insert($db->quoteName('#__ramajax_definition_tables'))
            ->columns($db->quoteName($columns))
            ->values(implode(',', $values));

        // Set the query using our newly populated query object and execute it.
        $db->setQuery($query);
        $db->execute();
    }

    /**
     * Gets the Ramajax definition from DB or Buffer Property
     * 
     * Buffering data (in $this->ramajaxDefinition) saves queries to DB
     */
    public function getRamajaxDefinition(String $ramajaxName)
    {
        // RAM DEBUG
        // if (JDEBUG) JLog::add('getRamajaxDefinition > $ramajaxName = '.$ramajaxName, JLog::INFO, 'com_ramajax');

        if (empty($this->ramajaxDefinition))
        {  
            $db    = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('*')
                ->from($db->quoteName('#__ramajax_definition_tables'))
                ->where($db->quoteName('name') . " = " . $db->quote($ramajaxName));
            $db->setQuery($query);
            $result = $db->loadAssoc();

            if (!empty($result))
            {
                $this->ramajaxDefinition  = $result;
            }
        }

        return $this->ramajaxDefinition ;
    }

    /**
     * Get the ramajax field state in db:
     * 
     * Used in model > fields > ramajax.php
     *      -1 conflict detected
     *       0 all is OK, ramajax field provisioned
     *       1 ramajax field not provisined jet
     */
    public function getRamajaxStateDb(array $ramDefForm)
    {
        $ramDefDb = $this->getRamajaxDefinition($ramDefForm['ramajaxName']);

        // No such field ramajax in DB => need provision
        if (empty($ramDefDb)) {return 1;}
        
        // Detect Conflict
        if ( 
            $ramDefForm['type']             != $ramDefDb['type']                ||
            $ramDefForm['masterFieldName']  != $ramDefDb['masterFieldName']     ||
            $ramDefForm['masterFieldTable'] != $ramDefDb['masterFieldTable']    ||
            $ramDefForm['slaveFieldName']   != $ramDefDb['slaveFieldName']      ||
            $ramDefForm['slaveFieldTable']  != $ramDefDb['slaveFieldTable']     ||
            $ramDefForm['emptyValueText']   != $ramDefDb['emptyValueText']
        )
        {
            return -1;
        }

        // Else
        return 0;
    }

    /**
     * Method to validate that a masterField is in the table
     *
     * @param       string  $masterField
     * @return      boolean  true if masterField is in the table
     */
    public function existMasterField(String $ramajaxName, String $masterFieldValue)
    {
        // RAM DEBUG
        // if (JDEBUG) JLog::add('existMasterField > $ramajaxName = '.$ramajaxName, JLog::INFO, 'com_ramajax');

        if (is_null($this->existMasterField))
        {
            // Initialize variables.
            $ramdef  = $this->getRamajaxDefinition($ramajaxName);

            // Create the base select statement.
            $db    = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('count(*)')
                    ->from($db->quoteName($ramdef['masterFieldTable']))
                    ->where($db->quoteName($ramdef['masterFieldName']) . " = " . $db->quote($masterFieldValue));

            // Reset the query using our newly populated query object.
            $db->setQuery($query);
            try {
                $count = $db->loadResult();
            }
            catch (Exception $e)
            {
                JFactory::getApplication()->enqueueMessage(
                    JText::sprintf('existMasterField error: '.$ramdef['masterFieldName'], $e->getCode(), $e->getMessage()),
                    'warning');
                return False;
            }
            

            if ($count > 0) $this->existMasterField = True;
            else $this->existMasterField =  False;
        }

        return $this->existMasterField;
    }

    // ********************************************************************************
    // ********     RAMAJAX MODEL: SHARED METHODS FOR SELECT FIELDS     **********
    // ********************************************************************************

    /**
     * Method to get the slave message when the primary is empty
     * 
     * It will be assigned no value in getSlaveOptions, so it matches for All specialties
     * 
     * Take empty text from Ramajax field definition or 'RAMAJAX_ALL' by default
     *
     * @param       string  $masterField
     * @return      array   list of Slave Values
     */
    public function getSelectEmptyText(String $ramajaxName)
    {
        // @TODO: Fichero con definición de constantes
        $emptyValueText = 'RAMAJAX_ALL';
        $ramdef  = $this->getRamajaxDefinition($ramajaxName);

        if (!empty($ramdef['emptyValueText'])) {
            $emptyValueText = $ramdef['emptyValueText'];
        }
        
        return JText::_($emptyValueText);
    }

    /**
     * Method to get the slave message when the primary is empty
     * 
     * It will be assigned no value in getSlaveOptions, so it matches for All specialties
     *
     * @param       string  $masterField
     * @return      array   list of Slave Values
     */
    public function getSelectEmptyOption(String $ramajaxName)
    {
        return '<option value>'.$this->getSelectEmptyText($ramajaxName).'</option>';
    }

    // ***************************************************************************************
    // ********     RAMAJAX MODEL: SPECIFIC METHODS FOR JFormFieldRamajaxSelect     **********
    // ***************************************************************************************

    /**
     * Method to get all slave Fields that match for a masterField
     *
     * @param       string  $masterField
     * @return      array   list of Slave Values
     */
    public function getRamajaxSelectValues(
        String $ramajaxName,
        String $masterFieldValue)
    {
        // Get Ramajax definition
        $ramdef  = $this->getRamajaxDefinition($ramajaxName);

        // Create the base select statement.
        // https://docs.joomla.org/Selecting_data_using_JDatabase/es#loadColumn.28.29
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('DISTINCT ' . $ramdef['slaveFieldName'])
                ->from($db->quoteName($ramdef['slaveFieldTable']))
                ->where($db->quoteName($ramdef['masterFieldName']) . " = " . $db->quote($masterFieldValue))
                ->order($ramdef['slaveFieldName'] . ' ASC');
        
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        try 
        {
            $column= $db->loadColumn();
        }
        catch (Exception $e)
        {
            // @TODO: users only need to know that there was a problem loading the options
            // All the rest must be dumped in log
            JFactory::getApplication()->enqueueMessage(
                JText::sprintf('getSlaveValues error: '.$ramdef['slaveFieldName'], $e->getCode(), $e->getMessage()),
                'warning');
            return array();
        }
        
        return $column;
    }

    /**
     * Method to get all slave Options that match for a masterField
     *
     * @param       string  $masterField
     * @return      array   list of Slave Values
     */
    public function getRamajaxSelectOptions(
        String $ramajaxName,
        String $masterFieldValue,
        String $slaveFieldValue='')
    {
        // Initialize variables.
        $ramdef  = $this->getRamajaxDefinition($ramajaxName);

        // Get default Option
        // FEATURE: RAMAJAX ALONE
        $options   = $this->getSelectEmptyOption($ramajaxName);

        // Get the other Options
        if ($this->existMasterField($ramajaxName,$masterFieldValue)){
            $slavesFromDb = $this->getRamajaxSelectValues($ramajaxName,$masterFieldValue);
            foreach ($slavesFromDb as $slaveDb) 
            {
                $selected = ($slaveFieldValue ==  $slaveDb)?'selected="selected"':'';
                $slaveDbTranslated = JText::_($slaveDb);
                $options .= "<option value='$slaveDb' $selected>$slaveDbTranslated</option>";
            }
        }

        return $options;
    }

    // ********************************************************************************************
    // ********     RAMAJAX MODEL: SPECIFIC METHODS FOR JFormFieldRamajaxSelectAlone     **********
    // ********************************************************************************************

    /**
     * Get the options from the DB
     */
    public function getSelectAloneOptions(String $ramajaxName, String $slaveFieldValue) 
    {
        // Get Ramajax definition
        $ramdef  = $this->getRamajaxDefinition($ramajaxName);

        // Create the base select statement.
        // https://docs.joomla.org/Selecting_data_using_JDatabase/es#loadColumn.28.29
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('DISTINCT ' . $ramdef['slaveFieldName'])
                ->from($db->quoteName($ramdef['slaveFieldTable']))
                ->order($ramdef['slaveFieldName'] . ' ASC');
        // Reset the query using our newly populated query object.
        $db->setQuery($query);
        try 
        {
            $slaves = $db->loadColumn();
        }
        catch (Exception $e)
        {
            JFactory::getApplication()->enqueueMessage(
                JText::sprintf('getSelectAloneOptions error: '.$ramdef['slaveFieldName'], $e->getCode(), $e->getMessage()),
                'warning');
            return array();
        }
        
        $options = $this->getSelectEmptyOption($ramajaxName);
        foreach ($slaves as $slaveDb) 
        {
            $selected = ($slaveFieldValue ==  $slaveDb)?'selected="selected"':'';
            $slaveDbTranslated = JText::_($slaveDb);
            $options .= "<option value='$slaveDb' $selected>$slaveDbTranslated</option>";
        }

        return $options;
    }
}