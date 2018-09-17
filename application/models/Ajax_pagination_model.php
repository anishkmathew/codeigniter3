<?php
class Ajax_pagination_model extends CI_Model
{
 function count_all()
 {
  $query = $this->db->get("countries");
  return $query->num_rows();
 }

 function fetch_details($limit, $start)
 {
  $output = '';
  $this->db->select("*");
  $this->db->from("countries");
  $this->db->order_by("name", "ASC");
  $this->db->limit($limit, $start);
  $query = $this->db->get();
  $output .= '
  <table class="table table-bordered">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>User Name</th>
                  <th>Email</th>
                  <th style="width: 40px">ID</th>
                </tr>
  ';
  
  <tr>
                  <td><?php echo ++$num?></td>
                  <td><?php echo $user_data['username']?></td>
                  <td><?php echo $user_data['email']?></td>
                  <td><span class="badge bg-red"><?php echo $user_data['id']?></span></td>
                </tr>
  
  foreach($query->result() as $row)
  {
   $output .= '
   <tr>
    <td>'.$row->id.'</td>
    <td>'.$row->name.'</td>
	<td>'.$row->name.'</td>
	<td>'.$row->id.'</td>
   </tr>
   ';
  }
  $output .= '</table>';
  return $output;
 }
}