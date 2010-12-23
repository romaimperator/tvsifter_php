$(document).ready( function() {
    var SEARCH_BOX_TEXT = 'Enter search here...';

    // Hide the unfollow buttons initially
    $('.unfollow').hide();

    // Hide the follow search box
    $('.follow').hide();

    // Bind the click to unfollow()
    $('.unfollow').click(function(e) {
        unfollow($(this).parent().attr('id'));
    });

    // Bind the click to follow()
    $('#follow_search').bind('keyup', function(e) {
        if ($(this).val() != '') {
            search($(this).val());
        } else {
            $('#show_name_matches').remove();
        }
    });

    // Bind on enter to clear the text box
    $('#follow_search').bind('focusin', function(e) {
        // Show the list
        //$('#show_name_matches').show();

        // Clear the box on entry
        if ($(this).val() == SEARCH_BOX_TEXT) {
            $(this).val('');
        }
    });

    // Bind on exit to replace the text
    $('#follow_search').bind('focusout', function(e) {
        // Hide the list
        //$('#show_name_matches').hide();

        // Replace the text in the box on exit
        if ($(this).val() == '') {
            $(this).val(SEARCH_BOX_TEXT);
        }
    });
});

/**
 * Searches the data for matches. Loads data on first request.
 */
function search(query) {
    // If a query for show names has not been done, perform the JSON request
    var data = Array();
    //if ( typeof search.data == 'undefined') {
        $.ajax({
            type: 'GET',
            url: '/shows/all_untracked',
            dataType: 'json',
            success: function(result) { 
                // Cache the result
                data = result;
            },
            data: {},
            async: false
        });

    // Ensure that data was returned before trying to use it
    if (data.length > 0) {
        var matches = Array();

        // Create the regex to match the search query being sure to escape any
        // possible regex characters
        var queryRegex = new RegExp("^"+escape_regex(query)+"\\w*", 'i');

        // Check for any matches and make the list
        $.each(data, function(r, show) {
            if (show.Show.display_name.match(queryRegex)) {
                matches.push(show.Show);
            }
        });

        // Ensure that there were matches before making a list
        if (matches.length > 0) {
            // Create the list element to display the matches in
            create_floating_list('show_name_matches', matches);
        }
    }
}


/**
 * Returns a string with the regex characters escaped
 */
function escape_regex(str)
{
    var specials = new RegExp("[.*+?|()\\[\\]{}\\\\]", "g"); // .*+?|()[]{}\
    return str.replace(specials, "\\$&");
}

/**
 * Creates a floating list
 */
function create_floating_list(list_name, values) {
    // Remove the existing list
    $('#'+list_name).remove();

    // Create the new element
    var list = document.createElement('ul');

    // Create a list item for each match
    $.each(values, function(r, value) {
        var item = document.createElement('li');
        var image_div = document.createElement('div');

        // Set the class for the add button image
        image_div.setAttribute('class', 'autocomplete_image');

        // Set the class for the list item
        item.setAttribute('class', 'autocomplete_item');

        // Set the id to the show id
        item.setAttribute('id', 'follow'+value.id);

        // Add the image div to the list item
        item.appendChild(image_div);

        // Add the matching show name to the list item
        item.appendChild(document.createTextNode(value.display_name));

        // Add the list item to the list
        list.appendChild(item);
    });

    // Set the id of the list
    list.setAttribute('id', list_name);

    // Add the list to the div containing the input box
    $('#search_div').append(list);

    // Position the list just below the input box
    $('#'+list_name).position({
        my: 'left top',
        at: 'bottom left',
        of: $('.follow'),
    });

    // Bind the follow_show to the new button
    bind_follow_show_buttons();
}


/**
 * Binds the follow_show button images to the function
 */
function bind_follow_show_buttons() {
    $('.autocomplete_item').bind('click', function(e) {
        // Ensure that only the list item and divs are matched
        var t = e.currentTarget;
        if (t.nodeName == 'LI') {
            var id = t.id.match(/^follow(\d+)/)[1];
            follow(id);
        } else if (t.nodeName == 'DIV') {
            alert('howdy');
            var id = t.id.match(/^follow(\d+)/)[1];
            follow(id);
        }
    });
}


/**
 * Marks the show as followed with ajax and changes the add button image to the
 * green check image
 */
function follow(id) {
    $.get('/shows/follow/'+id, function(result) {
        // mark the item as added
        $('#follow'+id).addClass('added_show');

        // remove the item from the show cache
    });
}


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

/**
 * Shows the add new show text field
 */
function toggle_follow_show() {
    $('.follow').slideToggle();
}
