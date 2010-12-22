<?php

// Import the sanitizing component
App::import('Sanitize');

class Show extends AppModel {
    // Set the association to the User model
    var $hasAndBelongsToMany = array(
        'User',
    );

    // Set up the association with the Episode model
    var $hasMany = array(
        'Episode',
    );

    // The output format of dates for shows
    var $date_format = 'F j, Y';

    /**
     * Returns the shows that are being tracked by the user specified by user_id
     */
    function get_tracked_shows($user_id) {
        // Sanitize to be safe
        $user_id = Sanitize::clean($user_id);

        // Setup parameters
        $params = array(
            'contain' => FALSE,
            'link' => array(
                'shows_users' => array(
                    'conditions' => array(
                        'shows_users.user_id =' => $user_id,
                        'shows_users.show_id = Show.id',
                    ),
                ),
            ),
            'order' => array(
                'Show.display_name ASC',
            ),
        );

        // Perform query
        $shows = $this->cache('all', $params);

        // Return cleaned list
        return Sanitize::clean($shows);
    }

    /**
     * Returns the date of the next airing of a show which counts a show that
     * airs today
     */
    function get_next_airing($show_id) {
        // Sanitize the id to be safe
        $show_id = Sanitize::clean($show_id);

        // Import the episode model to use to query
        App::import('Model', 'Episode');
        $this->Episode = new Episode();

        // Set the parameters for the query
        $params = array(
            'conditions' => array(
                'Show.id =' => $show_id, // correct show
                'Episode.air_date >=' => date('Y-m-d', time()), // that airs today or later
            ),
            'fields' => array('air_date'), // only need the air date
            'limit' => 1, // only want the first one
            'link' => array(
                'Show', // link with the show
            ),
            'order' => array(
                'Episode.air_date ASC', // order by air date so nearest in time is first
            ),
        );

        // Perform the query
        $episode = $this->Episode->cache('first', $params);

        // Check if there is a next airing or not
        if ( ! isset($episode['Episode']['air_date'])) {
            return 'Not Available';
        } else {
            return date($this->date_format, strtotime($episode['Episode']['air_date']));
        }
    }


    /**
     * Returns the date of the last airing of a show before today
     */
    function get_last_airing($show_id) {
        // Sanitize the id to be safe
        $show_id = Sanitize::clean($show_id);

        // Import the episode model to use to query
        App::import('Model', 'Episode');
        $this->Episode = new Episode();

        // Set the parameters for the query
        $params = array(
            'conditions' => array(
                'Show.id =' => $show_id, // correct show
                'Episode.air_date <' => date('Y-m-d', time()), // that airs before today
            ),
            'fields' => array('air_date'), // only need the air date
            'limit' => 1, // only want the first one
            'link' => array(
                'Show', // link with the show
            ),
            'order' => array(
                'Episode.air_date DESC', // order by air date so nearest in time is first
            ),
        );

        // Perform the query
        $episode = $this->Episode->cache('first', $params);

        // Check if there is a next airing or not
        if ( ! isset($episode['Episode']['air_date'])) {
            return 'Not Available';
        } else {
            return date($this->date_format, strtotime($episode['Episode']['air_date']));
        }
    }


/*******************************/
/* BEGIN THE REFRESH FUNCTIONS */
/*******************************/
    function parse_html($html) {
        // Load the html into the html parser
	libxml_use_internal_errors(true);
        $dom = DOMDocument::loadHtml($html);

        // Grab a domxpath object
        $domxpath = new DOMXPath($dom);

        // Retrieve the dom elements with the 'brow' id. These include the
        // tables with the episode information.
        $episodes = $this->_get_element_by_id($dom, 'brow');
        foreach($episodes as $e) {
            $this->_parse_episode($e);
        }
	return $this->_set_max_season();
    }


    function _set_max_season() {
	$params = array(
	    'fields' => array('show_id', 'season'),
	    'conditions' => array('Episode.show_id =' => $this->id),
	    'contain' => false,
	    'order' => array('Episode.overall_episode DESC'),
	);
	$e = $this->Episode->find('first', $params);
	$this->set('season_count', $e['Episode']['season']);
	$this->save();
	return "<h1>SAVE SUCCESS!</h1>";
    }


    function _parse_episode($dom_element) {
        $this->Episode->create();
        $s_e = $this->_parse_episode_season($dom_element);
        if ($s_e) {
            $overall_episode = $this->_parse_overall_episode($dom_element);
            $show_id = $this->id;

            // Only continue if this episode does not already exist
            $params = array(
                'contain' => false,
                'conditions' => array(
                    'Episode.overall_episode =' => $overall_episode,
                    'Episode.show_id =' => $show_id,
                ),
                'fields' => array('overall_episode', 'show_id'),
            );
            if ( ! $this->Episode->find('first', $params)) {
                $name = $this->_parse_name($dom_element);
                $episode = $s_e[2];
                $season = $s_e[1];
                $air_date = $this->_parse_air_date($dom_element);

                $this->Episode->set('name', $name);
                $this->Episode->set('overall_episode', $overall_episode);
                $this->Episode->set('episode', $episode);
                $this->Episode->set('season', $season);
                $this->Episode->set('air_date', $air_date);
                $this->Episode->set('show_id', $show_id);
                $this->Episode->save();
            }
        }
    }


    function _parse_name($dom_element) {
        $element = $dom_element->childNodes->item(6);
        //echo "element value:'",$element->nodeValue,"'";
        return str_replace("\n", "", trim($element->nodeValue));
    }

    function _parse_air_date($dom_element) {
        $element = $dom_element->childNodes->item(4);
        //echo "element value:'",$element->nodeValue,"'";
        $date = str_replace(array(" ","\n"), "", $element->nodeValue);
        $match = array();
        preg_match("/(\d+)\/(\w+)\/(\d+)/", $date, $match);
        return date( 'Y-m-d H:i:s', strtotime($match[2].'-'.$match[1].'-'.$match[3]));
    }


    function _parse_episode_season($dom_element) {
        $element = $dom_element->childNodes->item(2);
        $match = array();
        //echo "element value:'",$element->nodeValue,"'";
        preg_match("/(\d+)x(\d+)/", trim($element->nodeValue), $match);
        return $match;
    }


    function _parse_overall_episode($dom_element) {
        $oe_element = $dom_element->childNodes->item(0);
        return trim($oe_element->nodeValue);
    }


    function _get_element_by_id($dom, $id) {
        // return the elements that match the given id
        $xpath = new DOMXPath($dom);
        return $xpath->query("//*[@id='$id']");
    }
/*****************************/
/* END THE REFRESH FUNCTIONS */
/*****************************/
}
