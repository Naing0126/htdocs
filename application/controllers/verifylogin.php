<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user_model','',TRUE);
   $this->load->library('form_validation','session');

 }

 function index()
 {
   //This method will have the credentials validation

   $this->form_validation->set_rules('user_id', 'User_id', 'trim|required|xss_clean');
   $this->form_validation->set_rules('user_pw', 'User_pw', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
     $this->load->view('login_view');
   }
   else
   {
     //Go to private area
     redirect('home', 'refresh');
   }

 }

 function check_database($user_pw)
 {
   //Field validation succeeded.  Validate against database
   $user_id = $this->input->post('user_id');

   //query the database
   $result = $this->user_model->login($user_id, $user_pw);

   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
         'user_name' => $row->user_name
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
     return false;
   }
 }
}
?>