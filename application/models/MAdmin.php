<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MAdmin extends CI_Model{
    private $column = [
        'id', 'username', 'date_created'
    ];

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
        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('admin');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($datas){
        $this->db->insert('admin', $datas);
        
        return $this->db->affected_rows();
    }

    public function delete($id){
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }

        $this->db->delete('admin');

        return $this->db->affected_rows();
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        $this->db->update('admin', $data);

        return $this->db->affected_rows();
    }
}