<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authlogin extends CI_Model{

    public function init($user, $pwd){
        /**
         * TABLE_NAME - admin
         * COLUMN_NAME - a_user, a_pwd, a_id, a_user
         */
        $q = $this->db->select('a_user, a_pwd, a_id')->from('admin')->where('a_user', $user)->get();
        $row = $q->row();

        if($q->num_rows() == 0){
            return FALSE;
        }
 
        /**
         * DECRYPTING HASHED PASSWORD
         */
        if(password_verify($pwd, $row->a_pwd)){
            $this->db->insert('action_logs', ['message' => 'Admin Logged In']);
            return [
                'id' => $row->a_id,
                'user' => $user
            ];
        }

        return NULL;   
    }
}