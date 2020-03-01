<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MReports extends CI_Model{
    private $column = [
        'report_id', 'students.id', 'case_name','narration_incident', 'remark', 'report.date_created', 'ra_name', 'report_witness.student_id', 'witness_statement', 'status_name', 'ra_id', 'ra_name '
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
        $this->db->join('students', 'students.id = report.student_id');
        $this->db->join('report_action', 'report_action.ra_id = report.action_taken', 'left');
        $this->db->join('report_witness', 'report_witness.rw_report_id = report.report_id','left');
        $this->db->join('status', 'status.status_id = report.status', 'left');
        
        $this->main->sort();
        $this->main->select();
        $i = $this->db->get('report');
        
        return $i;
    }

    /**
     * FOR POST SERVICES
     */
    public function add($datas){
        $this->db->insert('report', $datas);
        
        return $this->db->affected_rows();
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
}