<?php

App::import('Core', 'Security');

class RefreshShell extends Shell {
    var $uses = array('Show'); 
    var $tasks = array('Daemon'); 

    function refresh() { 
        $this->Daemon->execute('refresh'); 
        //Configure::write('debug', 0); 
        $this->out('Beginning refresh...'); 
        $this->Show->refresh_all();
        $this->out('Ending refresh...');
    } 
}
