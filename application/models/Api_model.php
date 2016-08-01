<?php

/**
 * Created by PhpStorm.
 * User: myles
 * Date: 7/29/16
 * Time: 5:57 PM
 */
class Api_model extends CI_Model
{
    public function doInsert(){
        $uploaddir = '/opt/lampp/htdocs/jijiwatch/uploads/';
        $uploadfile = $uploaddir . basename($_FILES['upload']['name']);
        $fileName='';
        if (move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile)) {
            $fileName=$_FILES['upload']['name'];
        } else {
            $fileName='null';
        }
        $id=rand();
        $incident_data = array(
            'id'=>$id,
            'incident_type' 	=> $this->input->post('incident_type'),
            'description'  	=> $this->input->post('description'),
            'recordtime'  	=> $this->input->post('recordtime'),
            'phone'    	 => $this->input->post('phone'),
            'upload' 	 => $fileName,
            'x'  => $this->input->post('x'),
            'y'      => $this->input->post('y'),
            'day'   => $this->input->post('day'),
            'status'	=> '1',
            'admin_id'=>'0',
            'report_id'=>$this->createReport($id),//Not assigned
            'officer_id'=>0, //Not assigned
            'jurisdiction_id'=>'0'
        );
        $this->db->trans_start();
        $this->db->insert('incidents', $incident_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            //$this->set_error('Unknown error, User creation unsuccessful');
            return FALSE;
        }else{
            return TRUE;
        }
    }
   function createReport($id){
       $report_id=rand();
        $report_data=array(
            'id'=>$report_id,
            'date_created'=>date('Y-m-d H:i:s'),
            'last_edited'=>date('Y-m-d H:i:s'),
            'admin_report'=>'None',
            'officer_report'=>'None',
            'admin_id'=>'0',
            'officer_id'=>0,
            'status'=>1,
            'user_id'=>1,
            'incident_id'=>$id
        );
        $this->db->trans_start();
        $this->db->insert('reports', $report_data);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
              return 0;
        }else{
            return $report_id;
        }
    }
    public function dispatch($incident_id,$officer_id,$admin_comment,$incident_type){
        //Get  officer's phone number,incident location,incident description and time recorded
        $officer=$this->db->select('mobile_phone')
                        ->where('id', $officer_id)
                        ->limit(1)
                        ->get('users');
        $message='IncidentID: '.$incident_id.' IncidentType: '.$incident_type.' Comments: '.$admin_comment;
        //Send message
        $url='http://41.215.137.54/aggregator/?METHOD=HTTP&USERNAME=hilla&PASSWORD=2495ddd79813bdd5871038390342da6f&SOURCE=EDNA&MSISDN='.urlencode($officer->row()->mobile_phone).'&MESSAGE='.urlencode($message);
        $html=file_get_contents($url);
        /*var_dump($html);
        var_dump($url);*/
        if($html===FALSE){
            return FALSE;
        }
        //var_dump($message);
        $this->db->set('status','0')
            ->where('id',$incident_id)
            ->update('incidents');
        //var_dump($url);
        $this->db->set('officer_id',$officer_id)
            ->where('id',$incident_id)
            ->update('incidents');
        return TRUE;

    }
    public function getIncidents(){
        $query="select t1.id,t2.description as incident_type,t1.description,t1.recordtime,t1.status,t3.username as officer_id,t1.phone,t1.upload,t4.id as report_id,t1.x,t1.y,t5.name as jurisdiction 
                from incidents t1 inner join incident_type t2 on t1.incident_type = t2.id
                inner join users t3 on t1.admin_id=t3.id
                INNER JOIN reports t4 on t1.report_id=t4.id
                INNER JOIN jurisdiction t5 on t1.jurisdiction_id=t5.id";
        return $this->db->query($query)->result();
    }
    public function hotspot($type,$from,$to){
        if($type==0){
            $query="select * from incidents t1 WHERE t1.recordtime OVERLAPS ($from::DATE, $to::DATE) ";
            return $this->db->query($query)->result();
        }else{
            $query="select * from incidents t1 WHERE t1.recordtime OVERLAPS ($from::DATE, $to::DATE) AND t1.incident_type=$type";
            return $this->db->query($query)->result();
        }

    }

}