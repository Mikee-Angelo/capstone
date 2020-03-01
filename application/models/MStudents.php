<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MStudents extends CI_Model{
    private $column = [
        'id', 'id_number', 'sur_name', 'first_name', 'middle_name', 'course_abbv', 'course_name', 'year_level', 'academic_year', 'birthdate','birth_place', 'gender_name', 'c_name', 'civil_name', 'religion', 'email', 'contact_no', 'p_address', 't_address','mother', 'mother_no', 'father', 'father_no', 'guardian', 'guardian_no', 'img_path', 'students.date_created'
    ];

    private $subject_col = [
        'subject.subject_id', 'course_id', 'subject_code', 'subject_name', 'faculty_name'
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

        $arr =  [
            'data' => $i->result_array()
        ];

        if($type != 'student'){
            $arr['student_count'] = $this->db->count_all('students');
            $arr['report_count'] = $this->db->count_all('report');
            $arr['report_pending'] = $this->db->where('status', '0')->get('report')->num_rows();
        }

        return $arr; 
        // return $this->db->last_query();
    }
    
    /**
     * INITIALIZING MAIN QUERY FOR API
     */
    private function query(){
        $this->main->init($this->id, $this->type, $this->query, $this->column);
        $this->db->join('course', 'course.course_id = students.course', 'left');
        $this->db->join('gender', 'gender.gender_id = students.gender', 'left');
        $this->db->join('citizenship', 'citizenship.c_id = students.citizenship', 'left');
        $this->db->join('civil_status', 'civil_status.civil_id = students.civil_status', 'left');
        $this->main->type_check();
        $this->main->sort();
        $this->db->order_by('sur_name', 'ASC');
        $this->main->select();
        $i = $this->db->get('students');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($id, $datas){
        $this->db->insert_batch('students', $datas);
        
        return $this->db->affected_rows();
    }

    public function delete($id){
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }

        $this->db->delete('students');

        return $this->db->affected_rows();
    }

    /**
     * 
     * GETTING ALL THE STUDENT'S SUBJECT
     */

    public function subjects_fetch($id, $type, $query){
        /**
         * VALIDATING USER
         */
        $this->query = $query;
        $this->type = $type;
        $this->id = $id;

        $i = $this->subjects_query();

        return $i->result_array();
    }

    private function subjects_query(){
        $this->main->init($this->id, $this->type, $this->query, $this->subject_col);
        $this->db->join('students', 'students.id = student_subject.ss_student_id', 'left');
        $this->db->join('subject', 'subject.subject_id = student_subject.ss_subject_id', 'left');
        $this->db->join('subject_faculty', 'subject_faculty.subject_id = subject.subject_id', 'left');
        $this->db->join('faculty', 'subject_faculty.faculty_id = faculty.id', 'left');
        $this->main->sort();
        $this->db->order_by('sur_name', 'ASC');
        $this->main->select();
        $i = $this->db->get('student_subject');
        
        return $i;
    }

    public function subject_add($id, $datas){
        $map = array_map(array('this', $_map), $datas);
        $this->db->insert_batch('student_subject', $map);
        
        return $this->db->affected_rows();
    }
    
    private function _map($datas){
        $arr = [];

        foreach($datas as $r){
            $a['ss_student_id'] = $r['ss_student_id'];
            $a['ss_subject_id'] = $r['ss_subject_id'];

            $arr[] = $a;
        }

        return $arr;
        
    }

    public function subject_delete($id){
        if(is_array($id)){
            $this->db->where_in('id', $id);
        }else{
            $this->db->where('id', $id);
        }

        $this->db->delete('student_subject');

        return $this->db->affected_rows();
    }
}