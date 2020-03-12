<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MSubjects extends CI_Model{
    private $column = [
        'subject_id', 'course.course_id', 'subject_code', 'subject_name', 'subject.date_created'
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
        $this->db->join('course', 'course.course_id = subject.course_id');
        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('subject');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($id, $datas){
        $this->db->insert('subject  ', $datas);
        
        return $this->db->affected_rows();
    }

    public function delete($id){
        if(is_array($id)){
            $this->db->where_in('subject_id', $id);
        }else{
            $this->db->where('subject_id', $id);
        }

        $this->db->delete('subject');

        return $this->db->affected_rows();
    }

    public function update($data){
        $id = $data['id'];
        unset($data['id']);
        
        $this->db->where('subject_id', $id);
        $this->db->update('subject', $data);

        return $this->db->affected_rows();
    }
}