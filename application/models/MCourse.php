<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MCourse extends CI_Model{
    private $column = [
        'course_id', 'department_id', 'course_name'
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
        $i = $this->db->get('course');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($id, $datas){
        $this->db->insert('course', $datas);
        
        return $this->db->affected_rows();
    }

    public function delete($id){
        if(is_array($id)){
            $this->db->where_in('course_id', $id);
        }else{
            $this->db->where('course_id', $id);
        }

        $this->db->delete('course');

        return $this->db->affected_rows();
    }

    public function update($id, $data){
        $this->db->where('course_id', $id);
        $this->db->update('course', $data);

        return $this->db->affected_rows();
    }
}