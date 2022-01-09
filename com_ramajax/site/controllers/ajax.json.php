<?php
/**
 * Ramajax
 * @version      $Id$
 * @package      ramajax
 * @copyright    Copyright (C) 2021 framontb. All rights reserved.
 * @license      GNU/GPL
 * @link         https://github.com/framontb/JoomlaBasicExtensions
 */

use \Joomla\CMS\Response\JsonResponse;

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
// }
// RAM DEBUG
// if (JDEBUG) JLog::add('******** COM_RAMAJAX > RamajaxControllerAjax **********', JLog::INFO, 'com_ramajax');

class RamajaxControllerAjax extends JControllerLegacy
{
    // Properties
    private String $ramajaxName;
    private String $masterFieldValue;
    private String $langTag;
    private $model;
    private $extension;

    /**
     * Constructor class
     */
    public function __construct()
    {
        parent::__construct();

        # Get the model
        $this->addModelPath(JPATH_COMPONENT_ADMINISTRATOR.'/models');
        $this->model = $this->getModel('ajax');

        # master/slave field Variables      
        $this->ramajaxName      = JFactory::getApplication()->input->get('ramajaxName','','WORD');
        $this->masterFieldValue = JFactory::getApplication()->input->get('masterFieldValue','','STRING');
        $this->langTag          = JFactory::getApplication()->input->get('langTag','es-ES','STRING');

        // RAM DEBUG
        // if (JDEBUG) JLog::add('$this->langTag  -->'.$this->langTag.'<--', JLog::INFO, 'com_ramajax');

        // RAM DEBUG
        // if (JDEBUG) JLog::add('RamajaxControllerAjax > $this->ramajaxName = '.$this->ramajaxName, JLog::INFO, 'com_ramajax');

        # If empty $masterFieldValue, or $masterFieldValue not in bd => nothing to do
        if (empty($this->masterFieldValue) or (!$this->model->existMasterField($this->ramajaxName, $this->masterFieldValue))) 
        {
            $this->masterFieldValue = "";
        }

        // Get extension for loading the translations file
        $ramDef = $this->model->getRamajaxDefinition($this->ramajaxName);
        $this->extension = $ramDef['extensionName'];

        $lang = JFactory::getLanguage();
        $base_dir = JPATH_SITE;
        $language_tag = $this->langTag;
        $reload = true;
        // $lang->load($extension, JPATH_ADMINISTRATOR, null,          false, true)
        $lang->load($this->extension, $base_dir,'en-GB', $reload);
        $lang->load($this->extension, $base_dir,$language_tag, $reload);
    }

    /**
     * Get the slave raw values from the database
     */
    public function getRamajaxSelectValues()
    {
        try
        {
            $slaveValues = $this->model->getRamajaxSelectValues(
                $this->ramajaxName,
                $this->masterFieldValue);

            $response = new JsonResponse($slaveValues);
            echo $response;
        }
        catch(Exception $e)
        {
            echo new JsonResponse($e);
        }
    }

    /**
     * Get the slave Options from the database
     */
    public function getRamajaxSelectOptions()
    {
        try
        {
            $slaveOptions = $this->model->getRamajaxSelectOptions(
                $this->ramajaxName,
                $this->masterFieldValue);

            // SEND MESSAGES to page by Ajax: 
            // Doc: https://docs.joomla.org/JSON_Responses_with_JResponseJson
            // $app = JFactory::getApplication();      
            // $app->enqueueMessage("Enqueued notice", "notice");
            // $app->enqueueMessage("Enqueued warning", "warning");
            //$response = new JsonResponse($slaveOptions, "It worked!");

            $response = new JsonResponse($slaveOptions);
            echo $response;
        }
        catch(Exception $e)
        {
            echo new JsonResponse($e);
        }
    }
}