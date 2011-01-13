<?php

App::import('Sanitize');

class EpisodesController extends AppController {
    var $components = array(
        'RequestHandler',
    );
    
    /**
     * Retrieves the episodes for the show with the matching show id and of the
     * season given. If the season is not given or a season 0 then all episodes
     * are returned.
     *
     * @param show_id id of the show
     * @param season season number or 0 for all seasons
     */
    function get_episodes($show_id, $season=0) {
        if ($this->params['isAjax']) {
            $this->layout = 'ajax';

            // Sanitize the input
            $show_id = Sanitize::clean($show_id);
            $season = Sanitize::clean($season);

            // Retrieve the episodes
            $episodes = Sanitize::clean($this->Episode->get_episodes($show_id, $season));

            // Set the output
            $this->set(compact('episodes'));
        }
    }


    /**
     * Retrieves the episodes for the show with the matching show id and of the
     * season given. If the season is not given or a season 0 then all episodes
     * are returned. The air dates are raw so this is meant to be retrieved via
     * ajax and some front-end processing done to make the unknown dates
     * presentable.
     *
     * @param show_id id of the show
     * @param season season number or 0 for all seasons
     */
    function get_raw_episodes($show_id, $season=0) {
        if ($this->params['isAjax']) {
            $this->layout = 'ajax';

            // Sanitize the input
            $show_id = Sanitize::clean($show_id);
            $season = Sanitize::clean($season);

            // Retrieve the episodes
            $episodes = Sanitize::clean($this->Episode->get_raw_episodes($show_id, $season));

            // Set the output
            $this->set(compact('episodes'));
        }
    }
}
