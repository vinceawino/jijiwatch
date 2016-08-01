<?php

/**
 * Created by PhpStorm.
 * User: miles
 * Date: 7/5/16
 * Time: 7:00 PM
 */
class User_model extends CI_Model
{
    function get_accounts(){
        $sql="SELECT * FROM accounts";
        return $this->db->query($sql)->result();
    }
    function get_jurisdictions(){
        $sql="SELECT * FROM jurisdiction";
        return $this->db->query($sql)->result();
    }
    function getIncidentTypes(){
        $sql="SELECT * FROM incident_type";
        return $this->db->query($sql)->result();
    }
    function create_user(){
        $password=$this->input->post('password');
        $accounts_data = array(
            'firstname' 	=> $this->input->post('first_name'),
            'lastname'  	=> $this->input->post('last_name'),
            'username'  	=> $this->input->post('username'),
            'email'    	=> $this->input->post('email'),
            'password' 	 	=> $hash = $this->bcrypt->hash_password($password),
            'account_type'  => $this->input->post('account_type'),
            'address'      => $this->input->post('address'),
            'mobile_phone'   => $this->input->post('phone'),
            'idnumber'	=> $this->input->post('idnumber'),
            'jurisdiction_id'=>$this->input->post('jurisdiction'),
            'active'=>true
        );
        $this->db->trans_start();
        $this->db->insert('users', $accounts_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            //$this->set_error('Unknown error, User creation unsuccessful');
            return FALSE;
        }else{
            return TRUE;
        }

    }
    /**
     *Based on ion_auth library
     */
    public function login($username, $password)
    {
        if (empty($username) || empty($password))
        {
            //$this->set_error('login unsuccessful');
            return FALSE;
        }

        $query = $this->db->select('id, firstname, lastname, account_type, active, jurisdiction_id, address,mobile_phone,email,date_created,password,idnumber,username')
            ->where('username', $username)
            ->limit(1)
            ->order_by('id', 'desc')
            ->get('users');

        if ($query->num_rows() === 1)
        {

            $user = $query->row();
            //var_dump($user);
            $stored_hash=$user->password;

            if ($this->bcrypt->check_password($password, $stored_hash))
            {
                $this->session->set_userdata('is_loggedin',1);
                // Password does match stored password.
                return TRUE;
            }
            else
            {
                // Password does not match stored password.
                return FALSE;
            }

        }else{
            return FALSE;
        }

        // Hash something anyway, just to take up time
        //$this->bcrypt->check_password($password, $user->password);

        //$this->set_error('login unsuccessful');

        //return FALSE;
    }
    public function getIncidents($status){
        if($status=='pending'){
            $query="select t1.id,t2.description as incident_type,t1.description,t1.recordtime,t1.status,t1.phone,t1.upload,t4.id as report_id,t1.x,t1.y,t5.name as jurisdiction 
                from incidents t1 inner join incident_type t2 on t1.incident_type = t2.id
                INNER JOIN reports t4 on t1.report_id=t4.id
                INNER JOIN jurisdiction t5 on t1.jurisdiction_id=t5.id
                WHERE t1.status='1'";
            return $this->db->query($query)->result();
        }elseif($status=='finished'){
            $query="select t1.id,t2.description as incident_type,t1.description,t1.recordtime,t1.status,t3.username as officer_id,t1.phone,t1.upload,t4.id as report_id,t1.x,t1.y,t5.name as jurisdiction 
                from incidents t1 inner join incident_type t2 on t1.incident_type = t2.id
                inner join users t3 on t1.admin_id=t3.id
                INNER JOIN reports t4 on t1.report_id=t4.id
                INNER JOIN jurisdiction t5 on t1.jurisdiction_id=t5.id
                WHERE t1.status='0'";
            return $this->db->query($query)->result();
        }


    }
    public function deletUser($userid){
        $this->db->where('id',$userid);
        $this->db->delete('users');
    }
    public function getActiveOfficers($incident_id){
        /*$sql="select * from incidents WHERE id=$incident_id";
        $result=$this->db->query($sql)->result();
        $juris=$result[0]->jurisdiction_id;*/
       /* $s=$jurisdiction.jurisdiction_id;
        var_dump($s);*/
        $query="select t1.id,t2.username,t2.id as user_id,t3.description as incident_type
                from incidents t1 inner join users t2 on t2.id > 0
                INNER JOIN incident_type t3 ON t1.incident_type=t3.id
                WHERE t1.id=$incident_id";
        //$officer="select t1.id,t1.username from users t1 INNER JOIN jurisdiction t2 on $juris=t2.id WHERE t1.active=TRUE";
        return $this->db->query($query)->result();
    }
    public function getReports($userid){
        $query="select t1.id,t1.date_created,t1.last_edited,t1.admin_report,t1.officer_report,t2.username as admin_id,t3.username as officer_id,t1.status,t1.user_id,t1.incident_id,t4.description 
                from reports t1 inner join users t2 on t1.admin_id = t2.id
                inner join users t3 on t1.officer_id=t3.id
                INNER JOIN incidents t4 on t1.incident_id=t4.id
                ";
        return $this->db->query($query)->result();
    }
    public function getReport($id){
        $query="select t1.id,t1.date_created,t1.last_edited,t1.admin_report,t1.officer_report,t2.username as admin_id,t3.username as officer_id,t1.status,t5.id as username,t1.incident_id,t4.description 
                from reports t1 inner join users t2 on t1.admin_id = t2.id
                inner join users t3 on t1.officer_id=t3.id
                inner JOIN users t5 on t1.officer_id=t5.id
                INNER JOIN incidents t4 on t1.incident_id=t4.id
                WHERE t1.id=$id";
        return $this->db->query($query)->result();
    }
    public function updateIncident($incident,$user){
        $this->db->set('officer_id',$user)
                    ->where('id',$incident)
                    ->update('incidents');
    }
    public function updateReport($admin_report,$officer_report,$report_id){
        $this->db->set('admin_report',$admin_report)
            ->where('id',$report_id)
            ->update('reports');
        $this->db->set('officer_report',$officer_report)
            ->where('id',$report_id)
            ->update('reports');
    }
    public function updateUser(){
        $userid=$this->input->post('userid');
        $this->db->set('firstname',$this->input->post('firstname'))
            ->where('id',$userid)
            ->update('users');
        $this->db->set('lastname',$this->input->post('lastname'))
            ->where('id',$userid)
            ->update('users');
        $this->db->set('jurisdiction_id',$this->input->post('jurisdiction'))
            ->where('id',$userid)
            ->update('users');
        $this->db->set('email',$this->input->post('email'))
            ->where('id',$userid)
            ->update('users');
        $this->db->set('mobile_phone',$this->input->post('mobile'))
            ->where('id',$userid)
            ->update('users');
        $this->db->set('idnumber',$this->input->post('idnumber'))
            ->where('id',$userid)
            ->update('users');
        return TRUE;
    }
    public function getUsers($type){
        $query="select t1.id, t1.firstname,t1.lastname,t1.active,t1.address,t1.mobile_phone,t1.email,t1.date_created,t1.idnumber,t1.username,t2.name as jurisdiction from users t1 inner join jurisdiction t2 on t1.jurisdiction_id=t2.id where t1.account_type=$type";
        return $this->db->query($query)->result();
    }
    public function  getUser($id){
        $query="select t1.id, t1.firstname,t1.lastname,t1.active,t1.address,t1.mobile_phone,t1.email,t1.date_created,t1.idnumber,t1.username,t2.name as jurisdiction from users t1 inner join jurisdiction t2 on t1.jurisdiction_id=t2.id where t1.id=$id";
        return $this->db->query($query)->result();  
    }
    public function analyze($type,$start_date,$end_date,$day){
        /*
        (incident = 'Garbage') AND (day_ = 'Sun' OR day_ = 'Sat' OR day_ = 'Fri' OR day_ = 'Mon' OR day_ = 'Tue' OR day_ = 'Wed' OR day_ = 'Thu') AND (date_ >= timestamp '2016-05-25 00:00:00' AND date_ <= timestamp '2016-12-31 00:00:00')
        */
        $query="select t1.id,t1.description,t1.x,t1.y,t2.description as type 
                from incidents t1 inner join incident_type t2 on t1.incident_type = t2.id
                WHERE t1.incident_type=$type AND t1.status=0";
    }
    


}