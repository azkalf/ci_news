<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function auth_user()
{
	$CI =& get_instance();
	$id = $CI->session->userdata('user_id');
	if ($id) {
    	$query = $CI->db->get_where('users', array('id'=>$id));
    	return $query->row();
	}
    return false;
}

function is_login()
{
	$CI =& get_instance();
	if ($CI->session->userdata('user_id'))
		return true;
	return false;
}

function menu_user()
{
	$user = auth_user();
	if ($user->group_id == 1) {
		return array(
			['title'=>'Home', 'link'=>'admin', 'icon'=>'home'],
			['title'=>'User Lists', 'link'=>'admin/users', 'icon'=>'person'],
			['title'=>'Category Lists', 'link'=>'admin/categories', 'icon'=>'list'],
			['title'=>'Post List', 'link'=>'admin/posts', 'icon'=>'library_books'],
		);
	} else {
		return array(
			['title'=>'Home', 'link'=>'admin', 'icon'=>'home'],
			['title'=>'Post List', 'link'=>'admin/posts', 'icon'=>'library_books'],
		);
	}
}

function menu_url_user()
{
	$menus = menu_user();
	$urls = [];
	foreach ($menus as $menu) {
		$urls[] = $menu['link'];
	}
	$default_url = array('admin/logout');
	$user = auth_user();
	if ($user->group_id == 1) {
		$additional_urls = array(
			'admin/delete_category',
		);
	} else {
		$additional_urls = array(
			'admin/delete_post',
		);
	}
	$urls = array_merge($urls, $default_url, $additional_urls);
	return $urls;
}

function groups($id = null)
{
	$groups = array('1'=>'Admin', '2'=>'User');
	if ($id)
		return $groups[$id];
	return $groups;
}

function genders($id = null)
{
	$genders = array('m'=>'Male', 'f'=>'Female');
	if ($id)
		return $genders[$id];
	return $genders;
}

function author($id)
{
	$CI =& get_instance();
	$user = $CI->db->get_where('users', array('id'=>$id))->row();
	return $user->name;
}

function category($id)
{
	$CI =& get_instance();
	$category = $CI->db->get_where('categories', array('id'=>$id))->row();
	return $category->name;
}

function tags($post_id)
{
	$CI =& get_instance();
	$tags = $CI->db->get_where('tags', array('post_id'=>$post_id))->result();
	$tag_labels = '';
	foreach ($tags as $tag) {
		$tag_labels .= '<span class="label label-info">'.$tag->tag.'</span>&nbsp;';
	}
	return $tag_labels;
}