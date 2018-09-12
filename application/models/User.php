<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
    //check username password
    function check_login($where)
    {
        $query = $this->db->get_where('users', $where, 1);
        if ($query->num_rows() == 0) {
            return FALSE;
        } else {
            return $query->result();
        }
    }

    function insert_user($data) 
    {
        return $this->db->insert('users', $data);
    }

    function user_lists($limit, $start) 
    {
        return $this->db->get_where('users', array('group_id >' => 1), $limit, $start)->result();
    }
}