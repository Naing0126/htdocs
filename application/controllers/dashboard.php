<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
  function  __construct(){
    parent::__construct();

         // Load database
    $this->load->database();
    $this->load->model('directory_model');
    $this->load->model('sensor_model');
    $this->load->model('node_model');
    $this->load->model('include_model');
    $this->load->model('dashboard_model');
    $this->load->model('data_model');
    $this->load->model('trigger_model');
    $this->load->model('connect_model');
         // Load form helper library
    $this->load->helper('form');
         // Load form validation library
    $this->load->library('form_validation');

         // Load session library
    $this->load->library('session');
  }

  function index(){
    $data = array(
      'user_name' => $this->session->userdata('user_name'),
      'uid' => $this->session->userdata('uid')
      );

    $this->load->view('head',$data);
    $this->load->view('frame',$data);
    $this->load->view('footer');
  }

  function mindex($name,$uid){
    $data = array(
      'user_name' => $name,
      'uid' => $uid
      );

    $this->session->set_userdata($data);

    $this->load->view('head',$data);
    $this->load->view('frame',$data);
    $this->load->view('footer');
  }

  function directory_list(){
    $uid = $this->session->userdata('uid');
    $directories = $this->directory_model->gets($uid);
    $this->load->view('directory_list',array('directories'=>$directories));
  }

  function add_directory(){
       // Check validation for user input in add Directory form
    $this->form_validation->set_rules('directory_name', 'directory_name', 'trim|required|xss_clean');
    if ($this->form_validation->run() == FALSE) {
     $this->index($data);
   } else {
    $data = array(
      'directory_uid' => $this->session->userdata('uid'),
      'directory_name' => $this->input->post('directory_name')
      );
    $result = $this->directory_model->directory_insert($data) ;
    if ($result == TRUE) {
      $data['message_display'] = 'add Directory Successfully !';
      $this->directory_list();
    } else {
      $data['message_display'] = 'cannot add Directory!';
    }
  }
}

function delete_directory(){
       // Check validation for user input in add Directory form
  $data = array(
    'did' => $this->input->post('did')
    );
  $result = $this->directory_model->directory_delete($data) ;
  if ($result == TRUE) {
    $data['message_display'] = 'delete Directory Successfully !';
    $uid = $this->session->userdata('uid');
    $this->directory_list();
  } else {
    $data['message_display'] = 'cannot delete Directory!';
    $uid = $this->session->userdata('uid');
    $this->directory_list();
  }
}

function update_directory(){
       // Check validation for user input in add Directory form
  $this->form_validation->set_rules('directory_name', 'directory_name', 'trim|required|xss_clean');
  if ($this->form_validation->run() == FALSE) {
   $this->index($data);
 } else {
  $data = array(
    'directory_name' => $this->input->post('directory_name'),
    'did' => $this->input->post('did')
    );
  $result = $this->directory_model->directory_update($data) ;
  if ($result == TRUE) {
    $data['message_display'] = 'update Directory Successfully !';
    $this->load_directory($data['did']);
  } else {
    $data['message_display'] = 'cannot update Directory!';
    $this->index();
  }
}
}

function load_directory($did){
 $data['sensors'] = $this->include_model->gets($did);
 $data['did'] = $did;
 $data['directory_name'] = $this->directory_model->getName($did);
 $uid = $this->session->userdata('uid');
 $data['nodes'] = $this->connect_model->get_connected_nodes($uid);
 $this->load->view('include_sensor_list',$data);
}

function get_included_sensors($nid){
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->sensor_model->get_included_sensors($nid)));
 exit;
}

function add_sensor_to_directory($did,$sid,$nid) {
  $data = array(
    'did' => $did,
    'sid' => $sid,
    'nid' => $nid
    );
  header('Content-Type: application/json; charset=utf-8');
  echo(json_encode($this->include_model->new_include($data)));
  exit;
}

function delete_sensor_from_directory($did,$sid,$nid) {
  $data = array(
    'did' => $did,
    'sid' => $sid,
    'nid' =>$nid
    );
  header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->include_model->delete_include($data)));
  exit;
}

