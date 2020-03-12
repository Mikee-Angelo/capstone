<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MFaculty extends CI_Model{
    private $column = [
        'id', 'faculty_type', 'faculty_type_name', 'id_number', 'faculty_sur_name', 'faculty_first_name', 'faculty_middle_name', 'faculty.date_created', 'department', 'employment_status', 'dept_name', 'status_id', 'status_name'
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
        
        $sf = $this->subject_faculty();
        $q = $this->qualifications();
        $d = $this->degree();
        $arr = [];
        // var_dump($r);

        foreach($i as $k => $v){   
            /**
             * Matching course taught to the faculty
             */

            if(!empty($sf)){
                foreach($sf as $k1 => $v1){
                    if($v['id'] == $v1['sf_faculty_id']){
                        unset($v1['sf_faculty_id']);
    
                        $v['course_taught'][] = $v1;
                        unset($v1);
                    }
                }
                
                if(!array_key_exists('course_taught', $v)){
                    $v['course_taught'] = [];
                }

            }

            /**
             * Matching qualifications to the faculty
             */

            if(!empty($q)){
                foreach($q as $k1 => $v1){
                    if($v['id'] == $v1['q_faculty_id']){
                        unset($v1['q_faculty_id']);
    
                        $v['qualifications'][] = $v1;
                        unset($v1);
                    }
                }


                if(!array_key_exists('qualifications', $v)){
                    $v['qualifications'] = [];
                }
            
            }

            /**
             * Matching qualifications to the faculty
             */

            if(!empty($d)){
                foreach($d as $k1 => $v1){
                    if($v['id'] == $v1['degree_faculty_id']){
                        unset($v1['degree_faculty_id']);
    
                        $v['degree'][] = $v1;
                        unset($v1);
                    }
                }

                if(!array_key_exists('degree', $v)){
                    $v['degree'] = [];
                }
            }


            $arr[] = $v;
        }
        return $arr;
    }
    
    /**
     * INITIALIZING MAIN QUERY FOR API
     */
    private function query(){
        $this->main->init($this->id, $this->type, $this->query, $this->column);
        $this->db->join('faculty_type', 'faculty_type.faculty_type_id = faculty.faculty_type');
        $this->db->join('departments', 'departments.dept_id = faculty.department', 'left');
        $this->db->join('status', 'status.status_id = faculty.employment_status', 'left');
        $this->main->type_check();
        $this->main->select();
        $i = $this->db->get('faculty');
        
        return $i->result_array();
    }

    private function subject_faculty(){

        if(array_key_exists('fields', $this->query)){
            $arr = explode(',',$this->query['fields']);

            if(!in_array('course_taught', $arr)){
                return [];
            }
        }

        $column = [
            'sf_id', 'sf_faculty_id', 'subject_name'
        ];

        $this->main->init($this->id, $this->type, [], $column);
        $this->db->distinct();
        $this->db->join('subject', 'subject.subject_id = subject_faculty.sf_subject_id');
        $this->main->select();
        $this->main->type_check();
        $i = $this->db->get('subject_faculty');

        return $i->result_array();
    }

    private function qualifications(){
        if(array_key_exists('fields', $this->query)){
            $arr = explode(',',$this->query['fields']);

            if(!in_array('qualifications', $arr)){
                return [];
            }
        }

        $column = [
            'q_id', 'q_title', 'q_faculty_id'
        ];

        $this->main->init($this->id, $this->type, [], $column);
        $this->main->type_check();
        $this->main->select();
        $i = $this->db->get('qualifications');

        return $i->result_array();
    }

    private function degree(){
        if(array_key_exists('fields', $this->query)){
            $arr = explode(',',$this->query['fields']);

            if(!in_array('degree', $arr)){
                return [];
            }
        }

        $column = [
            'degree_id', 'degree_title', 'degree_faculty_id'
        ];

        $this->main->init($this->id, $this->type, [], $column);
        $this->main->type_check();
        $this->main->select();
        $i = $this->db->get('degree');

        return $i->result_array();
    }
    //Adding Faculty
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

    public function update($data){
        $arr1 = [];
        $id = $data['id'];

        unset($data['id']);

        $this->db->update('faculty', $data , ['id' => $id]);

        return $this->db->affected_rows();
    }

    /**
     * DEGREE
     */

    public function degree_add($datas){
        $this->db->insert_batch('degree', $datas);

        return $this->db->affected_rows();
    }

    public function degree_delete($id){
        $this->db->where_in('degree_id', $id);
        $this->db->delete('degree');
        return $this->db->affected_rows();
    }

    public function degree_update($datas){
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

    public function taught_delete($id){
        $this->db->where_in('taught_id', $id);
        $this->db->delete('course_taught');

        return $this->db->affected_rows();
    }

    public function taught_update($datas){
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

    public function qualifications_delete($id){
        $this->db->where_in('q_id', $id);
        $this->db->delete('qualifications');
        return $this->db->affected_rows();
    }

    public function qualifications_update($datas){
        $this->db->update_batch('qualifications', $datas, 'q_id');

        return $this->affected_rows();
    }

    public function set_profile_img($id, $img){
        $this->db->update(
            'faculty',
            [ 'faculty_img_path' => $img],
            [ 'id' => $id]
        );

        return $this->db->affected_rows();
    }
}