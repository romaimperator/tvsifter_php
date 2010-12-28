$(document).ready( function() {

    if ( ! $('#email_form form div').hasClass('error')) {
        $('#email_form').hide();
    }
});

/**
 * Show the edit email form
 */
function toggle_email() {
    $('#email_form').show();
}
