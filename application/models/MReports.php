<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MReports extends CI_Model{
    private $column = [
        'report_id', 'students.id', 'case_name','narration_incident', 'remark', 'report.date_created', 'ra_name', 'report_witness.student_id', 'witness_statement', 'status_name', 'ra_id', 'ra_name', 
    ];

    private $column_reported = [
        'case_name', 'ra_name', 'status_name', 'rs_id', 'rs_student_id', 'rs_report_id', 'id_number', 'sur_name', 'first_name', 'middle_name', 'course_abbv', 'year_level', 'report.date_created'
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
        $r = $this->reported_get_all();
        $arr = [];

        // var_dump($r);

        foreach($i as $k => $v){   
            foreach($r as $k1 => $v1){
                if($v['report_id'] == $v1['rs_report_id']){
                    unset($v1['rs_report_id']);
                    
                    $v['report_students'][] = $v1;
                    unset($v1);
                }
            }

            if(!array_key_exists('report_students', $v)){
                $v['report_students'] = [];
            }

            $arr[] = $v;
        }

        return $arr ;
        
    }
    
    /**
     * INITIALIZING MAIN QUERY FOR API
     */
    private function query(){

        $walk = $this->_changeKey($this->query);

        $this->main->init($this->id, $this->type, $walk, $this->column);
        $this->main->type_check();
        $this->db->join('students', 'students.id = report.student_id', 'left');
        $this->db->join('report_action', 'report_action.ra_id = report.action_taken', 'left');
        $this->db->join('report_witness', 'report_witness.rw_report_id = report.report_id','left');
        $this->db->join('status', 'status.status_id = report.status', 'left');

        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('report');
        
        return $i->result_array();
    }


    private function reported_get_all(){
        
        if(array_key_exists('report_id', $this->query)){
            $this->db->where('rs_report_id', $this->query['report_id']);
        }

        $column_reported = [
            'rs_report_id', 'rs_id', 'rs_student_id', 'id_number', 'sur_name', 'first_name', 'middle_name', 'course_abbv', 'year_level', 'report.date_created'
        ];

        $this->db->select($column_reported);
        $this->db->join('report', 'report.report_id = report_students.rs_report_id', 'left');
        $this->db->join('students', 'students.id = report_students.rs_student_id', 'left');
        $this->db->join('report_action', 'report_action.ra_id = report.action_taken', 'left');
        $this->db->join('course', 'course.course_id = students.course', 'left');
        $this->db->join('status', 'status.status_id = report.status', 'left');
        $i = $this->db->get('report_students');

        return $i->result_array();
    }

    private function _changeKey($arr){
        $datas = [];
        
        foreach($arr as $k => $v){
            if($k == 'student_id'){
                $datas['students.id'] = $v;
            }else{
                $datas[$k] = $v;
            }

            switch($k){
                case 'student_id':
                    $datas['students.id'] = $v;
                break;

                case 'date_created':
                    $datas['report.date_created'] = $v;
                break; 

                case 'witness_id':
                    $datas['report_witness.student_id'] = $v;
                break; 

                default:    
                    $datas[$k] = $v;
            }
        }

        return $datas;
    }

    /**
     * FOR POST SERVICES
     */
    public function add_student($data){
        $arr = ['student_id', 'narration_incident'];

        $i = $this->arrayutils->permittedKeys($data, $arr);

        $this->db->insert('report', $i);

        if($this->db->affected_rows() > 0){
            $id = $this->db->insert_id();
            $s = $datas['rs_student_id'];

            $r = $this->_formatter($id, $students);

            $this->db->insert_batch('report_students', $r);

            return $this->db->affected_rows();
        }

        return FALSE;
    }

    public function add_admin($datas){
        unset($datas['witness_statement']);

        $arr = [ 'case_name', 'narration_incident', 'witness_statement','action_taken', 'remark', 'student_id'];
        
        $i = $this->arrayutils->permittedKeys($datas, $arr);
        array_merge($i, ['status' => 1]);

        $this->db->insert('report', $i);
    
        if($this->db->affected_rows() > 0){
            $id = $this->db->insert_id();
            $students = $datas['rs_student_id'];

            $r = $this->_formatter($id, $students);

            $this->db->insert_batch('report_students', $r);

            return $this->db->affected_rows();

        }

        return FALSE;
    }

    private function _formatter($id, $val){
        $arr = [];

        for($x = 0 ; $x < count($val); $x++){
            $a['rs_student_id'] = $val[$x];
            $a['rs_report_id'] = $id;

            $arr[] = $a;
        }

        return $arr;
    }


    public function delete($user, $type, $id){
        if($type == 'student'){
            $this->db->where('student_id', $user);
        }

        if(is_array($id)){
            $this->db->where_in('report_id', $id);
        }else{
            $this->db->where('report_id', $id);
        }

        $this->db->delete('report');

        return $this->db->affected_rows();
    }

    public function update($type, $data){
        $this->db->where('status', 0);
        $this->db->where('report_id', $data['report_id']);
        $this->db->update('report', $data);

        return $this->db->affected_rows();
    }

    /**
     * REPORTED STUDENTS
     */


      /**
     * INITIALIZING MAIN QUERY FOR API
     */

    public function reported_get($id, $type, $query){
        $this->_changeKey($query);
        $this->main->init($id, $type, $query, $this->column_reported);
        $this->db->join('report', 'report.report_id = report_students.rs_report_id', 'left');
        $this->db->join('students', 'students.id = report_students.rs_student_id', 'left');
        $this->db->join('course', 'course.course_id = students.course', 'left');
        $this->db->join('status', 'status.status_id = report.status', 'left');
        $this->db->join('report_action', 'report_action.ra_id = report.action_taken', 'left');

        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('report_students');

        return $i->result_array();
    }
}