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

JLoader::register('JFormFieldRamajax', JPATH_BASE.'/components/com_ramajax/models/fields/ramajax.php');

// Add Logger - RAM DEBUG
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
//     // JLog::add('************** JFormFieldRamajax *****************', JLog::INFO, 'com_ramajax');
// }

/**
 * Ramajax Form Field class for dynamic ajax combo select
 *       <field 
 *          name="player" 
 *          type="ramajax" 
 *          label="Select a player"
 *          masterFieldName="team"
 *          masterFieldTable="#__ramajax_league_team_map"
 *          slaveFieldName="player"
 *          slaveFieldTable="#__ramajax_use_example"
 *       />
 *
 * @since  0.0.1
 */
class JFormFieldRamajaxSelect extends JFormFieldRamajax {
    
    protected $type = 'ramajaxselect';
    public array $ramDef; // Ramajax Definition
    public $ajaxModel;

    // Constructor
    public function __construct(\Joomla\CMS\Form\Form $form = null) 
    {
        parent::__construct($form);

        // Get Model
        JModelLegacy::addIncludePath(JPATH_BASE . '/components/com_ramajax/models');
        $this->ajaxModel = JModelLegacy::getInstance('Ajax', 'RamajaxModel');
    }

    // getLabel() left out

    public function getInput() 
    {
        // Common methods for Ramajax staff
        $this->ramajaxStaff();

        // Get field values or empty strings
        $slaveOptions = "";
        if (empty($this->ramDef['masterFieldValue'] )) {$this->ramDef['masterFieldValue']="";}
        if (empty($this->ramDef['slaveFieldValue'])) {$this->ramDef['slaveFieldValue']="";}
        
        if (!$this->ajaxModel->existMasterField(
            $this->ramDef['ramajaxName'],
            $this->ramDef['masterFieldValue'])) 
        {
            $this->ramDef['masterFieldValue'] ='';
        }  

        $slaveOptions = $this->ajaxModel->getRamajaxSelectOptions(
            $this->ramDef['ramajaxName'],
            $this->ramDef['masterFieldValue'],
            $this->ramDef['slaveFieldValue']);

        // Build select
        return '<select id="'.$this->id.'" name="'.$this->name.'">'.$slaveOptions.'</select>';
    }
}