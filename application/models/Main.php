<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Model{
    private $query, $type, $id, $column;
    private $reserved = ['sort', 'fields', 'limit', 'absolute'];

    public function init($id = '', $type = '', $query, $column){
        $this->id = $id;
        $this->type = $type;
        $this->query = $query;
        $this->column = $column;
    }

    public function select(){
        if(array_key_exists($this->reserved[1], $this->query)){
            if(!empty($this->query['fields'])){
                $arr = explode(',',$this->query['fields']);

                if(empty(array_diff($arr, $this->column))){
                    $this->db->select($this->query['fields']);
                }
            }
        }else{ 
            $this->db->select($this->column);
        }

        $intersect = array_intersect_key($this->query, array_flip($this->column));

        if(!empty($intersect)){
            if(array_key_exists($this->reserved[3], $this->query)){

                if($this->query['absolute'] == 'true'){
                    $this->db->where($intersect);
                }
            }else{
                $this->db->like($intersect, 'before');
            }
        }
    }

    public function type_check(){
        if($this->type == 'student'){
            $this->db->where('id', $this->id);
        }elseif($this->type == 'faculty'){
            $this->db->where('id', $this->id);
        }

    }
    
    public function limit(){
        if(array_key_exists($this->reserved[2], $this->query)){
            $this->db->limit($this->query['limit']);
        }
    }

    public function sort(){
        if(array_key_exists($this->reserved[0], $this->query)){
            $sort = explode(',', $this->query['sort']);

            foreach($sort as $s){
                $order = substr($s , -5, 5);
                $c = str_replace($order, '', $s);
                
                if(in_array($c, $this->column)){
                    if($order == '[ASC]'){
                        $this->db->order_by($c, 'ASC');
                    }elseif($order =='[DSC]'){ 
                        $this->db->order_by($c, 'DESC');
                    }
                }
            }
        }
    }
}