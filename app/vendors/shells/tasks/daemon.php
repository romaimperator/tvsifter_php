<?php  
class DaemonTask extends Shell { 

   function execute($prefix = '') { 
           //the key the pid is stored with - default to just 'pid' 
           $pidstring = $prefix . 'pid'; 
        if(!Cache::read($pidstring)){ 
            Cache::write($pidstring, getmypid(), 3600);     
        }else{ 
            $ps = shell_exec('ps -o pid -A'); 
            $ps = explode("\n", trim($ps)); 
            foreach($ps as $key => &$value){ 
                $value = trim($value); 
            } 
            if(in_array(Cache::read($pidstring), $ps)){ 
                exit("already got a process running\n"); 
            }else{ 
                echo "replacing stale pid\n"; 
                Cache::write($pidstring, getmypid(), 3600);     
            } 
        } 
    } 
} 
?>
