<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MFaculty extends CI_Model{
    private $column = [
        'id', 'id_number', 'faculty_name', 'faculty.date_created', 'type', 'department', 'employment_status', 'dept_id', 'ft_name', 'status_name', 'dept_name', 'course.course_id', 'degree_id', 'degree_title', 'q_id', 'status_id', 'status_name', 'q_title'
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
        $this->db->join('departments', 'departments.dept_id = faculty.department', 'left');
        $this->db->join('faculty_type', 'faculty_type.ft_id = faculty.type', 'left');
        $this->db->join('status', 'status.status_id = faculty.employment_status', 'left');
        $this->db->join('course_taught', 'course_taught.faculty_id = faculty.id', 'left');
        $this->db->join('course', 'course.course_id = course_taught.course_id', 'left');
        $this->db->join('degree', 'degree.faculty_id = faculty.id','left');
        $this->db->join('qualifications', 'qualifications.faculty_id = faculty.id', 'left');
        $this->main->select();
        $i = $this->db->get('faculty');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($datas){
        $this->db->insert('faculty', $datas);
        
        return $this->db->affected_rows();
    }

    public function delete($id){
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }

        $this->db->delete('faculty');

        return $this->db->affected_rows();
    }

    public function update($id, $data){
        $this->db->where('id', $id);
        $this->db->update('faculty', $data);

        return $this->db->affected_rows();
    }

    /**
     * DEGREE
     */

    public function degree_add($datas){
        $this->db->insert_batch('degree', $datas);

        return $this->db->affected_rows();
    }

    public function degree_delete($id, $user){
        $this->db->where('faculty_id', $user);
        $this->db->where_in('degree_id', $id);
        $this->db->delete('degree');
        return $this->db->affected_rows();
    }

    public function degree_update($datas, $user){
        $this->db->where('faculty_id', $user);
        $this->db->update_batch('degree', $datas, 'degree_id');

        return $this->affected_rows();
    }

    /**
     * COURSE TAUGHT
     */

    public function taught_add($datas){
        $this->db->insert_batch('course_taught', $datas);

        return $this->db->affected_rows();
    }

    public function taught_delete($id, $user){
        $this->db->where('faculty_id', $user);
        $this->db->where_in('taught_id', $id);
        $this->db->delete('course_taught');
        return $this->db->affected_rows();
    }

    public function taught_update($datas, $user){
        $this->db->where('faculty_id', $user);
        $this->db->update_batch('course_taught', $datas, 'taught_id');

        return $this->affected_rows();
    }

    /**
     *  QUALIFICATIONS
     */

    public function qualifications_add($datas){
        $this->db->insert_batch('qualifications', $datas);

        return $this->db->affected_rows();
    }

    public function qualifications_delete($id, $user){
        $this->db->where('faculty_id', $user);
        $this->db->where_in('q_id', $id);
        $this->db->delete('qualifications');
        return $this->db->affected_rows();
    }

    public function qualifications_update($datas, $user){
        $this->db->where('faculty_id', $user);
        $this->db->update_batch('qualifications', $datas, 'q_id');

        return $this->affected_rows();
    }

}