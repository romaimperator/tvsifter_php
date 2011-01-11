
/**
 * Shows all of the episodes for the show
 */
function show_all() {
    show(0);
}


/**
 * Changes the episode table to only show the episodes from the given season
 */
function show(season) {
    var show_id = $('#show_id').attr("value");
    var request_url = '/episodes/get_raw_episodes/'+show_id+'/'+season;

    if (typeof(show_id) != 'undefined' && typeof(show_id) != 'undefined') {
        // Retrieve the episodes
        $.getJSON('/episodes/get_episodes/'+show_id+'/'+season, function(result) {
            // Reset the current table
            reset_table();

            // Create the new table
            create_table();

            // Process the result
            process_episodes(result);
        });
    }
}

function process_episodes(result) {
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                  'September', 'October', 'November', 'December'];

    var current_day = new Date();
    current_day.setTime(current_day.getTime() - (1000*60*60*24));
    var unaired = false;

    // Loop through the results
    $.each(result, function(r, episode) {
        var d = new Date(episode.Episode.air_date);

        // Check if the aired separator is needed yet
        if ( ! unaired && d < current_day) {
            var tr = "<tr class=\"separator\"><td colspan=\"4\"><span class=\"left\">Previously Aired</span><hr></td></tr>";
            $('#episodes_table').append(tr);
            unaired = true;
        }

        // Create the tds for the episode information
        var name = "<td>" + episode.Episode.name + "</td>";
        var season = "<td class=\"center\">" + episode.Episode.season + "</td>";
        var episode_item = "<td class=\"center\">" + episode.Episode.episode + "</td>";

        // Get the air_date and format it
        var air_date ="";

        // Check if the date is unknown since we're dealing with the
        // raw episode data
        if (d.getTime() <= 0 || isNaN(d.getTime())) {
            air_date = "<td class=\"center\">Unknown</td>";
        } else {
            air_date = "<td class=\"center\">" + months[d.getMonth()] + ' ' + d.getDate() + ', ' + d.getFullYear() + "</td>";
        }

        // Merge together for the entire row
        var tr = "<tr>" + name + season + episode_item + air_date + "</tr>";

        // Append the row to the table
        $('#episodes_table').append(tr);
    });
}

                    /*<tr class="separator">
                        <td colspan="4">
                            <span class="left">Previously Aired</span>
                            <hr>
                        </td>
                    </tr>*/

/**
 * Clears the current entries in the table
 */
function reset_table() {
    $('#episodes_table').html('');
}


/**
 * Creates the header row for the table
 */
function create_table() {
    var name = "<th>Name</th>";
    var season = "<th>Season</th>";
    var episode = "<th>Episode</th>";
    var air_date = "<th>Air Date</th>";

    $('#episodes_table').html('<tr>' + name + season + episode + air_date + '</tr>');
}
