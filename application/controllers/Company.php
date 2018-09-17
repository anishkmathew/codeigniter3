<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/company
	 *	- or -
	 * 		http://example.com/index.php/company/index
	 *	- or -
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/company/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('company_model');
		if( !$this->is_logged_in() ) redirect('login');
	}
	
	public function index()
	{
		$data = $this->data;
		$data['page_title'] = 'Company';
		//Breadcrumb, its already loaded in autoload library
		$this->mybreadcrumb->add('Company', base_url('company'));
		$this->mybreadcrumb->add('Listing', base_url('company/listing'));
		$data['breadcrumbs'] = $this->mybreadcrumb->render();
		
		$data['content'] = 'company/listing.php';
		//$companies = $this->company_model->get_companies();
		//$data['companies'] = $companies;
		$this->load->view('view',$data);
		//$this->load->view('company/listing', $data);
	}
	public function add()
	{
		$data = $this->data;
		$data['page_title'] = 'Company Add';
		//Breadcrumb, its already loaded in autoload library
		$this->mybreadcrumb->add('Company', base_url('company'));
		$this->mybreadcrumb->add('Add', base_url('company/add'));
		$data['breadcrumbs'] = $this->mybreadcrumb->render();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$data['page_title'] = 'Add Company';
			
		$config['upload_path'] = './uploads/company/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1280';
		$config['max_height']  = '1024';
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		$this->load->library('image_lib');
		
		$this->form_validation->set_rules('company_name', 'Company Name', 'required');
		$this->form_validation->set_rules('stock_value', 'Stock Value', 'required|decimal');
		
		if ($this->form_validation->run() === FALSE)
		{
			$data['validation_errors'] = validation_errors();
			$data['form_data'] =  array();
			$data['form_data'] = $this->input->post();
			// $form_data = $this->session->flashdata('form_data');
			// if($form_data)
			// {
				// $data['form_data'] = $form_data;
			// }
			// else if($data['validation_errors'])
			// {
				// $data['form_data'] = $this->input->post();
			// }
			// $data['roles'] = $this->user_model->get_roles();	
			$data['content'] = 'company/add.php';
			$this->load->view('view', $data);
		}
		else
		{
			if(!empty($_FILES))
			{
				$filename=$_FILES['image']['name'];
				$filesize=$_FILES['image']['size'];
				$filetype=$_FILES['image']['type'];
				$tmpfile=$_FILES['image']['tmp_name'];
				 
				if($filename !='')
				{
					$temp = explode(".", $filename);
					$extension = end($temp);
					$imagename= $this->getUniqueName(10);
				
					if ((($filetype == "image/gif")
					|| ($filetype == "image/jpeg")
					|| ($filetype == "image/png")
					|| ($filetype == "image/bmp")))
					{
						move_uploaded_file($tmpfile,"./uploads/company/".$imagename.".".$extension);
						$this->load->library("simpleimage");
						
						$image = $this->simpleimage;
						$image->load("./uploads/company/".$imagename.".".$extension); 
						$image->resizeToPerfectSize(30,30); 
						$image->save('./uploads/user/thumb30x30_'.$imagename.".".$extension); 
					}
					$image = $imagename.".".$extension;
				}
			}
			
			if ($this->company_model->set_company($image) === FALSE)
			{
				$form_data = $this->input->post();
				$this->session->set_flashdata('form_data', $form_data);
				redirect('company/add', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('success_msg', 'User added successfully!');
				redirect('company', 'refresh');
			}			
		}
	}
	public function getUniqueName($length)
	{
		$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'));	
		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}	
		return $key;
	}
}
