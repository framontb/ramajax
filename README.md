# ramajax
Joomla component for ajax dynamic html selects


# Features
This utility makes life easy for developers who wants to set up dynamic selects, ajax filled, in his views. This component creates ajax responses to update the options of select html elements. Furthermore, it implements a new field type (JFormFieldRamajaxSelect) to create the "slave" select.

# How it works
Explain the code

Check if Ramajax is working
Ramajax component comes with some data configured, so you can check if it is working.
You can access this URL to check if the ajax server is working: [CHECK AJAX](http://joomla_clasificados/index.php?option=com_ramajax&task=ajax.getRamajaxSelectValues&format=json&ramajaxName=team&masterFieldValue=NBA&lang=es)

You should see a text like this in your browser:

```
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
```

# How to use it
After install com_ramajax, and check it's working properly, you will need to add a master filter field:

1. Add a master field type "ramajaxselectalone" to the form. In the example component com_ramajaxauseexample, the file is site/models/forms/filter_buscador.xml, and there are two examples: league and player_country
2. Add the master field to the template. In the example (com_ramajaxauseexample), see the file site/views/buscador/tmpl/defalult.php Check that you can see the select element in the view (buscador).
3. Add the search condition to the model. In the example (com_ramajaxauseexample), see the file site/models/buscador.php Check that you can filter by the field.
4. Add the line to the javascript filter_clear function. In the example (com_ramajaxauseexample), see the file site/views/buscador/buscador.js Check that Reset button cleans the select.

Next, you will want to add a slave filter (filled by ajax):
1. Add a slave field "ramajaxselect" to the form. In the example (com_ramajaxauseexample) the file is filter_buscador.xml, and there are several examples there.
2. Add the slave field to the template. In the example (com_ramajaxauseexample), see the file site/views/buscador/tmpl/defalult.php Check that you can see the select element in the view.
3. Add the ajax javascript function to the field, linked to changes in the master field. In the example (com_ramajaxauseexample), see the file site/views/buscador/buscador.js For example for the field player_state. Note how it is linked to the master field. Check that changing the master field, the slave field is filled right.
4. Add the search condition to the model. In the example (com_ramajaxauseexample), see the file site/models/buscador.php Check that you can filter by the field.
5.Add the line to the javascript filter_clear function. In the example (com_ramajaxauseexample), see the file site/views/buscador/buscador.js Check that Reset button cleans the select.

Now chain as many slaves as you wish following the same method.

# See it in the component example
Example: `com_ramajax_example`

# How to improve the component
* Add a view to add new pairs of master-slave combo selects automatically (ramajax field)
* Add more javascript and FormFields for new html elements (check boxes)

# Troubleshooting
Activating "Global Configuration > System > Debug System = YES" will leave logs in the file: "/var/www/html/administrator/logs/com_ramajax.log.php"
You can add more logs easily, just watch the site entry poing for the com_ramajax.

