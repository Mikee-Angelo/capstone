<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MCivil_status extends CI_Model{
    private $column = ['civil_id', 'civil_name'], $query, $id, $type;
    /**
     * FOR GET SERVICES
     */
    public function fetch($id, $type, $query){
        /**
         * VALIDATING USER
         */
        $this->query = $query;
        $this->type = $type;
        $this->id = $id;

        $i = $this->query();

        return $i->result_array();
    }
      
    /**
     * INITIALIZING MAIN QUERY FOR API
     */
    private function query(){
        $this->main->init($this->id, $this->type, $this->query, $this->column);
        $this->main->select();
        $i = $this->db->get('civil_status');
        
        return $i;
    }
}