// window.onload = function () { 
//     jQuery('#filter_league').val().change();
//     //dom not only ready, but everything is loaded
// }

jQuery(document).ready(function() {
    
    langTagVal = jQuery("#langTag").val();

    // ajax request for team
    jQuery('#filter_league').change(
        {
            ramajaxName:"team",
            slaveSelectId:"#filter_team",
            langTag:langTagVal
        }, 
        populateRamajaxSelectOptions);

    // ajax request for player
    jQuery('#filter_team').change(
        {
            ramajaxName:"player",
            slaveSelectId:"#filter_player",
            langTag:langTagVal
        }, 
        populateRamajaxSelectOptions);

    // ajax request for player
    jQuery('#filter_player_country').change(
        {
            ramajaxName:"player_state",
            slaveSelectId:"#filter_player_state",
            langTag:langTagVal
        }, 
        populateRamajaxSelectOptions);

    // ajax request for player
    jQuery('#filter_player_state').change(
        {
            ramajaxName:"player_city",
            slaveSelectId:"#filter_player_city",
            langTag:langTagVal
        }, 
        populateRamajaxSelectOptions);

    // reset button
    jQuery('#filter_clear').click(filter_clear);

    // Reset function
    // Because changes cascade, we only need to reset the first element of the chain
    function filter_clear()
    {
        jQuery('#filter_league').val("").change();
        jQuery('#filter_player_country').val("").change();
    }
});
