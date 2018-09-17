<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_pagination extends MY_Controller {
 
 function __construct() {
	 parent::__construct();
	 $this->model = $this->input->get('model', TRUE);
	 $this->order_by = $this->input->get('order_by', TRUE);
	 $this->order = $this->input->get('order', TRUE);
	 $this->load->model($this->model);
	 $this->view_fn	=	$this->input->get('view_fn', TRUE);
 }
 
 function pagination()
 {
  $this->load->library("pagination");
  $config = array();
  $config["base_url"] = "#";
  $config["total_rows"] = $this->{$this->model}->count_all();
  $config["per_page"] = 1;
  $config["uri_segment"] = 4;
  $config["use_page_numbers"] = TRUE;
  $config["full_tag_open"] = '<div class="box-footer clearfix">
              <ul class="pagination pagination-sm no-margin pull-right">';
  $config["full_tag_close"] = '</ul></div>';
  $config["first_tag_open"] = '<li>';
  $config["first_tag_close"] = '</li>';
  $config["last_tag_open"] = '<li>';
  $config["last_tag_close"] = '</li>';
  $config['next_link'] = '&gt;';
  $config["next_tag_open"] = '<li>';
  $config["next_tag_close"] = '</li>';
  $config["prev_link"] = "&lt;";
  $config["prev_tag_open"] = "<li>";
  $config["prev_tag_close"] = "</li>";
  $config["cur_tag_open"] = "<li class='active'><a href='#'>";
  $config["cur_tag_close"] = "</a></li>";
  $config["num_tag_open"] = "<li>";
  $config["num_tag_close"] = "</li>";
  $config["num_links"] = 2;
  $this->pagination->initialize($config);
  $page = $this->uri->segment(4);
  $start = ($page - 1) * $config["per_page"];

  $output = array(
   'pagination_link'  => $this->pagination->create_links(),
   'loaded_content'   => $this->{$this->model}->{$this->view_fn}($this->order_by, $this->order, $config["per_page"], $start)
  );
  echo json_encode($output);
 }
}
