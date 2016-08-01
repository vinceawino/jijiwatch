<?php

/**
 * Created by PhpStorm.
 * User: myles
 * Date: 7/28/16
 * Time: 8:03 PM
 */
class Api extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->model('User_model');
    }
    //insert incident
    public function insert(){
        if(isset($_POST)&&!empty($_POST)) {
            $this->doInsert($_POST);
        }else{
            $dat['status']='error';
            $dat['message']='Unauthorized access of this method';
            echo json_encode($dat);
        }
    }
    function doInsert($data){
        $this->form_validation->set_rules('incident_type', 'Incident type', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('recordtime', 'Record time', 'required');
        $this->form_validation->set_rules('phone', 'Phone', '');
        $this->form_validation->set_rules('upload', 'Image', '');
        $this->form_validation->set_rules('x', 'X', 'required');
        $this->form_validation->set_rules('y', 'Y', 'required');
        $this->form_validation->set_rules('day', 'Day', 'required');
        $this->form_validation->set_rules('jurisdiction_id', 'Location', 'required');
        if ($this->form_validation->run() == FALSE){
            $dat['status']='error';
            $dat['message']=strip_tags(validation_errors(),'');
            echo json_encode($dat);
        }else{
            if ($this->Api_model->doInsert()==TRUE){
                $dat['status']='success';
                $dat['message']='Incident inserted successfully.Our team will respond soon.';
                echo json_encode($dat);
            }else{
                $dat['status']='error';
                $dat['message']='Unable to insert incident.';
                echo json_encode($dat);
            }

        }


    }
    public function hotspot(){
        if(isset($_POST)&&!empty($_POST)) {
            $type=$this->input->post('type');
            $from=$this->input->post('from');
            $to=$this->input->post('to');
            if($this->Api_model->hotspot($type,$from,$to)==null || count($this->Api_model->hotspot($type,$from,$to)<10)){
                $data['success']='false';
                $data['message']='The incidents are few for analysis';
                echo json_decode($data);
            }else {
                $data['success'] = 'true';
                $data['incidents'] = $this->Api_model->hotspot($type, $from, $to);
                echo json_decode($data);
            }
        }else{
            echo ("Unauthorized access");
        }
    }
    public function getJurisdictions(){
        $dat['status']='success';
        $dat['jurisdictions']=$this->User_model->get_jurisdictions();
        echo json_encode($dat);
    }
    public function getIncidentTypes(){
        $dat['status']='success';
        $dat['types']=$this->User_model->getIncidentTypes();
        echo json_encode($dat);
    }
    public function dispatch(){
        if(isset($_POST)&&!empty($_POST)) {
            $this->doDispatch($_POST);
        }else{
            $dat['status']='error';
            $dat['message']='Unauthorized access of this method';
            echo json_encode($dat);
        }
    }
    public function  getIncidents(){
        $data['status']='success';
        $data['incidents']=$this->Api_model->getIncidents();
        echo json_encode($data);

    }
    function doDispatch($data){
        $this->form_validation->set_rules('incident_id', 'Incident ID', 'required');
        $this->form_validation->set_rules('officer_id', 'Officer ID', 'required');
        $this->form_validation->set_rules('admin_comment', 'Admin comment', 'required');
        $this->form_validation->set_rules('incident_type', 'Incident type', 'required');
        if ($this->form_validation->run() == FALSE){
            $dat['status']='error';
            $dat['message']=strip_tags(validation_errors(),'');
            echo json_encode($dat);
        }else{
            $incident=$this->input->post('incident_id');
            $officer=$this->input->post('officer_id');
            $admin_comment=$this->input->post('admin_comment');
            $incident_type=$this->input->post('incident_type');
            $this->Api_model->dispatch($incident,$officer,$admin_comment,$incident_type);
            if ($this->Api_model->dispatch($incident,$officer,$admin_comment,$incident_type)==TRUE){
                $dat['status']='success';
                $dat['message']='Message sent successfully';
                echo json_encode($dat);
            }else{
                $dat['status']='error';
                $dat['message']='Unable to send message.';
                echo json_encode($dat);
            }
        }

    }

}