<?php

App::import('Core', 'Security');

class RefreshShell extends Shell {
    var $uses = array('Show'); 
    var $tasks = array('Daemon'); 

    function refresh() { 
        $this->Daemon->execute('refresh'); 
        //Configure::write('debug', 0); 
        $start = time();
        $this->out(date('Y-m-d H:i:s', time()).' Beginning refresh...'); 
        $this->Show->refresh_all();
        $this->out(date('Y-m-d H:i:s', time()).' Ending refresh...');
        $end = time();
        $this->out('Update took '.$end-$start.' seconds to complete.');
    } 
}
