<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		if( !$this->is_logged_in() ) redirect('login');
	}
	
	public function index()
	{
		$data = $this->data;
		$data['page_title'] = 'Dashboard';
		//Breadcrumb, its already loaded in autoload library
		$this->mybreadcrumb->add('Home', base_url());
		$data['breadcrumbs'] = $this->mybreadcrumb->render();
		
		$user_list = $this->user_model->get_users();
		$data['user_list'] = $user_list;
		$this->load->view('home', $data);
	}
	
}
