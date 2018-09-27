<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('user');
        if (is_login()) {
            redirect("admin");
        }
	}

	public function index()
	{
        //set form validation
    	$this->form_validation->set_rules('username', 'Username', 'required');
    	$this->form_validation->set_rules('password', 'Password', 'required');
        //set message form validation
    	$this->form_validation->set_message('required', '<label class="error col-red">{field} is required!</label>');
        //cek validasi
    	if ($this->form_validation->run()) {
        	//get data dari FORM
        	$where = array(
        		'name' => $this->input->post("username"),
        		'password' => MD5($this->input->post('password')),
        	);
        	//checking data via model
    		$checking = $this->user->check_login($where);
        	//jika ditemukan, maka create session
    		if ($checking != FALSE) {
				$session_data = array(
					'user_id' => $checking->id,
					'user_name' => $checking->name,
                    'user_password' => $checking->password,
                    'user_photo' => $checking->photo,
					'user_group' => $checking->group_id,
				);
            	//set session userdata
				$this->session->set_userdata($session_data);
				redirect('admin');
    		} else {
    			$data['error'] = '<label class="error col-red text-center">Your Login information does not match our credential!</label>';
    			$this->load->view('login', $data);
    		}
    	} else {
    		$this->load->view('login');
    	}
    }

    public function register()
    {
    	$this->form_validation->set_rules('name', 'Username', 'required|is_unique[users.name]');
    	$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        //set message form validation
    	$this->form_validation->set_message('is_unique', '<label class="error col-red">{field} is registered! please choose another name!</label>');
    	if ($this->form_validation->run()) {
	        $data = array(
	        	'name' => $this->input->post('name'),
	        	'fullname' => $this->input->post('fullname'),
	        	'email' => $this->input->post('email'),
	        	'gender' => $this->input->post('gender'),
	        	'group_id' => 2,
	        	'password' => md5($this->input->post('password'))
	        );
	    	if ($data['photo'] = $this->do_upload($data['name'])) {
		        if ($this->user->insert_user($data)) {
		            redirect("login");
		        } else {
                    $data['error'] = 'Error! Upload failed!';
                    $this->load->view('register', $data);
		        }
	    	}
    	} else {
    		$this->load->view('register');
    	}
    }

    public function do_upload($user)
    {
    	$config['upload_path'] = './assets/images/users';
		$config['allowed_types'] = 'gif|jpg|png|bmp';
		$config['max_size'] = 1024;
		$config['overwrite'] = TRUE;
		$config['file_ext_tolower'] = TRUE;

 		$file_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
 		$new_name = $user.'.'.$file_ext;
		
		$config['file_name'] = $new_name;
 
		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('photo')){
			$data['error'] = $this->upload->display_errors();
			$this->load->view('register', $data);
			return false;
		} else{
			return $this->upload->data('file_name');
		}
    }
}