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

    protected function pagination_config()
    {
        $config['page_query_string'] = true;
        $config['query_string_segment'] = 'page';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['full_tag_open'] = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close'] = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close'] = '</span>Next</li>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close'] = '</span></li>';
        return $config;
    }

    public function users()
    {   
        $config['base_url'] = site_url('admin/users');
        $config['total_rows'] = $this->db->count_all('users');
        $config['per_page'] = 5;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $pconfig = $this->pagination_config();
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

        if ($this->form_validation->run()) {
            $data['name'] = $this->input->post('name');
            if ($this->post->insert_category($data)) {
                redirect("admin/categories");
            } else {
                echo 'Error, Add Category failed!';
            }
        } else {
            if (count($this->input->post()) > 0) {
                $footer['js'] = '<script type="text/javascript">
                                    $(function() {
                                        $("#create_category").modal("show");
                                    })
                                </script>';
            } else {
                $footer['js'] = '';
            }

            $config['base_url'] = site_url('admin/categories');
            $config['total_rows'] = $this->db->count_all('categories');
            $config['per_page'] = 5;
            $config["num_links"] = 2;
            $pconfig = $this->pagination_config();
            $config = array_merge($config, $pconfig);

            $this->pagination->initialize($config);
            $data['page'] = $this->input->get('page');

            $data['categories'] = $this->post->category_lists($config["per_page"], $data['page']);           

            $data['pagination'] = $this->pagination->create_links();
            $header['title'] = 'CATEGORY MANAGEMENT';
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
                $footer['js'] = '<script type="text/javascript">
                                    $(function() {
                                        $("#create_post").modal("show");
                                    })
                                </script>';
            } else {
                $footer['js'] = '';
            }

            $header['css'] = '<link href="'.base_url().'assets/template/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />'.
                '<link href="'.base_url().'assets/template/adminbsb/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">';
            $footer['js'] .= '<script src="'.base_url().'assets/template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>'.
                '<script src="'.base_url().'assets/template/adminbsb/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>'.
                '<script src="'.base_url().'assets/template/adminbsb/plugins/tinymce/tinymce.js"></script>'.
                '<script type="text/javascript">
                    $(function() {
                        tinymce.init({
                            selector: "textarea#tinymce",
                            theme: "modern",
                            height: 300,
                            plugins: [
                                \'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
                                \'searchreplace wordcount visualblocks visualchars code fullscreen\',
                                \'insertdatetime media nonbreaking save table contextmenu directionality\',
                                \'emoticons template paste textcolor colorpicker textpattern imagetools\'
                            ],
                            toolbar1: \'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image\',
                            toolbar2: \'print preview media | forecolor backcolor emoticons\',
                            image_advtab: true
                        });
                        tinymce.suffix = ".min";
                        tinyMCE.baseURL = \''.base_url().'assets/template/adminbsb/plugins/tinymce\';
                    })
                </script>';

            $config['base_url'] = site_url('admin/posts'); //site url
            $config['total_rows'] = $this->db->count_all('posts'); //total row
            $config['per_page'] = 5;  //show record per halaman
            $config["uri_segment"] = 3;  // uri parameter
            $choice = $config["total_rows"] / $config["per_page"];
            $config["num_links"] = floor($choice);
            $pconfig = $this->pagination_config();
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
            $footer['js'] = '<script type="text/javascript">
                                $(function() {
                                    $("#create_post").modal("show");
                                })
                            </script>';

            $header['css'] = '<link href="'.base_url().'assets/template/adminbsb/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />'.
                '<link href="'.base_url().'assets/template/adminbsb/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet">';
            $footer['js'] .= '<script src="'.base_url().'assets/template/adminbsb/plugins/bootstrap-select/js/bootstrap-select.js"></script>'.
                '<script src="'.base_url().'assets/template/adminbsb/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>'.
                '<script src="'.base_url().'assets/template/adminbsb/plugins/tinymce/tinymce.js"></script>'.
                '<script type="text/javascript">
                    $(function() {
                        tinymce.init({
                            selector: "textarea#tinymce",
                            theme: "modern",
                            height: 300,
                            plugins: [
                                \'advlist autolink lists link image charmap print preview hr anchor pagebreak\',
                                \'searchreplace wordcount visualblocks visualchars code fullscreen\',
                                \'insertdatetime media nonbreaking save table contextmenu directionality\',
                                \'emoticons template paste textcolor colorpicker textpattern imagetools\'
                            ],
                            toolbar1: \'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image\',
                            toolbar2: \'print preview media | forecolor backcolor emoticons\',
                            image_advtab: true
                        });
                        tinymce.suffix = ".min";
                        tinyMCE.baseURL = \''.base_url().'assets/template/adminbsb/plugins/tinymce\';
                    })
                </script>';
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
}