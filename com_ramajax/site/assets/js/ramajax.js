// /**
//  * Ramajax
//  * @version      $Id$
//  * @package      ramajax
//  * @copyright    Copyright (C) 2021 framontb. All rights reserved.
//  * @license      GNU/GPL
//  * @link         https://github.com/framontb/JoomlaBasicExtensions
//  */

// Populates the indicated slave select (see slaveSelectId in the event)
// with options directly received from ajax request
// Observe here task=ajax.getSlaveOptions
function populateRamajaxSelectOptions(event)
{
    // Empty slave field before filling it
    jQuery(event.data.slaveSelectId).empty();

    // Ajax request
    var masterFieldValue = jQuery(this).find(':selected').val();
    dataString = 'ramajaxName='+event.data.ramajaxName
    dataString += '&masterFieldValue=' + masterFieldValue;
    dataString += '&langTag='+event.data.langTag;

    jQuery.ajax({
        type     : 'GET',
        url      : 'index.php?option=com_ramajax&task=ajax.getRamajaxSelectOptions&format=json',
        data     : dataString,
        dataType : 'JSON',
        cache    : true,
        success  : function(result, textStatus, jqXHR) {
            // RAM DEBUG
            // console.log("Message from server was " + result.message);

            // MAIN DATA UPDATE
            jQuery(event.data.slaveSelectId).empty().append(result.data);
            
            // display the enqueued messages in the message area
			Joomla.renderMessages(result.messages);
        },
        error    : function(jqXHR, textStatus, errorThrown)
		{
            console.log('ajax call failed');
            // RAM DEBUG
			// console.log('ajax call failed - textStatus: ' + textStatus);
            // console.log('ajax call failed - errorThrown: ' + errorThrown);
		}
    });

    // Cascade changes
    jQuery(event.data.slaveSelectId).change();
}

// Populates the indicated slave select (see slaveSelectId in the event)
// creating the options from the values received from ajax request.
// This function gets the raw data from the database,
// and leaves the responsability of constructing the Options
// to the JavaScript.
// Note that there is no translate for options created from scratch,
// Like "All" example
function populateRamajaxSelectValues(event)
{
    // Empty slave field before filling it
    jQuery(event.data.slaveSelectId).empty();

    // Ajax request
    var masterFieldValue = jQuery(this).find(':selected').val();
    dataString = 'ramajaxName='+event.data.ramajaxName
    dataString += '&masterFieldValue=' + masterFieldValue;
    dataString += '&lang='+event.data.langTag;

    jQuery.ajax({
        type     : 'GET',
        url      : 'index.php?option=com_ramajax&task=ajax.getRamajaxSelectValues&format=json',
        data     : dataString,
        dataType : 'JSON',
        cache    : true,
        success  : function(data) {            
            var output = '<option value>All</option>';
            jQuery.each(data.data, function(i,s){
                var newOption = s;

                output += '<option value="' + newOption + '">' + newOption + '</option>';
            });

            jQuery(event.data.slaveSelectId).empty().append(output);
        },
        error: function(){
            console.log("Ajax failed");
        }
    });

    // Cascade changes
    jQuery(event.data.slaveSelectId).change();
}
