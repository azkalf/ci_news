<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!is_login()) {
            redirect("login");
        }
        $this->load->model('post');
        $this->load->model('user');
        $menu = menu_url_user();
        $url = uri_string();
        if (!in_array($url, $menu)) {
            show_404();
        }
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function index()
    {
        $header['title'] = 'DASHBOARD';
        $this->load->view("layouts/admin_header", $header);
        $this->load->view("dashboard");
        $this->load->view("layouts/admin_footer");
    }

    public function users()
    {   
        $config['base_url'] = site_url('admin/users');
        $config['total_rows'] = $this->db->count_all('users');
        $config['per_page'] = 5;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $pconfig = pagination_config();
        $config = array_merge($config, $pconfig);

        $this->pagination->initialize($config);
        $data['page'] = $this->input->get('page');

        $data['users'] = $this->user->user_lists($config["per_page"], $data['page']);
        $header['title'] = 'USER MANAGEMENT';
        $this->load->view("layouts/admin_header", $header);
        $this->load->view("users", $data);
        $this->load->view("layouts/admin_footer");
    }

    public function categories()
    {   
        $this->form_validation->set_rules('name', 'Name', 'required|is_unique[categories.name]');

        $this->form_validation->set_message('is_unique', '<label class="error col-red">{field} already exist! please choose another name!</label>');

        if ($this->form_validation->run() == TRUE) {
            $data['name'] = $this->input->post('name');
            if ($this->post->insert_category($data)) {
                redirect("admin/categories");
            } else {
                echo 'Error, Add Category failed!';
            }
        } else {
            if (count($this->input->post()) > 0) {
                $footer['posting'] = true;
            } else {
                $footer['posting'] = false;
            }
            $footer['js'] = 'category_js';

            $config['base_url'] = site_url('admin/categories');
            $config['total_rows'] = $this->db->count_all('categories');
            $config['per_page'] = 3;
            $config["num_links"] = 2;
            $pconfig = pagination_config();
            $config = array_merge($config, $pconfig);

            $this->pagination->initialize($config);
            $data['page'] = $this->input->get('page');

            $data['categories'] = $this->post->category_lists($config["per_page"], $data['page']);           

            $data['pagination'] = $this->pagination->create_links();
            $header['title'] = 'CATEGORY MANAGEMENT';
            $header['css'] = 'category_css';
            $this->load->view("layouts/admin_header", $header);
            $this->load->view("categories", $data);
            $this->load->view("layouts/admin_footer", $footer);
        }
    }

    public function delete_category()
    {
        $id = $this->input->get('id');
        if ($this->post->delete_category($id)) {
            redirect("admin/categories");
        }
    }

    public function get_category()
    {
        $id = $this->input->post('id');
        $category = $this->post->get_category($id);
        echo json_encode($category);
    }

    public function update_category()
    {
        $data['id'] = $this->input->post('id');
        $data['name'] = $this->input->post('name');
        if ($this->post->unique_category($data)) {
            if ($this->post->update_category($data)) {
                $data['status'] = 'success';
            } else {
                $data['status'] = 'failed';
                $data['message'] = 'failed to update data!';
            }
        } else {
            $data['status'] = 'failed';
            $data['message'] = 'category name already exist! choose another name!';
        }
        echo json_encode($data);
    }

    public function posts()
    {   
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('tags', 'Tags', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        if (empty($_FILES['image']['name']))
            $this->form_validation->set_rules('image', 'Image', 'required');

        $this->form_validation->set_message('required', '<label class="error col-red">{field} is required!</label>');

        if ($this->form_validation->run()) {
            $data = array(
                'title' => $this->input->post('title'),
                'category_id' => $this->input->post('category_id'),
                'author_id' => auth_user()->id,
                'description' => $this->input->post('description'),
                'date_created' => date('Y-m-d H:i:s')
            );
            if ($data['image'] = $this->do_upload()) {
                if ($id = $this->post->insert_post($data)) {
                    $tags = $this->input->post('tags');
                    $tags = explode(',', $tags);
                    $tags = array_unique($tags);
                    foreach ($tags as $tag) {
                        $this->post->insert_tags($id, $tag);
                    }
                    redirect("admin/posts");
                } else {
                    $data['error'] = 'Error! Upload failed!';
                    $this->load->view('posts', $data);
                }
            }
        } else {
            if (count($this->input->post()) > 0) {
                $footer['posting'] = true;
            } else {
                $footer['posting'] = false;
            }

            $header['css'] = 'post_css';
            $footer['js'] = 'post_js';

            $config['base_url'] = site_url('admin/posts'); //site url
            $config['total_rows'] = $this->db->count_all('posts'); //total row
            $config['per_page'] = 5;  //show record per halaman
            $config["uri_segment"] = 3;  // uri parameter
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = floor($choice);
            $pconfig = pagination_config();
            $config = array_merge($config, $pconfig);

            $this->pagination->initialize($config);
            $data['page'] = $this->input->get('page');

            $data['posts'] = $this->post->post_lists($config["per_page"], $data['page']); 

            $data['pagination'] = $this->pagination->create_links();

            $data['categories'] = $this->post->all_category_lists();
            $header['title'] = 'POST MANAGEMENT';
            $this->load->view("layouts/admin_header", $header);
            $this->load->view("posts", $data);
            $this->load->view("layouts/admin_footer", $footer);
        }
    }

    public function do_upload()
    {
        $config['upload_path'] = './assets/images/posts';
        $config['allowed_types'] = 'gif|jpg|png|bmp';
        $config['max_size'] = 1024;
        $config['overwrite'] = TRUE;
        $config['file_ext_tolower'] = TRUE;
 
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')){
            $footer['posting'] = true;

            $header['css'] = 'post_css';
            $footer['js'] = 'post_js';

            $data['error'] = $this->upload->display_errors();
            $data['posts'] = $this->post->post_lists();
            $data['categories'] = $this->post->all_category_lists();
            $header['title'] = 'POST MANAGEMENT';
            $this->load->view("layouts/admin_header", $header);
            $this->load->view("posts", $data);
            $this->load->view("layouts/admin_footer", $footer);
            return false;
        } else{
            return $this->upload->data('file_name');
        }
    }

    public function delete_post()
    {
        $id = $this->input->get('id');
        if ($this->post->delete_post($id)) {
            redirect("admin/posts");
        }
    }
}