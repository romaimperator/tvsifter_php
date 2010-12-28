<?php

App::import('Sanitize');

class Episode extends AppModel {
    // Set up association with Show model
    var $belongsTo = array(
        'Show' => array(
            'counterCache' => TRUE,
        ),
    );

    /**
     * Returns a list of episodes for the show and season numbers
     *
     * @param show_id the id of the show
     * @param season the season to return, 0 for all seasons
     */
    function get_episodes($show_id, $season) {
        // Sanitize the arguments
        $show_id = Sanitize::clean($show_id);
        $season = Sanitize::clean($season);

        // Setup query parameters
        $params = array(
            'contain' => FALSE,
            'conditions' => array(
                'Episode.show_id =' => $show_id,
            ),
            'order' => array(
                'Episode.season DESC',
                'Episode.episode DESC',
            ),
        );

        // Filter by season if needed
        if ($season !== 0) {
            $params['conditions'][] = 'Episode.season = '.$season;
        }

        // Perform query
        $episodes = $this->cache('all', $params);

        // Filter air dates
        $episodes = $this->filter_episodes($episodes);

        return Sanitize::clean($episodes);
    }


    /**
     * Returns a list of episodes with the air date filtered.
     * If the air date is the default of 0 or Jan 1970 then replace with the
     * text "Unknown"
     */
    function filter_episodes($episodes) {
        // Make sure what we have is an array
        if ( ! is_array($episodes)) {
            $episodes = array($episodes);
        }

        // Loop through the episodes replacing the Jan 1970 dates with Unknown
        foreach($episodes as &$e) {
            if (isset($e['air_date'])) {
                if (strtotime($e['air_date']) <= 0) {
                    $e['air_date'] = 'Unknown';
                }
            } else if (isset($e['Episode']['air_date'])) {
                if (strtotime($e['Episode']['air_date']) <= 0) {
                    $e['Episode']['air_date'] = 'Unknown';
                }
            } else {
                debug('In filter_episodes of the episode model the input format did not match what was expected.');
            }
        }

        return $episodes;
    }
}
