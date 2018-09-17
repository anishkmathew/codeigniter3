<?php
/**
 * Taurus Admin Panel
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter+Bootstrap+Smarty
 * @copyright	Copyright (c) 2014-2015, Taurus Web Solutions
 * @author		Adersh.P.V
 */

Class Company_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	
 
	public function get_countries()
	{
		$query = $this->db->get('countries');
		return $query->result_array();
	}
	
	public function get_states_by_code($country_code)
	{
		$query = $this->db->get_where('states', array('country_code' =>$country_code));
		return $query->result_array();
	}
 
	public function get_states()
	{
		$query = $this->db->get('states');		
		return $query->result_array();
	}
	function get_company_count()
	 {
	   //check for any filters
	   $qsearch = $this->input->get('qsearch');
		if($qsearch)
		{
			$this->db->like('company_name', $qsearch); 
			$this->db->or_like('company_address', $qsearch); 
		}
		
	  $query = $this->db->get("companies");
	  return $query->num_rows();
	 }
	 function count_all()
	 {
		return  $this->get_company_count();
	 }
	public function get_company($order_by = 'id', $order = 'asc', $limit = FALSE, $start = 0)
	{
		$this->db->select('*');
		$this->db->from('companies');
		$qsearch = $this->input->get('qsearch');
		if($qsearch)
		{
			$this->db->like('company_name', $qsearch); 
			$this->db->or_like('company_address', $qsearch); 
		}
		$this->db->order_by($order_by,$order);
		if($limit) $this->db->limit($limit, $start);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result_array();
	}
	/**
	This is the view for loading the content for ajax pagination
	*/
	public function get_company_pagination_view($order_by = 'id', $order = 'asc', $limit = 0, $start = 0){
		$output	=	'';
		$user_data = $this->get_company('id', 'asc', $limit, $start);
		
		$output .= '
		  <table class="table table-hover">
                <tbody><tr>
                  <th>#</th>
                  <th>Company</th>
                  <th>Address</th>
                  <th>Stock Value</th>
                  <th>Status</th>
				  <th>Actions</th>
                </tr>
		  ';
		  
		$num	= $start;
		 foreach($user_data as $row)
		  {
		   $output .= '
		   <tr>
			<td>'.++$num.'</td>
			<td>'.$row['company_name'].'</td>
			<td>'.$row['company_address'].'</td>
			<td><span class="badge bg-red">'.$row['stock_value'].'</span></td>
			<td><span class="label label-success">'.$row['is_active'].'</span></td>
			<td><a href="#"><span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;<a href="#"><span class="text-red glyphicon glyphicon-remove-circle"></span></a><td>
		   </tr>
		   ';
		  }
		  $output .= '</table>';
		  return $output;
	}
 
	public function get_roles()
	{
		$query = $this->db->get('role');
		return $query->result_array();
	}
 
	public function get_admin_users($order_by = 'user_id', $order = 'desc', $limit = FALSE, $start = 0)
	{
		$this->db->select('admin.*, role.title as role_title');
		$this->db->from('admin');
		$this->db->join('role', 'role.role_id = admin.fk_role_id');
		$qsearch = $this->input->post('qsearch');
		if($qsearch)
		{
			$this->db->like('admin.first_name', $qsearch); 
			$this->db->or_like('admin.last_name', $qsearch); 
			$this->db->or_like('admin.username', $qsearch); 
		}
		$this->db->order_by($order_by,$order);
		if($limit) $this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result_array();
	}
 
	public function get_admin_users_count()
	{
		$this->db->select('admin.*, role.title as role_title');
		$this->db->from('admin');
		$this->db->join('role', 'role.role_id = admin.fk_role_id');
		$qsearch = $this->input->post('qsearch');
		if($qsearch)
		{
			$this->db->like('admin.first_name', $qsearch); 
			$this->db->or_like('admin.last_name', $qsearch); 
			$this->db->or_like('admin.username', $qsearch); 
		}
		$query = $this->db->get();
		return $query->num_rows();
	}
	 
	public function set_company($image = FALSE)
	{
		$company_name = $this->input->post('company_name');
		$stock_value = $this->input->post('stock_value');
		
		// $fk_country_code = $this->input->post('fk_country_id');
		// $fk_state_id = $this->input->post('fk_state_id');
		// $state = $this->input->post('state');
		$address = $this->input->post('company_address');
		$profile_pic = $image;
		$date_added = date('Y-m-d');
		$is_active = $this->input->post('is_active');
	
		/*$this->db->select('user_id');
		$this->db->from('admin');
		$this->db->where('email', $email);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			$this->session->set_flashdata('error_msg', 'Email already exists!');
			return FALSE; exit;
		}
		
		$this->db->select('user_id');
		$this->db->from('admin');
		$this->db->where('username', $username);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			$this->session->set_flashdata('error_msg', 'Username already exists!');
			return FALSE; exit;
		}
		else
		{*/
			$data = array(
				'company_name' => $company_name,
				'address' => $address,
				'stock_value' => $stock_value,
				'is_active' => $is_active
			);
			if($image) $data['profile_pic'] = $image;
			
			return $this->db->insert('company', $data);
		//}
	}

	public function get_user_from_id($id = FALSE)
	{	
		$this->db->select('admin.*, role.title as role_title');
		$this->db->from('admin');
		$this->db->join('role', 'role.role_id = admin.fk_role_id');
		$qsearch = $this->input->post('qsearch');
		if($qsearch)
		{
			$this->db->like('admin.first_name', $qsearch); 
			$this->db->or_like('admin.last_name', $qsearch); 
			$this->db->or_like('admin.username', $qsearch); 
		}
		if($id) $this->db->where('admin.user_id', $id);
		$query = $this->db->get();
		if(!$id) return $query->result_array();
		return $query->row_array();
	}
	
	public function get_customer_from_id($id = FALSE)
	{		
		if ($id === FALSE)
		{
			$query = $this->db->get('user');
			return $query->result_array();
		}

		$this->db->select('u.*, c.name as country_name, s.name as state_name');
		$this->db->from('user as u');
		$this->db->join('countries as c', 'u.fk_country_code = c.iso_alpha3', 'left');
		$this->db->join('states as s', 'u.fk_state_id = s.id', 'left');
		$query = $this->db->get_where('user', array('u.user_id' => $id));
		return $query->row_array();
	}
	
	public function update_user($id, $image = FALSE)
	{	
		
		$password = $this->input->post('password');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$fk_role_id = $this->input->post('fk_role_id');
		$email = $this->input->post('email');
		$fk_country_code = $this->input->post('fk_country_id');
		$fk_state_id = $this->input->post('fk_state_id');		
		$phone = $this->input->post('mobile_number');
		$address = $this->input->post('address');		
		$notes = $this->input->post('notes');
		$is_active = $this->input->post('is_active');
		
		
		$this->db->from('admin');
		 $this->db->where('user_id', $id);
		 $query_n = $this->db->get();
		 $query_n = $query_n->row_array();
		 if($notes=='')
		 {
       $notes=$query_n['notes'];
		 }
		 if($address=='')
		 {
		$address=$query_n['address'];
		 }
		$user_data = $this->session->userdata('login');
		if($is_active=='')
		{
		$is_active = $user_data['is_active'];
		}
		if($fk_role_id=='')
		{
		$fk_role_id = $user_data['role_id'];
		}
		$this->db->select('user_id');
		$this->db->from('admin');
		$this->db->where('user_id !=', $id);
		$this->db->where('email', $email);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{			
			$this->session->set_flashdata('error_msg', 'Email already exists!');
			return FALSE; exit;
		}		
		else
		{			
			$data = array(				
				'first_name' => $first_name,
				'last_name' => $last_name,
				'fk_role_id' => $fk_role_id,
				'email' => $email,
				'fk_country_code' => $fk_country_code,
				'fk_state_id' => $fk_state_id,				
				'phone' => $phone,
				'address' => $address,
				'notes' => $notes,
				'is_active' => $is_active
			);			
			if($image)
			{
				$userdata = $this->get_user_from_id($id);
				if(file_exists('./uploads/user/'.$userdata['profile_pic']))
				{					
					unlink('./uploads/user/'.$userdata['profile_pic']);
				}
				if(file_exists('./uploads/user/thumb_'.$userdata['profile_pic']))
				{
					unlink('./uploads/user/thumb_'.$userdata['profile_pic']);
				}
				if(file_exists('./uploads/user/thumb30x30_'.$userdata['profile_pic']))
				{
					unlink('./uploads/user/thumb30x30_'.$userdata['profile_pic']);
				}
				if(file_exists('./uploads/user/thumb249x204_'.$userdata['profile_pic']))
				{
					unlink('./uploads/user/thumb249x204_'.$userdata['profile_pic']);
				}
				if(file_exists('./uploads/user/thumb300x225_'.$userdata['profile_pic']))
				{
					unlink('./uploads/user/thumb300x225_'.$userdata['profile_pic']);
				}
				$data['profile_pic'] = $image;
			}

			$this->db->where('user_id', $id);
			return $this->db->update('admin', $data);
		}
	}
	
	public function update_user_profile_pic($profile_pic,$id)
	{
		$data['profile_pic'] = $profile_pic;
		$this->db->where('user_id', $id);
		return $this->db->update('admin', $data);
	}
	
	public function delete_user($id = FALSE)
	{
		if ($id === FALSE)
		{
			return FALSE;
		}
		
		$data = $this->get_user_from_id($id);
		if(file_exists('./uploads/user/'.$data['profile_pic']))
		{
			unlink('./uploads/user/'.$data['profile_pic']);
		}
		if(file_exists('./uploads/user/thumb_'.$data['profile_pic']))
		{
			unlink('./uploads/user/thumb_'.$data['profile_pic']);
		}
		if(file_exists('./uploads/user/thumb30x30_'.$data['profile_pic']))
		{
			unlink('./uploads/user/thumb30x30_'.$data['profile_pic']);
		}
		if(file_exists('./uploads/user/thumb249x204_'.$data['profile_pic']))
		{
			unlink('./uploads/user/thumb249x204_'.$data['profile_pic']);
		}
		if(file_exists('./uploads/user/thumb300x225_'.$data['profile_pic']))
		{
			unlink('./uploads/user/thumb300x225_'.$data['profile_pic']);
		}

		$this->db->delete('admin', array('user_id' => $id)); 
		return $this->db->affected_rows();;
	}
	
	public function activate_user()
	{		
		$user_id = $this->input->post('user_id');
		$active = $this->input->post('active');

		$data = array('is_active' => $active);

		$this->db->where('user_id', $user_id);
		$this->db->update('admin', $data);
		return TRUE;
	}
	
	public function set_token($email)
	{	
		$this->db->select('user_id,first_name,last_name');
		$this->db->from('admin');
		$this->db->where('email', $email);
		$this->db->limit(1);
		
		$query = $this->db->get();
		$query = $query->row_array();
		$fname=$query['first_name'];
		$lname=$query['last_name'];
		$name=$fname." ".$lname;
		if($query['user_id'] != '')
		{
			$this->load->helper('string');
			$token = random_string('alnum', 32);
			$time = time();
			$data = array(
				'token' => $token,
				'token_time' => $time
			);			
			$this->db->where('email', $email);
			$this->db->update('admin', $data);
			$this->admin_reset_mail($email, $token,$name);
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function admin_reset_mail($email, $token,$name)
	{			
		$config['mailtype'] = 'html';
		$url = base_url().'admin/login/forgot_password/'.$token;

		$this->load->library('email');
		$this->email->initialize($config);
		$from = ($from == '') ? 'noreply@jeevanmate.com' : $from;
		$this->email->from($from, 'JeevanMate');
		$this->email->to($email); 
		$this->email->subject('Password Reset');
		$content = "<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300,300italic' rel='stylesheet' type='text/css'>
<div style='width: auto; margin: 0 auto;'>
							<div style='width: auto; margin: 10px;'>
								<div style='width: auto;  height: 72px; border-bottom:solid #e71515 2px;
                                background: -webkit-linear-gradient(#fff6ba #ffffff); /* For Safari 5.1 to 6.0 */
                                background: -o-linear-gradient(#fff6ba, #ffffff); /* For Opera 11.1 to 12.0 */
                                background: -moz-linear-gradient(#fff6ba, #ffffff); /* For Firefox 3.6 to 15 */
                                background: linear-gradient(#fff6ba, #ffffff); /* Standard syntax */'>
									<img src='".base_url()."assets/frontend/images/innner_logo.png' style='margin:10px 0 0 10px;'/></div>
									<div style='width: auto; background-color: #F5F5F5; padding: 10px 15px; border-bottom: solid #e4e4e4 2px;'>
										<p style='font-family: Roboto, sans-serif; font-size: 20px; color: #578f02; line-height: 32px; margin: 0; padding: 0;'>Hello ".$name.",</p>
										<p style='font-family: Roboto, sans-serif; font-size: 14px; color: #424242; line-height: 22px; margin: 0; padding: 0;'>Retrieving Password.</p>
										<div style='width: auto; background-color: #fff; margin: 15px 0 0; padding: 10px;'>
											<p style='font-family: Roboto, sans-serif; font-size: 13px; color: #424242; line-height: 22px; margin: 0; padding: 0;'>
												We know it's sometimes hard to remember all those online passwords. So let's reset that password. <br /><br /><a style='font-family: Roboto, sans-serif; font-size: 12px; color: #f6b007; text-decoration:underline;' target='_blank' href='".$url."'>Reset your password</a><br /><br /> <a style='font-family: Roboto, sans-serif; font-size: 12px; color: #0000CD; text-decoration:none;' target='_blank' href='".base_url()."'>JeevanMate.com</a>
											</p>
										</div>
									</div>
								</div>
							</div>";
		
		$this->email->message($content);	
		$this->email->send();
		
		//echo $this->email->print_debugger(); exit;
	}
	
	public function is_valid_token($token)
	{	
		$this->db->select('email, token_time');
		$this->db->from('admin');
		$this->db->where('token', $token);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			$result = $query->row_array();
			
			$now = time();
			
			if($now-$result['token_time'] > 172800) return false;
			else
			{
				$token_data = array(
					'email' => $result['email'],
					'token' => $token
				);
				$this->session->set_userdata(array(
					'token_data' => $token_data
				));
				return true;
			}
		}
		else
		{
			return false;
		}

	}

	public function reset_password()
	{
		$password = $this->input->post('password');
		$token_data = $this->session->userdata('token_data');
		$data = array(
			'password' => MD5($password),
			'token' => NULL,
			'token_time' => NULL
		);
		$this->db->where('email', $token_data['email']);
		$this->db->where('token', $token_data['token']);
		return $this->db->update('admin', $data);
	}
	
	/**************************************************************************************
		Auther	: Anjali Krishnan
		Date	: 30 June 2015
		Purpose	: To chnage password of admin user
	**************************************************************************************/
	public function reset_admin_password($n_pass, $id)
	{
		$password = $n_pass;		
		$data = array(
			'password' => MD5($password),			
		);
		$this->db->where('user_id', $id);		
		return $this->db->update('admin', $data);
	}


	public function validate_password($uname,$pass)
	{
		$this->db->where('username', $uname);
		$this->db->where('password', MD5($pass));
		$qry = $this->db->get('admin');
		return $qry->result_array();
		
	}
	
	public function validate_user_password($id,$pass)
	{
		$this->db->where('user_id', $id);
		$this->db->where('password', MD5($pass));
		$qry = $this->db->get('admin');
		return $qry->result_array();
		
	}
	
	//--------------------------------------------------------------------//
	public function login_front()
	{
		$remember = $this->input->post('remember_me');
		$username = $this->input->post('username_f');
		$password = $this->input->post('password_f');
		
		$tocken_id 	=	$this->uri->segment(3);
		//echo "WWWW".$tocken_id;exit;
		if($tocken_id != "")
		{
			$cond	=	array('token' => $tocken_id,
						'email' => $username,
						'password' => md5($password));
		}
		else 
		{
			$cond	=	array('is_active' => 'yes',
						'email' => $username,
						'password' => md5($password));
		}				
		$this->db->limit(1);
		//date_default_timezone_set('Asia/Kolkata');
	    $date = date('Y-m-d h:i:s');
	
		$query 		= 	$this->db->get_where('user',$cond);
		
		//echo $this->db->last_query();exit;
		//echo print_r($query->result_array());
		
		if($query->num_rows() == 1)
		{
			if($tocken_id != "")
			{
				$time 	= 	time();
				$data 	= 	array(
					'is_active' => 'yes',
					'token_time' => $time
					
				);
				$this->db->where('email', $username);
				$this->db->update('user', $data);
				
				$query 		= 	$this->db->get_where('user',$cond);
				
			}
			else
				{
					$data 	= 	array(
					'user_last_login'=>$date
					
				);
				$this->db->where('email', $username);
				$this->db->update('user', $data);
					
				}
			if($remember == 'on')
			{
				$this->load->helper('cookie');
				$username = array(
					'name' => 'username',
					'value' => $username,
					'expire' => '86500'
				);
				$password = array(
					'name' => 'password',
					'value' => $password,
					'expire' => '86500'
				);
				$this->input->set_cookie($username);
				$this->input->set_cookie($password);
			}
			
			return $query->result();
		}
		else
		{
			return false;
		}
	}
	public function set_token_front($email, $type='')
	{	
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('email', $email);
		//if($type = '2') $this->db->where('is_active', 'no');
		$this->db->limit(1);
		
		$query = $this->db->get();
		$result = $query->row_array();
		if($query->num_rows() == 1)
		{
			$this->load->helper('string');
			$token = random_string('alnum', 32);
			$time = time();
			$data = array(
				'token' => $token,
				'token_time' => $time
			);			
			$this->db->where('email', $email);
			$this->db->update('user', $data);
			$this->user_reset_mail($email, $token, $type);
			return $result['user_id'];
		}
		else
		{
			return FALSE;
		}

	}
	
	public function user_reset_mail($email, $token, $type='')
	{	
		$base_url = base_url();	

		if($type == 2)
		{
			$adminurl=base_url().'admin/login';
			$content="<b>New user Registered</b><br><br>Please activate user account after a valid verification.<br><br><a href='".$adminurl."'>Login as Admin</a><br><br>Thank you,<br><br><b><a style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color: #0000CD; text-decoration:none;' target='_blank' href='".base_url()."'>JeevanMate.com</a></b>";
			
			$url 	=	base_url().'login/index/'.$token;
			//$content = "Please follow the link below to activate your account.</br><a href='".$url."'>Click Here</a>";
			/*$main_content = "Welcome to the ezzfind family! You are now part of a big marketplace where people like you can sell their unused items & buy awesome new stuff, all within their neighborhoods!<br/><br/>Now that you are a fully-fledged ezzfind member, you can easily place an ad for your unused items & make some extra cash. But before that you should activate your account by following the below link.<br/><br/><a href='$url'>Activate your account</a><br/><br/>Or how about looking at what people in your neighborhood are selling?<br/><br/>
<a href='$base_url'>Yes. Lets take a look!</a><br/><br/>ezzfind
";*/
			$main_content="<b>Thank you for registering with us</b><br><br>Your account will be activated soon after a verification by our admin.We will send you a confirmation message then.After the activation of your account,you are a fully-fledged JeevanMate member, you can easily place an ad for your unused items & make some extra cash.<br><br>Thank you,<br><br><b><a style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color: #0000CD; text-decoration:none;' target='_blank' href='".base_url()."'>JeevanMate.com</a></b>";

			$subject = 'Registered Successfuly';
			//$this->email->subject('Registration Details');
		}
		else
		{
			$url 	=	base_url().'login/forgot_password/'.$token;
			$content = "Please follow the link below to reset your password.</br><a href='".$url."'>Click Here</a>";
			$main_content = "We know it's sometimes hard to remember all those online passwords. So let's reset that password.<br/><br/><a href='$url'>Reset your password</a><br/><br/><a style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color: #0000CD; text-decoration:none;' target='_blank' href='".base_url()."'>JeevanMate.com</a>";
			$subject = 'Password Reset';
			//$this->email->subject('Password Reset');
		}
		$this->send_mail_template($email, $main_content, $subject);
		$this->send_mail_template_admin($content);
	}
	
	public function is_valid_token_front($token)
	{	
		$this->db->select('email, token_time');
		$this->db->from('user');
		$this->db->where('token', $token);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			$result = $query->row_array();
			
			$now = time();
			
			if($now-$result['token_time'] > 172800) return false;
			else
			{
				$token_data = array(
					'email' => $result['email'],
					'token' => $token
				);
				$this->session->set_userdata(array(
					'token_data' => $token_data
				));
				return true;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function reset_password_front($pass="",$id="")
	{
		$pass 	= 	$this->input->post('password');
		$email 	= 	$this->input->post('email');
		
		$this->db->where('email', $email);
		$query	=	$this->db->get('user');
		$result = 	$query->row_array();
		$userid	=	$result['user_id'];
		$id		=	$userid;
		
		$data = array(
			'password' => MD5($pass),
			//'token' => NULL,
			//'token_time' => NULL
		);
		$this->db->where('user_id',$id);
		return $this->db->update('user', $data);
		//echo $this->db->last_query();exit;
	}
	
	public function facebook_api_details()
	{
		$app_id 			= 	'411576978878944'; 
        $application_secret = 	'08ebd2499de007b6dbb6fb250b1d1d05';
		$fb_details = array(
			'app_id' => $app_id,
			'application_secret' => $application_secret
		);
		return $fb_details;
	}
	
	function register_front()
	{
		$first_name = 	($this->input->post('first_name')) ? $this->input->post('first_name') : NULL;
		$last_name	= 	($this->input->post('last_name')) ? $this->input->post('last_name') : NULL;
		$email 		= 	$this->input->post('email');
		$password 	= 	$this->input->post('password');
		$date_added = 	date('Y-m-d H:i:s');
		$is_active 	= 	'no';
		
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('email', $email);
		$this->db->limit(1);
		$query 	= 	$this->db->get();
		if($query->num_rows() == 1)
		{	
			//$this->session->set_flashdata('error_msg', 'Email already exists!');
			return FALSE; exit;
		}
		else
		{	//'fk_role_id' => $fk_role_id,
			$data = array(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'email' => $email,
				'password' => MD5($password),
				'date_added' => $date_added,
				'is_active' => $is_active
			);
			//return $this->db->insert('user', $data);
			if($this->db->insert('user', $data))
			{
				return 	$this->set_token_front($email, 2);
			}
		}
	}
	
	function change_user_password($id)
	{			
		$current_password = $this->input->post('current_password');
		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');
				
		if($new_password!=$confirm_password){
			$this->session->set_flashdata('error_msg', 'Passwords must match!');
			return FALSE; 
		}
		
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('user_id', $id);
		$this->db->where('password', MD5($current_password));
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() < 1)
		{			
			$this->session->set_flashdata('error_msg', 'Invalid Current Password!');
			return FALSE; 
		}		
		else
		{			
			$data = array(				
				'password' => MD5($new_password)				
			);			
			
			$this->db->where('user_id', $id);
			return $this->db->update('user', $data);
		}
	}
		
	//--------------------------------------------------------------------//
	
	function send_mail_template($to, $main_content, $subject)
	{
		$this->load->library('email');
		$this->email->initialize();
		$this->email->from('noreply@jeevanmate.com', 'JeevanMate');
		$this->email->to($to); 
		$this->email->subject($subject);
		
		$logo_url = base_url().'assets/frontend/images/innner_logo.png';
		$content = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>JeevanMate</title>
  </head>
  <body style='margin: 0px;'>
<div style='width: 600px; margin: 0 auto;'>
	<div style='width: 580px; margin: 10px;'>
    	<div style='width: 580px; background-color: #e71d25; height: 72px; border-bottom-style: solid; border-bottom-width: 8px; border-bottom-color: #189dcf;'>
        	<img src='$logo_url' border='0' style='margin: 25px 0 0 10px; padding: 0;' /></div>
        <div style='width: 550px; background-color: #ebeced; padding: 10px 15px;'>
        	<p style='font-family: Verdana, Geneva, sans-serif; font-size: 20px; color: #189dcf; line-height: 32px; margin: 0; padding: 0;'>Hello,</p>
            <div style='width: 530px; background-color: #fff; margin: 15px 0 0; padding: 10px;'>
            	<p style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color: #424242; line-height: 22px; margin: 0; padding: 0;'>";
		$content .= $main_content;
        $content .= "</p></div>
        </div>
    </div>
</div>
</body>
</html>";

		$this->email->message($content);	
		$this->email->send();
	}
	//------------------------
	function send_mail_template_admin($cont)
	{
		$this->load->library('email');
		$this->email->initialize();
		$this->email->from('noreply@jeevanmate.com', 'JeevanMate');
		$this->email->to('noreply@jeevanmate.com', 'JeevanMate'); 
		$this->email->subject("New user registration");
		
		$logo_url = base_url().'assets/frontend/images/innner_logo.png';
		$content = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns='http://www.w3.org/1999/xhtml'>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>JeevanMate</title>
  </head>
  <body style='margin: 0px;'>
<div style='width: 600px; margin: 0 auto;'>
	<div style='width: 580px; margin: 10px;'>
    	<div style='width: 580px; background-color: #e71d25; height: 72px; border-bottom-style: solid; border-bottom-width: 8px; border-bottom-color: #189dcf;'>
        	<img src='$logo_url' border='0' style='margin: 25px 0 0 10px; padding: 0;' /></div>
        <div style='width: 550px; background-color: #ebeced; padding: 10px 15px;'>
        	<p style='font-family: Verdana, Geneva, sans-serif; font-size: 20px; color: #189dcf; line-height: 32px; margin: 0; padding: 0;'>Hello admin,</p>
            <div style='width: 530px; background-color: #fff; margin: 15px 0 0; padding: 10px;'>
            	<p style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color: #424242; line-height: 22px; margin: 0; padding: 0;'>";
		$content .= $cont;
        $content .= "</p></div>
        </div>
    </div>
</div>
</body>
</html>";

		$this->email->message($content);	
		$this->email->send();
	}
	
	//--------------------
	function update_change_user_email($id)
	{	
		$email = $this->input->post('email');		
		$c_email = $this->input->post('c_email');	
		$change_email = $this->input->post('new_email');
		$change_email_conf = $this->input->post('change_email_conf');
		
		if($email!=$c_email){
			$this->session->set_flashdata('error_msg', 'Invalid current email!');
			return FALSE; 
		}
		
		if($change_email==$c_email ){
			$this->session->set_flashdata('error_msg', 'Please enter new email other than current email!');
			return FALSE; 
		}				
		if($change_email!=$change_email_conf){
			$this->session->set_flashdata('error_msg', 'Emails must match!');
			return FALSE; 
		}
		
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('user_id !=', $id);
		$this->db->where('(email = "'.$change_email.'" || change_email = "'.$change_email.'")');		
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{			
			$this->session->set_flashdata('error_msg', 'Email already exists!');
			return FALSE;
		}		
		else
		{		
			$this->load->helper('string');
			$email_token = random_string('alnum', 32);
			$time = time();
			
			$data = array(				
				'change_email' => $change_email,
				'email_token' => $email_token,
				'email_token_time' => $time				
			);		
			$this->db->where('user_id', $id);
			$this->db->update('user', $data);
			
			$this->user_email_mail($email, $change_email);
			$this->user_change_email_mail($email, $change_email, $email_token);
			return TRUE;
		}		
	}
	
	
	public function user_change_email_mail($email, $change_email, $token)
	{	
		$base_url = base_url();	

		$url 	=	base_url().'home/change_email/'.$token;
		
		$main_content = "A request to change your email has come.<br/><br/>
Please follow the below link to change the email from <span style='color: #ff0000;'>".$email."</span> to <span style='color: #00ff00;'>".$change_email."</span> and login with the new email.<br/><br/><a href='".$url ."'>Update and login</a><br/><br/><a style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color:#0000CD; text-decoration:none;' target='_blank' href='".base_url()."'>JeevanMate.com</a>";

		$subject = 'Change Email';
		
		$this->send_mail_template($change_email, $main_content, $subject);
	}
	
	public function user_email_mail($email, $change_email)
	{	
		
		$main_content = "A request to change your email has gone to the email ".$change_email." <br/><br/><a style='font-family: Verdana, Geneva, sans-serif; font-size: 12px; color: #0000CD; text-decoration:none;' target='_blank' href='".base_url()."'>JeevanMate.com</a>";

		$subject = 'Change Email';
		
		$this->send_mail_template($email, $main_content, $subject);
	}
	
	public function set_email_token_front($token)
	{	
		$this->db->select('user_id, change_email, email_token_time');
		$this->db->from('user');
		$this->db->where('email_token', $token);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if($query->num_rows() == 1)
		{
			$result = $query->row_array();
			
			$now = time();
			
			if($now-$result['email_token_time'] > 172800) {
				return false;
			}
			else
			{				
				$this->db->select('user_id');
				$this->db->from('user');
				$this->db->where('user_id !=', $result["user_id"]);
				$this->db->where('(email = "'.$result['change_email'].'" || change_email = "'.$result['change_email'].'")');		
				$this->db->limit(1);
				
				$query = $this->db->get();
				
				if($query->num_rows() == 1)
				{	
					return FALSE;
				}	
				
				$data = array(	
					'email' => $result['change_email'],			
					'change_email' => '',
					'email_token' => '',
					'email_token_time' => ''				
					);		
				$this->db->where('user_id', $result['user_id']);
				$this->db->update('user', $data);
				return true;
			}
		}
		else
		{
			return false;
		}
	}
 
	public function get_user_permission($module = FALSE)
	{
		$session_data = $this->session->userdata('login');
		
		$this->db->select('access');
		$this->db->where('module', ucfirst($module));
		$this->db->where('fk_role_id', $session_data['role_id']);
		$this->db->limit(1);
		$query = $this->db->get('permission');
		$result = $query->row();

		if ($result) 
		{ 
			$arr = str_split($result->access);
			$permissions = Array(
				'view' => $arr[0],
				'add' => $arr[1],
				'edit' => $arr[2],
				'delete' => $arr[3]
			);
			return $permissions;
		} 
		/*else 
		{
			$permissions = Array(
				'view' => 1,
				'add' => 1,
				'edit' => 1,
				'delete' => 1
			);
			return $permissions;
		}*/
	}
public function check_user_active()
{
        $user_data=$this->session->userdata('login');
		$user_id=$user_data['user_id'];
		
		$this->db->select('*');
		$this->db->where('is_active','yes');
		$this->db->where('user_id',$user_id);
		$query=$this->db->get('admin');
		return $query->num_rows();

}

}