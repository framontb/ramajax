<?php
/**
 * Ramajax
 * @version      $Id$
 * @package      ramajax
 * @copyright    Copyright (C) 2021 framontb. All rights reserved.
 * @license      GNU/GPL
 * @link         https://github.com/framontb/JoomlaBasicExtensions
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// Get URI root
$uri = JUri::getInstance();
$uriRoot =  $uri->root();

?>

<style>
.ram {
  width: 50%;
}

</style>

<div class="ram">
<h2>Features</h2>
    <p>
        This utility makes life easy for developers 
        who wants to set up dynamic selects, ajax filled, in his views.

        This component creates ajax responses to update the options of select html elements.

        Furthermore, it implements a new field type (JFormFieldRamajax) 
        to create the "slave" select.
    </p>

<h2>How it works</h2>
    <p>Explain the code</p>

<h2>Check if Ramajax is working</h2>

    <p>
    Ramajax component comes with some data configured, so you can check if it is working.
    </br>You can access this URL to check if the ajax server is working: 
    <a target="_blank" href="<?php echo $uriRoot ?>index.php?option=com_ramajax&task=ajax.getRamajaxSelectValues&format=json&ramajaxName=team&masterFieldValue=NBA&lang=es">CHECK AJAX</a>
    </p>

    <p> You should see a text like this in your browser:
    <xmp>
    {
        "success":true,
        "message":null,
        "messages":null,
        "data":[
            "Phoenix Suns",
            "Los Angeles Lakers",
            "Golden State Warriors"
            ]
    }
    </xmp>
    </p>

<h2>How to use it</h2>
    <p>
        After install com_ramajax, and check it's working properly, you will need to <b>add a master filter field</b>:

        <ol>
            <li>Add a master field type "ramajaxselectalone" to the form.
                In the example component com_ramajaxauseexample, the file is site/models/forms/filter_buscador.xml,
                and there are two examples: league and player_country
            </li>
            <li>
                Add the master field to the template.
                In the example (com_ramajaxauseexample), see the file site/views/buscador/tmpl/defalult.php
                Check that you can see the select element in the view (buscador).
            </li>
            <li>
                Add the search condition to the model.
                In the example (com_ramajaxauseexample), see the file site/models/buscador.php
                Check that you can filter by the field.
            </li>
            <li>
                Add the line to the javascript filter_clear function.
                In the example (com_ramajaxauseexample), see the file site/views/buscador/buscador.js
                Check that Reset button cleans the select.
            </li>
        </ol>

        Next, you will want to <b>add a slave filter</b> (filled by ajax):

        <ol>
            <li>Add a slave field "ramajaxselect" to the form.
                In the example (com_ramajaxauseexample) the file is filter_buscador.xml,
                and there are several examples there.
            </li>
            <li>
                Add the slave field to the template.
                In the example (com_ramajaxauseexample), see the file site/views/buscador/tmpl/defalult.php
                Check that you can see the select element in the view.
            </li>
            <li>
                Add the ajax javascript function to the field, linked to changes in the master field.
                In the example (com_ramajaxauseexample), see the file site/views/buscador/buscador.js
                For example for the field player_state. Note how it is linked to the master field.
                Check that changing the master field, the slave field is filled right.
            </li>
            <li>
                Add the search condition to the model.
                In the example (com_ramajaxauseexample), see the file site/models/buscador.php
                Check that you can filter by the field.
            </li>
            <li>
                Add the line to the javascript filter_clear function.
                In the example (com_ramajaxauseexample), see the file site/views/buscador/buscador.js
                Check that Reset button cleans the select.
            </li>
        </ol>

        Now <b>chain as many slaves</b> as you wish following the same method.
    </p>

<h2>See it in the component example</h2>
    <p>Example: com_ramajax_example</p>

<h2>How to improve the component</h2>
    <ul>
        <li>Add a view to add new pairs of master-slave combo selects automatically (ramajax field)</li>
        <li>Add more javascript and FormFields for new html elements (check boxes)</li>
        <li>Add translations<li>
    </ul>

<h2>Troubleshooting</h2>
    <ul>
        <li>Activating "Global Configuration > System > Debug System = YES" will leave logs in the file: "/var/www/html/administrator/logs/com_ramajax.log.php"</li>
        <li>You can add more logs easily, just watch the site entry poing for the com_ramajax.</li>
    </ul>

<h2>TODO</h2>
    <ul>
        <li>Avoid CSRF: Check token in controller</li>
        <li>Review Copyright notes</li>
        <li>El aviso de que ya existe una entrada para MasterField es incorrecto. 
            Debería aparecer solo cuando no existe la combinación master/slave.
        </li>
        <li>MODEL: ajaxgetSlaveEmptyValue: cómo definir fichero de constantes en un componente.
            Aplicar a "ALL" en los selectores (cambiar por RAMAJAX_ALL).
        </li>
        <li>Opción en field ramajax para meter o no el "RAMAJAX_ALL", que en realidad deja el option sin value</li>
        <li>Add the index.html files to COM_RAMAJAX and COM_RAMAJAXUSEEXAMPLE</li>
    </ul>

    <h2>DONE</h2>
    <ul>
        <li>First time a ramajax field loads, it saves the tables in __ramajax_field_tables</li>
        <li>error managing for ramajax field auto-provision</li>
        <li>BUG: When using the pagination links with league selected, the team select doesn't fill values.
            Si el master field presenta un valor, deben cargarse las opciones correspondientes en el slave.
            Reproducir: Selecciona una liga, y submit. Luego pica en link de paginación. El select de team no tiene valores,
            aunque hay una liga elegida.
        </li>
        <li>17/12/21 - Error managing for ajax. For example, conflict between ramajax fields access to db.</li>
        <li>Translations</li>
        <li>18/12/21 - Translations: Translate to language different from english</li>
        <li>18/12/21 - Translations: what is a multilanguage page for joomla</li>
        <li>27/12/21 - Added new field "extensionName" to table #_ramajax_definition_tables.
            So, the languaje files are loaded automatically in the Ramajax controller "ajax.json.php".
        </li>
        <li>28/12/21 - COVID Vacine: leaves me like shit</li>
        <li>30/12/21 - Added Galician and Portuguese translations</li>
        <li>31/12/21 - Added new search Ramajax filters to the use example: player_country, player_state, player_city</li>
        <li>7/1/22 - Moved all funtionality to backend</li>
    </ul>

</div>