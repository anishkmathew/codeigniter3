<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
                         ''~``
                        ( o o ) 
+------------------.oooO--(_)--Oooo.------------------+
|                                                     |
|  Adersh.P.V.       .oooO                            |
|                    (   )   Oooo.                    |
+---------------------\ (----(   )--------------------+
                       \_)    ) /
Main Controller File         (_/
* 
*/

class MY_Controller extends CI_Controller 
{

	function __construct()
	{
		parent::__construct();
		$this->get_common_data();
		//$this->get_permissions_view();
		header('Cache-Control: no cache'); //no cache
   		session_cache_limiter('must-revalidate');
	}
	
	function get_common_data()
	{
		$user_data = $this->session->userdata('login');
						
		$data['user_data'] = $user_data;
		
		$data['base_url'] = base_url();
		$data['admin_url'] = base_url().'admin/';
	
		$segment1['url'] = $this->uri->segment(1);
		$segment2['url'] = $this->uri->segment(2);
		$segment3['url'] = $this->uri->segment(3);
		
		$segment1['title'] = ucwords(str_replace('_', ' ', $segment1['url']));
		$segment2['title'] = ucwords(str_replace('_', ' ', $segment2['url']));
		$segment3['title'] = ucwords(str_replace('_', ' ', $segment3['url']));
		
		$data['controller_url'] = $this->router->fetch_class();
		$data['method_url'] = $this->router->fetch_method();
		
		if($this->session->userdata('page_session'))
		{
			$pages_session = $this->session->userdata('page_session');
			if($pages_session['controller'] != $data['controller_url'])
			{
				$this->session->unset_userdata('page_session');
			}
			else
			{
				$data['page_session'] = $pages_session;
			}
		}
				
		$data['controller'] = ucwords(str_replace('_', ' ', $this->router->fetch_class()));
		$data['method'] = ucwords(str_replace('_', ' ', $this->router->fetch_method()));
		
		$data['segment1'] = $segment1;
		$data['segment2'] = $segment2;
		$data['segment3'] = $segment3;
	
		$data['success_msg'] = $this->session->flashdata('success_msg');
		$data['error_msg'] = $this->session->flashdata('error_msg');
		
		$this->data = $data;
		
		
	}
	
	function is_logged_in()
	{		
		if(!$this->session->userdata('login'))
		{
			return FALSE;
		}
		return true;

	}
	function is_basic()
	{		
		if(!$this->session->userdata('basic'))
		{
			return FALSE;
		}
		else return TRUE;
	}
	function is_mob()
	{		
		if(!$this->session->userdata('mob'))
		{
			return FALSE;
		}
		else return TRUE;
	}
	function is_frontend_logged_in()
	{		
		if(!$this->session->userdata('frontend_login'))
		{
			return FALSE;
		}
		else return TRUE;
	}
	function logout()
	{
		$this->session->unset_userdata('login');
		redirect('home');
		return TRUE;
	}
	
	function user_logout()
	{
		
		$this->session->unset_userdata('frontend_login');
		$this->session->unset_userdata('image');
		//$this->session->unset_userdata('profile_complete');
		$this->session->unset_userdata('skip');
		$this->session->unset_userdata('searchterm');
		$this->session->unset_userdata('user_benefits');
		$this->session->unset_userdata('basic');
		$this->session->unset_userdata('mob');
		//$this->session->sess_destroy();
		
		return TRUE;
	}
	
	function get_permissions($module)
	{
		$permissions = $this->user_model->get_user_permission($module);	
		return $permissions;
	}
	
	function has_permission($method = FALSE)
	{
		$controller = $this->router->fetch_class();
		$permissions = $this->get_permissions($controller);
		if(!$method)
		{
			$method = $this->router->fetch_method();
		}
		if($permissions[$method]) return TRUE;
		else return FALSE;
	}
	
	function get_pagination($total, $url_suffix = FALSE, $limit = FALSE)
	{		
		$params = $this->get_pagination_params($url_suffix, $limit);
		
		$config = array();
        $config["base_url"] = $params['url'];
        $config["total_rows"] = $total;
        $config["per_page"] = $params['limit'];
        $config["uri_segment"] = $params['segment'];
		$config['full_tag_open'] = "<ul class='pagination'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='javascript:void(0)'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";
		$config['use_page_numbers'] = TRUE;
		
		if (count($_GET) > 0) 
		{
			$config['suffix'] = '?' . http_build_query($_GET, '', "&");
			$config['first_url'] = $config['base_url'].$config['suffix'];
			//$config['reuse_query_string'] = TRUE;
		}
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	function get_frontend_pagination($total, $url_suffix = FALSE, $limit = FALSE)
	{		
		$params = $this->get_pagination_params($url_suffix, $limit);
		
		$config = array();
        $config["base_url"] = $params['url'];
        $config["total_rows"] = $total;
        $config["per_page"] = $params['limit'];
        $config["uri_segment"] = $params['segment'];
		$config['use_page_numbers'] = TRUE;
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}
	
	function get_pagination_params($url_suffix = FALSE, $limit = FALSE)
	{
		if ($this->uri->segment(1) == 'admin')
		{
			$segment = 4;
			$url = base_url().'admin/'.$this->router->fetch_class().'/'.$this->router->fetch_method().'/';
		}
		else
		{
			$segment = 3;
			$url = base_url().$this->router->fetch_class().'/'.$this->router->fetch_method().'/';
		}

		if ($url_suffix) 
		{
			$segment += count($url_suffix);
			$url_suffix =  implode('/', $url_suffix);
			$url .= $url_suffix;
		}
		$limit = ($limit) ? $limit : ($this->session->userdata('page_limit') ? $this->session->userdata('page_limit') : 5);
		$page = ($this->uri->segment($segment)) ? $this->uri->segment($segment) : 1;
		$limit_start = ($limit*$page)-$limit;
		
		$params = array(
			'limit'		=> $limit,
			'start'		=> $limit_start, 
			'segment' 	=> $segment, 
			'url'		=> $url
		);
		return $params;
	}
	
	function send_email($to = FALSE, $message = FALSE, $subject = '', $from = '', $cc = '', $bcc = '', $attach = '')
	{
		
		
		$message = htmlspecialchars_decode( htmlspecialchars( $message));
		if(!$to or !$message) return FALSE;

		$this->load->library('email');		
       // $from='noreply@jeevanmate.com';
	   
		 $from = ($from == '') ? 'jeevanmatemails@gmail.com' : $from;
		 $email  = $this->email;
		 $from = ($from == '') ? 'jeevanmatemails@gmail.com' : $from;
		 $email->set_newline("\r\n");
		 //$email->from('','JeevanMate'); // change it to yours
		 $email->from('jeevanmatemails@gmail.com','JeevanMate');
		 $email->to($to);// change it to yours
		/* if($cc != '')
		 {
			$this->email->cc($cc);
		 }
		 if($bcc != '')
		 {
			$this->email->bcc($bcc);
		 }
		 $email->priority(3);*/
		 $subject = ($subject == '') ? 'JeevanMate' : $subject;
		  
		  $email->subject($subject);
		 // $email->attach('ss/email-2.1.0.zip');
		  $email->message($message);
		  if($attach != '' && file_exists($attach))
			{
				 $email->attach($attach);
			}
			
		 // $email->attach('email-2.1.0.zip');
		  if( $email->send())
				return TRUE;
		  else
				echo $this->email->print_debugger();
		  exit;
		   
		   
	   
	   
	   
	   
	   
	   
	   
	   
	   
	   
		$from = ($from == '') ? 'jeevanmatemails@gmail.com' : $from;
		$subject = ($subject == '') ? 'JeevanMate' : $subject;
		//-------------------
       //  $this->email->set_header('header1', 'value1');
        // $this->email->reply_to('noreply@jeevanmate.com', 'fdfd');
        // $this->email->priority(1);
         //--------------------------
		$this->email->from($from, 'JeevanMate');
		$this->email->to($to);
		if($cc != '')
		{
			$this->email->cc($cc);
		}
		if($bcc != '')
		{
			$this->email->bcc($bcc);
		}
		
		$this->email->subject($subject);
		$this->email->message($message);
		if($attach != '' && file_exists($attach))
		{
			$this->email->attach($attach);
		}
		
		if($this->email->send())
			return TRUE;
		else
			echo $this->email->print_debugger();
		exit;
	}
	
	function services()
	{
		$this->load->model('cms_model');
		$type='services';
		$userdata['services']=$this->cms_model->get_cms_items('','',$type);
		return $userdata;
	}
	
	function get_meta_data()
	{
		$this->load->model('Page_settings_model');
		$type='services';
		$userdata['services']=$this->cms_model->get_cms_items('','',$type);
		return $userdata;
	}
	
	function get_permissions_view()
	{
		$data = $this->data;
		$this->load->model('permission_model');
		if($this->session->userdata('login'))
		{
		$data['user_data']	=	$this->session->userdata('login');
		$user_data = $data['user_data'];
		$data['permissions_view']	=	$this->permission_model->get_permissions($user_data['role_id']);
		}
		$this->data = $data;
		
	}
	
		
	function is_deactivated()
	{		
		$user_data = $this->session->userdata('frontend_login');
		if($user_data['is_active']=='deactivated')
		  return true;
		else
		   return false;
	}
	
}