function dashboard_list(){
 $uid = $this->session->userdata('uid');
 $widgets = $this->dashboard_model->gets($uid);
 $data['widgets'] = $widgets;
 $widgets_sid = $this->dashboard_model->getWidgetsSid($uid);
 $widgets_nid = $this->dashboard_model->getWidgetsNid($uid);
 $data['data_time'] = $this->data_model->getTime($widgets_sid, $widgets_nid);
 $data['data_value'] = $this->data_model->getValue($widgets_sid,$widgets_nid);
 $data['uid'] = $uid;
 $data['nodes'] = $this->connect_model->get_connected_nodes($uid);
 $this->load->view('dashboard_list',$data);
}
function add_sensor_to_dashboard($uid,$sid) {
  $data = array(
    'dashboard_id' => $uid,
    'sensor_id' => $sid
    );
  header('Content-Type: application/json; charset=utf-8');
  echo(json_encode($this->dashboard_model->new_widget($data)));
  exit;
}

function add_widget_to_dashboard($uid,$type) {
  $data = array(
    'dashboard_id' => $uid,
    'widget_type' => $type
    );
  header('Content-Type: application/json; charset=utf-8');
  echo(json_encode($this->dashboard_model->new_widget($data)));
  exit;
}

function connect_widget_with_sensor($widget_id,$sid,$nid){
 $data = array(
  'widget_id' => $widget_id,
  'sensor_id' => $sid,
  'sensor_nid' => $nid
  );
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->dashboard_model->update_widget($data)));
 exit;
}

function delete_widget_from_dashboard($uid,$widget_id) {
  $data = array(
    'dashboard_id' => $uid,
    'widget_id' => $widget_id
    );
  $result = $this->dashboard_model->delete_widget($data) ;
  if ($result == TRUE) {
    $data['message_display'] = 'delete include Successfully !';
  } else {
    $data['message_display'] = 'cannot delete include!';
  }
}

function update_widget_position($uid,$widget_id,$x,$y) {
  $data = array(
    'widget_id' => $widget_id,
    'dashboard_id' => $uid,
    'x' => $x,
    'y' => $y
    );
  header('Content-Type: application/json; charset=utf-8');
  echo(json_encode($this->dashboard_model->update_widget($data)));
  exit;
}

function trigger_list(){
  $uid = $this->session->userdata('uid');
  $data['uid'] = $uid;
  $data['nodes'] = $this->connect_model->get_connected_nodes($uid);
  $data['triggers'] = $this->trigger_model->gets($uid);
  $this->load->view('trigger_list',$data);
}

function add_trigger() {
   $info = json_decode(stripslashes($_POST["info"]));
 header('Content-Type: application/json; charset=utf-8');
echo(json_encode($this->trigger_model->insert_trigger($info)));
}

function update_trigger($tid) {
   $info = json_decode(stripslashes($_POST["info"]));
   $data['tid'] = $tid;
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->trigger_model->update_trigger($info,$data)));
}

function delete_trigger($tid) {
  $data['tid'] = $tid;
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->trigger_model->delete_trigger($data)));
 exit;
}

function sensor_list(){
   $uid = $this->session->userdata('uid');
  $data['uid'] = $uid;
  $data['nodes'] = $this->connect_model->get_connected_nodes($uid);
  $data['sensor_list'] = $this->sensor_model->get_included_sensor_list($data['nodes']);
  $this->load->view('sensor_list',$data);
}


function add_node() {
   $info = json_decode(stripslashes($_POST["info"]));
 header('Content-Type: application/json; charset=utf-8');
echo(json_encode($this->connect_model->insert_node($info)));
  exit;
}

function add_sensor() {
   $info = json_decode(stripslashes($_POST["info"]));
 header('Content-Type: application/json; charset=utf-8');
echo(json_encode($this->sensor_model->insert_sensor($info)));
  exit;
}

function disconnect_node($uid, $nid) {
$data['uid'] = $uid;
$data['nid'] = $nid;
echo $uid;
echo $nid;
echo(json_encode($this->connect_model->disconnect_node($data)));
  exit;
}

    // Logout from admin page
public function logout() {

// Removing session data
  $sess_array = array(
    'user_id' => ''
    );
  $this->session->unset_userdata('logged_in', $sess_array);
  $data['message_display'] = 'Successfully Logout';
  $this->load->helper('url');
  redirect('main');
}

function get_directories($uid){
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->directory_model->gets($uid)));
 exit;
}

function get_included_sensors_in_directory($did){
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->include_model->get_included_sensors($did)));
 exit;
}

function get_included_sensors_in_dashboard($uid){
 header('Content-Type: application/json; charset=utf-8');
 echo(json_encode($this->dashboard_model->get_included_sensors($uid)));
 exit;
}


}
?>