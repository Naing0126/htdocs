<?php

session_start(); //we need to start session in order to access it through CI

Class Login extends CI_Controller {

public function __construct() {
parent::__construct();

// Load form helper library
$this->load->helper('form');

// Load form validation library
$this->load->library('form_validation');

// Load session library
$this->load->library('session');

// Load database
$this->load->model('user_model');

}

// Show login page
public function user_login_show() {
$this->load->view('login_form');
}

// Show registration page
public function user_registration_show() {
$this->load->view('registration_form');
}

// Validate and store registration data in database
public function new_user_registration() {

// Check validation for user input in SignUp form
$this->form_validation->set_rules('userid', 'Userid', 'trim|required|xss_clean');
$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
if ($this->form_validation->run() == FALSE) {
$this->load->view('registration_form');
} else {
$data = array(
'user_id' => $this->input->post('userid'),
'user_name' => $this->input->post('username'),
'user_pw' => $this->input->post('password')
);
$result = $this->user_model->registration_insert($data) ;
if ($result == TRUE) {
$data['message_display'] = 'Registration Successfully !';
$this->load->view('login_form', $data);
} else {
$data['message_display'] = 'Username already exist!';
$this->load->view('registration_form', $data);
}
}
}

// Check for user login process
public function user_login_process() {

$this->form_validation->set_rules('userid', 'Userid', 'trim|required|xss_clean');
$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

if ($this->form_validation->run() == FALSE) {
$this->load->view('login_form');
} else {
$data = array(
'user_id' => $this->input->post('userid'),
'user_pw' => $this->input->post('password')
);
$result = $this->user_model->login($data);
if($result == TRUE){
$sess_array = array(
'user_id' => $this->input->post('userid')
);

// Add user data in session
$this->session->set_userdata('logged_in', $sess_array);
$result = $this->user_model->read_user_information($sess_array);
if($result != false){
$data = array(
'user_name' =>$result[0]->user_name,
'user_id' =>$result[0]->user_id,
'user_pw' =>$result[0]->user_pw
);
$this->load->view('admin_page', $data);
}
}else{
$data = array(
'error_message' => 'Invalid Username or Password'
);
$this->load->view('login_form', $data);
}
}
}

// Logout from admin page
public function logout() {

// Removing session data
$sess_array = array(
'user_id' => ''
);
$this->session->unset_userdata('logged_in', $sess_array);
$data['message_display'] = 'Successfully Logout';
$this->load->view('login_form', $data);
}
}

?>