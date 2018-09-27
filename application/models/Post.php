<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Model
{
    function category_lists($limit, $start)
    {
        return $this->db->get('categories', $limit, $start)->result();
    }

    function all_category_lists()
    {
        return $this->db->get('categories')->result();
    }

    function insert_category($data)
    {
        return $this->db->insert('categories', $data);
    }

    function update_category($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('categories', $data);
    }

    function unique_category($data)
    {
        $check = $this->db->get_where('categories', array('name'=>$data['name'], 'id !='=>$data['id']))->num_rows();
        if ($check == 0) {
            return true;
        } else {
            return false;
        }
    }

    function delete_category($id)
    {
        return $this->db->delete('categories', array('id' => $id));
    }

    function get_category($id)
    {
        return $this->db->get_where('categories', array('id'=>$id))->row();
    }

    function post_lists($limit, $start) 
    {
        $user = auth_user();
        if ($user->group_id > 1)
            $this->db->where('author_id', $user->id);
        $this->db->order_by("id", "desc");
        return $this->db->get('posts', $limit, $start)->result();
    }

    function insert_post($data)
    {
        $this->db->insert('posts', $data);
        return $this->db->insert_id();
    }

    function insert_tags($id, $tag)
    {
        $this->db->insert('tags', array('post_id'=>$id, 'tag'=>$tag));
    }

    function delete_post($id)
    {
        return $this->db->delete('posts', array('id' => $id));
    }
}