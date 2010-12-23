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
        if ($(this).val() == SEARCH_BOX_TEXT) {
            $(this).val('');
        }
    });

    // Bind on exit to replace the text
    $('#follow_search').bind('focusout', function(e) {
        if ($(this).val() == '') {
            $(this).val(SEARCH_BOX_TEXT);
        }
    });

    //var data = new Array('House', 'How I Met Your Mother');
});

/**
 * Searches the data for matches. Loads data on first request.
 */
function search(query) {
    if ( typeof search.data == 'undefined') {
        $.ajax({
            type: 'GET',
            url: '/shows/all',
            dataType: 'json',
            success: function(result) { 
                search.data = result;
            },
            data: {},
            async: false
        });
        /*$.getJSON('/shows/all', function(result) {
            search.data = result;
            alert("'"+search.data+"'");
        });*/
    }

    var matches = Array();
    var queryRegex = new RegExp("^"+escape_regex(query)+"\\w*", 'i');

    $.each(search.data, function(r, show) {
        if (show.Show.display_name.match(queryRegex)) {
            matches.push(show.Show.display_name);
        }
    });

    create_floating_list('show_name_matches', matches);
}


function escape_regex(str)
{
    var specials = new RegExp("[.*+?|()\\[\\]{}\\\\]", "g"); // .*+?|()[]{}\
    return str.replace(specials, "\\$&");
}

/**
 * Creates a floating list
 */
function create_floating_list(list_name, values) {
    $('#'+list_name).remove();

    //var iframe = document.createElement('iframe');
    var list = document.createElement('ul');
    $.each(values, function(r, value) {
        var item = document.createElement('li');
        var image_div = document.createElement('div');

        image_div.setAttribute('class', 'autocomplete_image');

        item.setAttribute('class', 'autocomplete_item');

        item.appendChild(image_div);
        item.appendChild(document.createTextNode(value));

        list.appendChild(item);
    });

    var style = 'position:absolute; background-color: #fff; border: 1px solid;';

    list.setAttribute('style', style);
    list.setAttribute('id', list_name);
    $('#search_div').append(list);
    $('#'+list_name).position({
        my: 'left top',
        at: 'bottom left',
        of: $('.follow'),
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
