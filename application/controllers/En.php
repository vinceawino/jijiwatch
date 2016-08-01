<?php
/**
 * Created by PhpStorm.
 * User: miles
 * Date: 7/5/16
 * Time: 1:08 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class En extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Api_model');
        //Load model here
    }

    public function index()
    {
        $this->login();
    }
    public function login(){
        if(isset($_POST)&&!empty($_POST)) {
            $this->_autheticate();
        }else{
            $this->load->view('login_view');
        }
    }
    public function logout(){
        $this->session->set_userdata('is_loggedin',0);
        $this->login();
    }

    public function register(){
        $data['accounts']=$this->User_model->get_accounts();
        $data['jurisdictions']=$this->User_model->get_jurisdictions();
        if(isset($_POST)&&!empty($_POST)) {
            $this->__validate($_POST);
            //$this->load->view('register_view');
        }else{
            $data['message']='All fields are required.';
            $this->load->view('register_view',$data);

        }
    }
    public function map_view(){
        if($this->session->userdata('is_loggedin')){
            $this->load->view('map');
        }else{
            $this->login();
        }
    }
    public function dashboard(){
        if($this->session->userdata('is_loggedin')){
           $this->incidents("pending");
        }else{
            $this->login();
        }

    }
    public function users($type){
        if($type=='admins'){
            $data['content']='users_view';
            $data['type']='Admins';
            $data['users']=$this->User_model->getUsers(1);
            $this->load->view('common/Main_template',$data);
        }elseif($type=='officers'){
            $data['content']='users_view';
            $data['type']='Officers';
            $data['users']=$this->User_model->getUsers(0);
            $this->load->view('common/Main_template',$data);
        }elseif(ctype_digit($type)){
            $data['content']='edit_user';
            $data['jurisdictions']=$this->User_model->get_jurisdictions();
            $data['user']=$this->User_model->getUser($type)[0];
            $this->load->view('common/Main_template',$data);
        }else{
            
        }

    }
    public function delete($userid){
        if($userid==0) {
            redirect('index.php/en/users/admins', 'refresh');
        }else{
            $this->User_model->deletUser($userid);
            redirect('index.php/en/users/admins', 'refresh');
        }

    }
    /*
    */
    public function analysis(){
        $this->load->view('analysis');
    }

    //passing incident id
    public function  incidents($filter){
        $data['title']='Jijiwatch';
        if($filter=='pending'){
            $data['content']='pending';
            $data['incidents']=$this->User_model->getIncidents($filter);
            $this->load->view('common/Main_template',$data);
        }elseif(ctype_digit($filter)){
            //$this->_load_single_sentry_view($filter);
            $officers=$this->User_model->getActiveOfficers($filter);
            $data['content']='incident_details';
            $data['jurisdictions']=$this->User_model->get_jurisdictions();
            if(!empty($officers)) {
                $data['officers'] = $this->User_model->getActiveOfficers($filter);
            }else{

            }
            $this->load->view('common/Main_template',$data);
        }elseif($filter=='finished'){
            $data['content']='finished';
            $data['incidents']=$this->User_model->getIncidents($filter);
            $this->load->view('common/Main_template',$data);
        }
    }
    public function getOfficers(){
         if(isset($_POST)&&!empty($_POST)) {
             $incident=$this->input->post('incident');
             $data['jurisdictions']=$this->User_model->get_jurisdictions();
             $data['officers']=$this->User_model->getActiveOfficers($incident);
             echo json_encode($data);
         }else{
            redirect('index.php/en/dashboard', 'refresh');
         }
    }
    public function updateReport(){
        if(isset($_POST)&&!empty($_POST)) {
            $report_id=$this->input->post('report_id');
            $admin_report=$this->input->post('admin_report');
            $officer_report=$this->input->post('officer_report');
            $this->User_model->updateReport($admin_report,$officer_report,$report_id);
            redirect('index.php/en/reports/list');
        }else{
            redirect('index.php/en/reports/list');
        }
    }
    public function updateUser(){
        if(isset($_POST)&&!empty($_POST)) {
            $this->form_validation->set_rules('firstname', 'First name', 'required');
            $this->form_validation->set_rules('lastname', 'Last name', 'required');
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('mobile', 'Phone', 'required');
            $this->form_validation->set_rules('idnumber', 'ID Number', 'required');
            $this->form_validation->set_rules('jurisdiction', 'Jurisdiction', 'required');
            $this->form_validation->set_rules('userid', 'User ID', 'required');
            if ($this->form_validation->run() == FALSE){
                $dat['jurisdictions']=$this->User_model->get_jurisdictions();
                $dat['message'] = (validation_errors());
                $data['content']='edit_user';
                $data['user']=$this->User_model->getUser($this->input->post('userid'))[0];
                $this->load->view('common/Main_template',$data);
            }else {
                if ($this->User_model->updateUser() == TRUE) {
                    redirect('index.php/en/users/admins');
                } else {
                    redirect('index.php/en/users/admins');
                }
            }
        }else{
            redirect('index.php/en/users/admins');
        }

    }
    public function reports($filter){
        if($filter=='list'){
            $data['content']='all_reports';
            $data['reports']=$this->User_model->getReports(0);
            $this->load->view('common/Main_template',$data);
        }elseif (ctype_digit($filter)){
            $data['content']='report_details';
            $temp=$this->User_model->getReport($filter);
            $data['report']=$temp[0];
            $this->load->view('common/Main_template',$data);
        }elseif ($filter=='bar'){

        }elseif ($filter=='pie'){

        }

    }
    public function dispatch(){
        if(isset($_POST)&&!empty($_POST)) {
            $this->form_validation->set_rules('incident_id', 'Incident ID', 'required');
            $this->form_validation->set_rules('officer_id', 'Officer ID', 'required');
            $this->form_validation->set_rules('admin_comment', 'Admin comment', 'required|min_length[5]');
            $this->form_validation->set_rules('incident_type', 'Incident type', 'required');
            if ($this->form_validation->run() == FALSE){
                redirect('index.php/en/incidents/pending', 'refresh');
                //index.php/en/incidents/10
            }else{
                //Send dispatch SMS here
                $incident=$this->input->post('incident_id');
                $officer=$this->input->post('officer_id');
                $admin_comment=$this->input->post('admin_comment');
                $incident_type=$this->input->post('incident_type');
                //Update database and redirect back
                if ($this->Api_model->dispatch($incident,$officer,$admin_comment,$incident_type)==TRUE){
                    redirect('index.php/en/incidents/finished', 'refresh');
                }else{
                    redirect('index.php/en/incidents/pending', 'refresh');
                }
            }
        }else{
            redirect('index.php/en/incidents/pending', 'refresh');
        }

    }

    public function adduser(){
        $data['content']='Add_user';
        $this->load->view('common/Main_template',$data);
    }
    function _autheticate(){
        //validate form input
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == true){
            if ($this->User_model->login($this->input->post('username'), $this->input->post('password')))
            {
                redirect('index.php/en/dashboard', 'refresh');
            }else{
                redirect('index.php/en/login', 'refresh');
            }
        }else{
            $data['message'] = (validation_errors());
            $this->load->view('login_view',$data);
        }
    }
        public function __validate($data){

        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[verify_password]');
        $this->form_validation->set_rules('verify_password', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('account_type', 'Account type', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|min_length[12]|max_length[12]');
        $this->form_validation->set_rules('idnumber', 'ID Number', 'required|is_unique[users.idnumber]');
        $this->form_validation->set_rules('jurisdiction', 'Jurisdiction', 'required');

        if ($this->form_validation->run() == FALSE){
            $dat['accounts']=$this->User_model->get_accounts();
            $dat['jurisdictions']=$this->User_model->get_jurisdictions();
            $dat['message'] = (validation_errors());
            $this->load->view('register_view',$dat);
        }else{
            if ($this->User_model->create_user()==TRUE){
                redirect('index.php/en/dashboard', 'refresh');
            }else{
                redirect('index.php/en/register', 'refresh');
            }
        }

        

    }
    
}
