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

JLoader::register('JFormFieldRamajax', JPATH_BASE.'/administrator/components/com_ramajax/models/fields/ramajax.php');

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
 *           name="league" 
 *           type="ramajaxselectalone" 
 *           label="RAMAJAX_FIELD_SELECT_LABEL_LEAGUE"
 *           emptyValueText="RAMAJAX_FIELD_SELECT_EMPTY_VALUE_TEXT_LEAGUE"
 *           slaveFieldName="league"
 *           slaveFieldTable="#__ramajax_league_list"
 *       />
 *
 * @since  0.0.1
 */
class JFormFieldRamajaxSelectAlone extends JFormFieldRamajax {
    
    protected $type = 'ramajaxselectalone';

    // getLabel() left out

    public function getInput() 
    {
        // Common methods for Ramajax staff
        $this->ramajaxStaff();

        // Get field values or empty strings
        if (empty($this->ramDef['slaveFieldValue'])) {$this->ramDef['slaveFieldValue']="";}

        $slaveOptions = $this->ajaxModel->getSelectAloneOptions(
            $this->ramDef['ramajaxName'],
            $this->ramDef['slaveFieldValue']);

        // Build select
        return '<select id="'.$this->id.'" name="'.$this->name.'">'.$slaveOptions.'</select>';
    }
}