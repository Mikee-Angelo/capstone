<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authlogin extends CI_Model{

    public function student($user, $pwd){
        /**
         * TABLE_NAME - admin
         * COLUMN_NAME - id_number, password, id, id_number
         */
        $q = $this->db->select('id_number, password, id')->from('students')->where('id_number', $user)->get();
        $row = $q->row();

        if($q->num_rows() == 0){
            return FALSE;
        }
 
        /**
         * DECRYPTING HASHED PASSWORD
         */
        if(password_verify($pwd, $row->password)){
            return [
                'type' => 'student',
                'id' => $row->id,
                'user' => $user
            ];
        }

        return NULL;   
    }

    public function admin($user, $pwd){
        /**
         * TABLE_NAME - admin
         * COLUMN_NAME - id_number, password, id, id_number
         */
        $q = $this->db->select('username, password, id')->from('admin')->where('username', $user)->get();
        $row = $q->row();

        if($q->num_rows() == 0){
            return FALSE;
        }
 
        /**
         * DECRYPTING HASHED PASSWORD
         */
        if(password_verify($pwd, $row->password)){
            return [
                'type' => 'admin',
                'id' => $row->id,
                'user' => $user
            ];
        }

        return NULL;   
    }

    public function faculty($user, $pwd){
        /**
         * TABLE_NAME - admin
         * COLUMN_NAME - id_number, password, id, id_number
         */
        $q = $this->db->select('id_number, password, id, type')->from('faculty')->where('id_number', $user)->get();
        $row = $q->row();

        if($q->num_rows() == 0){
            return FALSE;
        }
 
        /**
         * DECRYPTING HASHED PASSWORD
         */
        if(password_verify($pwd, $row->password)){
            return [
                'type' => 'faculty',
                'role' => $row->type,
                'id' => $row->id,
                'user' => $user
            ];
        }

        return NULL;   
    }

}