<?php

class Form extends CI_Controller {

    function index()
    {
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');

$config = array(
               array(
                     'field'   => 'username',
                     'label'   => 'Username',
                     'rules'   => 'trim|required|min_length[5]|max_length[12]|xss_clean'
                  ),
               array(
                     'field'   => 'password',
                     'label'   => 'Password',
                     'rules'   =>  'trim|required|md5'
                  )
            );

$this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('myform');
        }
        else
        {
            $this->load->view('formsuccess');
        }
    }
}
?>