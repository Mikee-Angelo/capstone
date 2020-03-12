<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MCourse extends CI_Model{
    private $column = [
        'course_id', 'department_id', 'course_abbv', 'course_name', 'course_type', 'course_type_name'
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
        $this->db->join('course_type' , 'course_type.course_type_id = course.course_type');
        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('course');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($datas){
        $id = $datas['department_id'];

        $this->db->select('dept_id');
        $this->db->where('dept_id', $datas['department_id']);
        $i = $this->db->get('departments');

        if($i->num_rows() == 0){
            return FALSE;
        }

        $fill = array_fill(0, count($datas['course_name']), $id);
        $map = array_map(array($this , '_arrayCourse'), $fill , $datas['course_abbv'], $datas['course_name'], $datas['course_type']);

        // var_dump($fill);
        $this->db->insert_batch('course', $map);
        
        return $this->db->affected_rows();
    }

    private function _arrayCourse($id, $abbv, $name, $type){
        $arr = [
            'department_id' => $id,
            'course_type' => $type,
            'course_abbv' => $abbv,
            'course_name' => $name
        ];

        return $arr;

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

    public function update($data){
        $id = $data['course_id'];
        unset($data['course_id']);
        
        $this->db->where('course_id', $id);
        $this->db->update('course', $data);

        return $this->db->affected_rows();
    }
}