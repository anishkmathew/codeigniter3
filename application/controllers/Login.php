<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login controller
 */

class Login extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		if( $this->is_logged_in() ) redirect('home');
	}
	
	function index()
	{
		$data = $this->data;
		$this->load->helper('cookie');
		$username = $this->input->cookie('admin_username', true);
		$password = $this->input->cookie('admin_password', true);
		$this->load->library('form_validation');// Load the validation library
		//$this->load->helper('form');
		
		$this->form_validation->set_rules('email', 'Email', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');
		//set the rules after field validation a callback function will check the login credential against database
		if($this->form_validation->run() == FALSE)
		{
			$data['validation_errors'] = validation_errors();
			//Field validation failed.  User redirected to login page
			$data['page_title'] = 'login';
			if ($username == ''){
				$remember_me = $this->input->post('remember_me');
				$username = $this->input->post('email');
				$password = $this->input->post('password');
			}
			$remember = array(
				'remember_me'=>$remember_me,
				'admin_username' => $username,
				'admin_password' => $password
			);
			
			$data['remember'] = $remember;
			$data['page_title'] = 'login';
			$this->load->view('login/login', $data);
		}
		else
		{
			//Go to private area			
			redirect('home');
		}
	}
		
	function check_database($str)
	{
		//Field validation succeeded.  NOw Validate against database
		$username = $this->input->post('email');
		$password = $str;//Form field data
		//query the database
		$result = $this->user_model->login($username, $password);
		if($result)
		{
			$sess_array = array(
				'id' 		=> $result->id,
				'username' 		=> $result->username,	
				'email' 		=> $result->email					
			);
			$this->session->set_userdata('login', $sess_array);
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return FALSE;
		}
	}
	
	function forgot_password($token = FALSE)
	{
		$data = $this->data;

		$this->load->library('form_validation');
		$this->load->helper('form');
		
		if(!$token)
		{
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_set_token');
			
			if($this->form_validation->run() == FALSE)
			{
				$data['validation_errors'] = validation_errors();
				$data['page_title'] = 'Forgot Password';
				$data['main_content'] = 'login/forgot_password.php';
				$this->load->view('admin/login', $data);
			}
			else
			{
				admin_redirect('login');
			}
		}
		else
		{
			if($this->user_model->is_valid_token($token) === FALSE)
			{
				$this->session->set_flashdata('error_msg', 'Token not found or expired!');
				admin_redirect('login/forgot_password', 'refresh');
			}
			else
			{
				admin_redirect('login/reset_password', 'refresh');
			}
		}
	}	
	
	function reset_password()
	{
		$data = $this->data;
		$data['token_data'] = $this->session->userdata('token_data');
		$this->load->library('form_validation');
		$this->load->helper('form');
		
		$this->form_validation->set_rules('password', 'Password', 'trim|required|matches[passconf]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		$this->form_validation->set_message('matches', 'The two passwords do not match!');

		if($this->form_validation->run() == FALSE)
		{
			$data['validation_errors'] = validation_errors();
			$data['page_title'] = 'Reset Password';
			$data['main_content'] = 'login/reset_password.php';
			$this->load->view('admin/login', $data);
		}
		else
		{
			if ($this->user_model->reset_password() === FALSE)
			{
				$this->session->set_flashdata('error_msg', 'Database error!');
				admin_redirect('login/reset_password', 'refresh');
			}
			else
			{
				$this->session->unset_userdata('token_data');
				$msg = 'Password succeessfully updated! Please login with the new password.';
				$this->session->set_flashdata('success_msg', $msg);
				admin_redirect('login');
			}
		}
	}
		
	function set_token($email)
	{
		if ($this->user_model->set_token($email) === FALSE)
		{
			$this->session->set_flashdata('error_msg', 'Email ID not found!');
			admin_redirect('login/forgot_password', 'refresh');
		}
		else
		{
			$msg = 'A link to reset your password has been sent to your email address.';
			$this->session->set_flashdata('success_msg', $msg);
			admin_redirect('login');
		}
	}
	
	/*public function captcha()
	{  
		$aFonts = array(APPPATH . 'libraries/font/captcha0.ttf', APPPATH . 'libraries/font/captcha1.ttf', APPPATH . 'libraries/font/captcha2.ttf', APPPATH . 'libraries/font/captcha3.ttf');
		$this->load->library('phpcaptcha');
		$this->phpcaptcha->Phpcaptcha1($aFonts, 200, 50);
		//$this->phpcaptcha->SetBackgroundImages(base_url().'assets/admin/img/captcha.jpg');
	  	$this->phpcaptcha->Create();
    }
  
	public function captcha_validate($current_captcha)
	{  
		if(md5($_SESSION['php_captcha']) == md5($current_captcha))
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
		exit;	
	}*/

	public function captcha()
	{  
		$aFonts = array(APPPATH . 'libraries/font/captcha0.ttf', APPPATH . 'libraries/font/captcha1.ttf', APPPATH . 'libraries/font/captcha2.ttf', APPPATH . 'libraries/font/captcha3.ttf');
		$this->load->library('phpcaptcha');
		$this->phpcaptcha->Phpcaptcha1($aFonts, 200, 50);
		$this->phpcaptcha->SetBackgroundImages(base_url().'assets/admin/img/captcha.jpg');
	  	$this->phpcaptcha->Create();
    }
  
	public function captcha_validate($current_captcha)
	{  
		if(md5($_SESSION['php_captcha']) == md5($current_captcha))
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
		exit;	
	}

}