<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MDepartments extends CI_Model{
    private $column = [
        'dept_id', 'dept_name', 'dept_abbv', 'dept_img_path'
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
    public function add($datas){
        $this->db->insert('departments', $datas);
        
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

    public function update($data){
        $id = $data['dept_id'];
        unset($data['dept_id']);
        
        $this->db->where('dept_id', $id);
        $this->db->update('departments', $data);

        return $this->db->affected_rows();
    }

    /**
     * STUDENTS PROFILE PICTURE UPLOADED BY THE ADMIN
     */
    
    public function set_profile_img($id, $img){
        $this->db->update(
            'departments',
            [ 'dept_img_path' => $img],
            [ 'dept_id' => $id]
        );

        return $this->db->affected_rows();
    }

}