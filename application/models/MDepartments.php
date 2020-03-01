<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MDepartments extends CI_Model{
    private $column = [
        'dept_id', 'dept_name'
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
        $this->main->type_check();
        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('departments');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($id, $datas){
        $this->db->insert_batch('departments', $datas);
        
        return $this->db->affected_rows();
    }

    public function delete($id){
        if(is_array($id)){
            $this->db->where_in('dept_id', $id);
        }else{
            $this->db->where('dept_id', $id);
        }

        $this->db->delete('departments');

        return $this->db->affected_rows();
    }

    public function update($id , $data){
        $this->db->where('dept_id', $id);
        $this->db->update('departments', $data);

        return $this->db->affected_rows();
    }
}