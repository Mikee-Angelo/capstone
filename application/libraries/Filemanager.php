<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager {
        /* 
    * php delete function that deals with directories recursively
    */
    public function delete_files($target) {
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file ){
                delete_files( $file );      
            }

            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
}