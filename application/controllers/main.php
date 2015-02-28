<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {
    function  __construct(){
        parent::__construct();

        $this->load->database();
        // Load form helper library
        $this->load->helper('form');

        // Load form validation library
        $this->load->library('form_validation');

        // Load session library
        $this->load->library('session');

        // Load database
       $this->load->model('user_model');
    }

    function index(){
       //$this->load->view('welcome_message');
        $this->load->view('main_head');
        $this->load->view('main_content');
        $this->load->view('main_footer');
    }
    function get($id){
        $topics = $this->topic_model->gets();
        $topic = $this->topic_model->get($id);
        $this->load->view('head');
        $this->load->view('topic_list',array('topics'=>$topics));
        $this->load->view('get',array('topic'=>$topic));
        $this->load->view('footer');
    }

    function  sly(){
        $this->load->view('sly');
    }

// Validate and store registration data in database
    public function new_user_registration() {

// Check validation for user input in SignUp form
        $this->form_validation->set_rules('userid', 'Userid', 'trim|required|xss_clean');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
             $this->index($data);
        } else {
            $data = array(
                'user_id' => $this->input->post('userid'),
                'user_name' => $this->input->post('username'),
                'user_pw' => $this->input->post('password')
                );
            $result = $this->user_model->registration_insert($data) ;
            if ($result == TRUE) {
                $data['message_display'] = 'Registration Successfully !';
                $this->index($data);
            } else {
                $data['message_display'] = 'Username already exist!';
                $this->index($data);
            }
        }
    }

// Check for user login process
    public function user_login_process() {

        $this->form_validation->set_rules('userid', 'Userid', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data['error_message'] = 'invalid id or pw!';
            $this->index($data);
        } else {
            $data = array(
                'user_id' => $this->input->post('userid'),
                'user_pw' => $this->input->post('password')
                );
            $result = $this->user_model->login($data);
            if($result == TRUE){
                $sess_array = array(
                    'user_id' => $this->input->post('userid'),
                    );

                // Add user data in session
                $this->session->set_userdata('logged_in', $sess_array);
                $result = $this->user_model->read_user_information($sess_array);
                if($result != false){
                    $data = array(
                        'user_name' =>$result[0]->user_name,
                        'uid' =>$result[0]->uid
                        );

                    $this->session->set_userdata($data);

                    $this->load->helper('url');
                    redirect('dashboard');

                }
            }else{
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                    );
                $this->index($data);
            }
        }
    }

}
?>