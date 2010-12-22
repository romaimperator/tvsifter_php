$(document).ready( function() {
    // Hide the unfollow buttons initially
    $('.unfollow').hide();

    // Bind the click to unfollow()
    $('.unfollow').click(function(e) {
        unfollow($(this).parent().attr('id'));
    });
});

/**
 * Toggles showing the remove button.
 */
function unfollow_show() {
    $('.unfollow').toggle();
}

/**
 * Does Ajax to remove the show from tracking.
 */
function unfollow(id) {
    $.get('/shows/unfollow/' + id, function(result, textStatus) {
        // After Ajax call fade out the show
        if (textStatus == 'success') {
            $('#' + id).fadeOut();
        }
    });
}
