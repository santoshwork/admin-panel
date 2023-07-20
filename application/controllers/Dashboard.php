<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	  {        
        parent::__construct();
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->helper('date');	
		$this->load->model('userdata');	
		
     }
	 
	public function index()
	{
		
		$this->data['role'] = $this->session->userdata('role');
		$this->data['recent_logins'] = $this->userdata->listTableData('login_details','id','DESC',10);
		$distributor_id = $this->userdata->getDistributorId($this->session->userdata('role'), $this->session->userdata('usrid'));
		$distributor_condition = ('userid ='.$distributor_id);

		if ($this->session->userdata('role') !='admin') {
			$this->data['total_batches'] = $this->userdata->countRecords('batches',"active= 'Y' AND username ='".$this->session->userdata('username')."'");
		} else {
			$this->data['total_batches'] = $this->userdata->countRecords('batches',"active= 'Y'");
		}
		if ($this->session->userdata('role') !='admin') {
			$this->data['total_users'] = $this->userdata->countRecords('users',"active= 'Y' AND added_by ='".$this->session->userdata('username')."'");
		} else {
			$this->data['total_users'] = $this->userdata->countRecords('users',"active= 'Y'");
		}
		if ($this->session->userdata('role') !='admin') {
			$this->data['total_images'] = $this->userdata->countRecords('student_details',"active= 'Y' AND added_by_userid =".$this->session->userdata('usrid'));
		} else {
			$this->data['total_images'] = $this->userdata->countRecords('student_details',"active= 'Y'");
		}
		if ($this->session->userdata('role') =='distributor') {
			$this->data['total_pending_batches'] = $this->userdata->countRecords('batches',"active= 'Y' AND userid =".$this->session->userdata('usrid')." AND id NOT IN(Select Batch_Id From apanel_student_details Where active ='Y')");
		} 

		if ($this->session->userdata('role') !='admin') {
			$this->data['total_students'] = $this->userdata->countRecords('student_details',"active= 'Y' AND added_for_userid =".$distributor_id);
		} else {
			$this->data['total_students'] = $this->userdata->countRecords('student_details',"active= 'Y' OR active= 'N'");
		}
		$this->data['distributors_details'] = $this->userdata->distributorsDetails();
		
		$this->data['page'] = 'dashboard';		
        $this->load->view('layout/template_dashboard', $this->data);
	}
/*==================================== BEGIN: Users ======================================================================*/ 
	public function users()
	{
		
		$this->data['role'] = $this->session->userdata('role');
		$this->data['users'] = $this->userdata->listTableData('users','id','DESC',0);
		if($this->session->userdata('role')=='operator' || $this->session->userdata('role')=='distributor') {
			$this->data['page'] = 'dashboard';
		} else {
			$this->data['page'] = 'user_list';
		}
				
        $this->load->view('layout/template_dashboard', $this->data);
	}
	public function user_new()
	{
		
		$this->data['role'] = $this->session->userdata('role');
		$this->data['students'] = $this->userdata->listTableData('student_details','id','DESC',0);		
		$this->data['distributors'] = $this->userdata->listTableDataCondition('role="distributor"','users');		
		if($this->session->userdata('role')=='operator' || $this->session->userdata('role')=='distributor') {
			$this->data['page'] = 'dashboard';
		} else {
			$this->data['page'] = 'user_new';
		}
				
        $this->load->view('layout/template_dashboard', $this->data);
	}

	//Submit User Details
	public function submit_user_data()
	{
		$responseCode="";
		
		if($this->input->post('submit'))
		{			 	  
		  $this->form_validation->set_rules('username', 'User Name', 'required|is_unique[apanel_users.username]');	
		  $this->form_validation->set_rules('password', 'Password', 'required');
		  $this->form_validation->set_rules('first_name', 'First Name', 'required');
		  $this->form_validation->set_rules('last_name', 'Last Name', 'required');
		  $this->form_validation->set_rules('user_email', 'email', 'required');
		 if ($this->form_validation->run() == FALSE)
		  {
			$responseCode="201";
		  }
		  else
		  {			
				$insertData=array();
				$insertData["first_name"]=$this->input->post('first_name',TRUE);				
				$insertData["last_name"]=$this->input->post('last_name',TRUE);
				$insertData["username"]=$this->input->post('username',TRUE);
				$insertData["email"]=$this->input->post('user_email',TRUE);
				$insertData["password"]=md5($this->input->post('password',TRUE));
				$insertData["password_human"]=$this->input->post('password',TRUE);
				$insertData["role"]=$this->input->post('role',TRUE);
				$insertData["mobile"]=$this->input->post('mobile',TRUE);
				if($this->input->post('role',TRUE) == "distributor") {
					$insertData["total_allow_students"]=$this->input->post('total_allow_students',TRUE);
				}
				if($this->input->post('role',TRUE) == "admin") {
					$insertData["editoption"]=$this->input->post('editoption',TRUE);
					$insertData["deleteoption"]=$this->input->post('deleteoption',TRUE);
				}
				$insertData["active"]=$this->input->post('active',TRUE);
				$insertData["added_by"]=$this->input->post('added_by',TRUE);
				if($this->input->post('role',TRUE) == "operator") {
					$insertData["distributor_id"]=$this->input->post('distributor',TRUE);
				}
				$insertData["created_date"]=date("d-m-Y H:i:s");
				$insertData["lastlogin"]=date("d-m-Y H:i:s");
				$insertData["user_photo"]="";
				$insertData["user_photo_thumbnail"]="";				
				$this->db->insert($this->db->dbprefix('users'), $insertData);
				$id=$this->db->insert_id();	
				if($id)
				{
					$responseCode=200;
					$user_img='';
					$updateimagedata=array();
				if($_FILES['user_photo']['name'])
				{
				if (!is_dir('./media/upload/user/'.$id))
					{
						mkdir('./media/upload/user/'.$id, 0777);
					}
					$config = array();
					$config['upload_path'] = './media/upload/user/'.$id;
					$config['file_name'] = time().rand(1,988);
					$config['allowed_types'] = 'jpg|png|JPG|PNG|jpeg|JPEG';				
					$config['max_size'] = '2000';
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['max_filename'] = '500';
					$config['overwrite']     = FALSE;
					$this->load->library('upload',$config);
					if (!$this->upload->do_upload("user_photo"))
					{
						$responseCode = $this->upload->display_errors();
					}
					else
					{
						$user_img=$this->upload->data();
						$updateimagedata['user_photo']=$user_img['file_name'];
						$this->userdata->updateSpecificRowById('users',$updateimagedata,$id);
						$config4['image_library'] = 'gd2';
						$config4['source_image'] = './media/upload/user/'.$id.'/'.$user_img['file_name'];
						$config4['create_thumb'] = TRUE;
						$config4['maintain_ratio'] = FALSE;
						$config4['width']	= 174;
						$config4['height']	= 148;
						$this->load->library('image_lib', $config4); 
						$this->image_lib->resize();
						$thumbimg=$user_img['raw_name'] . '_thumb' . $user_img['file_ext'];  
						$updateimagephoto=array();         
						$updateimagephoto['user_photo_thumbnail']=$thumbimg;
						$this->userdata->updateSpecificRowById('users',$updateimagephoto,$id);
						$responseCode=200;
					}
				}
				}
			}	
			
		  }		 
		echo $responseCode;
	 	
	}

	public function get_user_data($userId) {
		$user = $this->userdata->listSpecificRowById($userId,'users');
	
		if ($user) {
			echo json_encode($user);
		} else {
			show_404();
		}
	}

	public function edit_user_data()
	{
		$responseCode="";
		
		if($this->input->post('submit'))
		{			 	  
		  
		  $this->form_validation->set_rules('password', 'Password', 'required');
		  $this->form_validation->set_rules('first_name', 'First Name', 'required');
		  $this->form_validation->set_rules('last_name', 'Last Name', 'required');
		  $this->form_validation->set_rules('user_email', 'email', 'required');
		 if ($this->form_validation->run() == FALSE)
		  {
			$responseCode="201";
		  }
		  else
		  {			
				$id = $this->input->post('edit_user_id',TRUE);
				$updateData=array();
				$updateData["first_name"]=$this->input->post('first_name',TRUE);				
				$updateData["last_name"]=$this->input->post('last_name',TRUE);
				$updateData["email"]=$this->input->post('user_email',TRUE);
				$updateData["password"]=md5($this->input->post('password',TRUE));
				$updateData["password_human"]=$this->input->post('password',TRUE);
				$updateData["mobile"]=$this->input->post('mobile',TRUE);
				$updateData["total_allow_students"]=$this->input->post('total_allow_students',TRUE);
				$updateData["active"]=$this->input->post('active',TRUE);
				$this->userdata->updateSpecificRowById('users',$updateData, $id);
				$responseCode=200;
				$user_img='';
				$updateimagedata=array();
				if($_FILES['user_photo']['name'])
				{
				if (!is_dir('./media/upload/user/'.$id))
					{
						mkdir('./media/upload/user/'.$id, 0777);
					}
					$config = array();
					$config['upload_path'] = './media/upload/user/'.$id;
					$config['file_name'] = time().rand(1,988);
					$config['allowed_types'] = 'jpg|png|JPG|PNG|jpeg|JPEG';				
					$config['max_size'] = '2000';
					$config['max_width'] = '';
					$config['max_height'] = '';
					$config['max_filename'] = '500';
					$config['overwrite']     = FALSE;
					$this->load->library('upload',$config);
					if (!$this->upload->do_upload("user_photo"))
					{
						$responseCode = $this->upload->display_errors();
					}
					else
					{
						$user_img=$this->upload->data();
						$updateimagedata['user_photo']=$user_img['file_name'];
						$this->userdata->updateSpecificRowById('users',$updateimagedata,$id);
						$config4['image_library'] = 'gd2';
						$config4['source_image'] = './media/upload/user/'.$id.'/'.$user_img['file_name'];
						$config4['create_thumb'] = TRUE;
						$config4['maintain_ratio'] = FALSE;
						$config4['width']	= 174;
						$config4['height']	= 148;
						$this->load->library('image_lib', $config4); 
						$this->image_lib->resize();
						$thumbimg=$user_img['raw_name'] . '_thumb' . $user_img['file_ext'];  
						$updateimagephoto=array();         
						$updateimagephoto['user_photo_thumbnail']=$thumbimg;
						$this->userdata->updateSpecificRowById('users',$updateimagephoto,$id);
						$responseCode=200;
					}
				}
			}	
			
		  }		 
		echo $responseCode;
	 	
	}
	public function delete_user() {
		$user_id = $this->input->post('user_id');
		$result = $this->userdata->delete_user_by_id($user_id);
	
		if ($result) {
			echo json_encode(array("status" => "success"));
		} else {
			echo json_encode(array("status" => "error"));
		}
	}
	
/*================================= END: Users ===========================================================================*/


/*==================================== BEGIN: Students ======================================================================*/ 


	public function students()
	{
		
		$this->data['role'] = $this->session->userdata('role');
		$condition= "";
		$distributor_id = $this->userdata->getDistributorId($this->session->userdata('role'), $this->session->userdata('usrid'));
		$distributor_condition = ('userid ='.$distributor_id);
		if($this->session->userdata('role') =="operator") {
			$condition = ('active = "Y" AND added_by_userid ='.$this->session->userdata('usrid'));
		} else if($this->session->userdata('role') =="distributor") {
			$condition = ('active = "Y" AND added_for_userid ='.$this->session->userdata('usrid'));
		}
		$this->data['students'] = $this->userdata->listTableDataCondition($condition,'student_details');
		if($this->session->userdata('role') =="admin") {
			$this->data['batches'] = $this->userdata->listTableData('batches','id','DESC',0);
		} else {
			$this->data['batches'] = $this->userdata->listTableDataCondition($distributor_condition, 'batches');
		}
		if($this->session->userdata('role')=='operator') {
			$this->data['page'] = 'dashboard';
		} else {
			$this->data['page'] = 'student_list';
		}	
		if($this->session->userdata('role') !="admin") {
    		if($this->userdata->getAllowSudentLimit($distributor_id) == 0) {
    			$this->data['page'] = 'permission_denied';
    		} 
		}
        $this->load->view('layout/template_dashboard', $this->data);
	}

	public function update_student_data() {
		$updateData = array();
		$studentId = $this->input->post('id');
		$updateData["Batch_Id"]=explode("##",$this->input->post('batch_no',TRUE))[0];
		$updateData["Batch_Name"]=explode("##",$this->input->post('batch_no',TRUE))[1];
		$updateData["added_for_userid"]=explode("##",$this->input->post('batch_no',TRUE))[2];

	
		// Update the student details in the database
		$this->userdata->updateSpecificRowById('student_details',$updateData, $studentId);
	
		// Return a JSON response
		echo json_encode(array('status' => 'success'));
	}

	public function fetch_students_data() {
        $length = $this->input->get('length');
        $start = $this->input->get('start');
        $search = $this->input->get('search')['value'];
        $order = $this->input->get('order')[0]['column'];
        $dir = $this->input->get('order')[0]['dir'];
		$batch = $this->input->get('batch');
        $order_column = array('Id','Student_Name', 'Batch_Name')[$order];

        $data = $this->userdata->fetch_student_data($length, $start, $search, $order_column, $dir, $batch);
        $recordsTotal = $this->userdata->count_all();
        $recordsFiltered = $this->userdata->count_filtered($search, $batch);

        $output = array(
            "draw" => intval($this->input->get('draw')),
            "recordsTotal" => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data
        );

        echo json_encode($output);
    }
	
	public function student_new()
	{
		
		$this->data['role'] = $this->session->userdata('role');
		$this->data['students'] = $this->userdata->listTableData('student_details','id','DESC',0);
		$distributor_id = $this->userdata->getDistributorId($this->session->userdata('role'), $this->session->userdata('usrid'));
		$distributor_condition = ('userid ='.$distributor_id);		
		if($this->session->userdata('role') =="admin") {
			$this->data['batches'] = $this->userdata->listTableData('batches','id','DESC',0);
		} else {
			$this->data['batches'] = $this->userdata->listTableDataCondition($distributor_condition, 'batches');
		}
		$total_students_entry = $this->userdata->countRecords('student_details',"active= 'Y' AND added_for_userid =".$distributor_id);
		$entry_limitation = $this->userdata->getAllowSudentLimit($distributor_id);
		if($this->session->userdata('role') !="admin") {
    		if($this->userdata->getAllowSudentLimit($distributor_id) == 0) {
    			$this->data['page'] = 'permission_denied';
    		}  elseif($total_students_entry >= $this->userdata->getAllowSudentLimit($distributor_id))  {
				$this->data['entry_limitation'] = $entry_limitation;
				$this->data['page'] = 'entry_exceed';
			} else {
				$this->data['page'] = 'student_new';
			}
		} else {
			$this->data['page'] = 'student_new';
		}
				
        $this->load->view('layout/template_dashboard', $this->data);
	}
	public function get_student_data($studentId) {
		$student = $this->userdata->listSpecificRowById($studentId,'student_details');
	
		if ($student) {
			echo json_encode($student);
		} else {
			show_404();
		}
	}

	//Submit Student Details
	public function submit_student_data()
	{
		$responseCode="";
		//print_r($this->input->post());
		if($this->input->post('submit'))
		{			 	  
		  $this->form_validation->set_rules('student_name', 'Student Name', 'required');	
		  $this->form_validation->set_rules('mobile_no', 'Mobile No', 'required');	
		  $this->form_validation->set_rules('batch_no', 'Batch No', 'required');	
		  $this->form_validation->set_rules('address', 'Address', 'required');	
		  $this->form_validation->set_rules('finger1Value', 'Finger1', 'required');	
		  $this->form_validation->set_rules('finger2Value', 'Finger2', 'required');		
		  $this->form_validation->set_rules('finger3Value', 'Finger3', 'required');	
		  $this->form_validation->set_rules('finger4Value', 'Finger4', 'required');	
		  $this->form_validation->set_rules('finger5Value', 'Finger5', 'required');		
		  
		 if ($this->form_validation->run() == FALSE)
		  {
			$responseCode="201";
		  }		 
		  else
		  {			
				$batchId = $this->input->post('batch_no',TRUE);
				$batchName = $this->userdata->getBatchName($batchId);
				$batchUser = $this->userdata->getBatchUserId($batchId);

				$insertData=array();
				$insertData["Student_Name"]=$this->input->post('student_name',TRUE);				
				$insertData["Mobile_No"]=$this->input->post('mobile_no',TRUE);
				$insertData["Batch_Id"]=$batchId;
				$insertData["Batch_Name"]=$batchName;
				$insertData["added_for_userid"]=$batchUser;
				$insertData["Address"]=$this->input->post('address',TRUE);				
				$insertData["IP"]=$this->input->ip_address();
				$insertData["Date"]=date("d-m-Y H:i:s");
				$insertData["added_by_userid"]=$this->session->userdata('usrid');
				$insertData["active"]='Y';				
				if($this->userdata->isAllowStudentsEnd($batchUser)) {
					$responseCode="205";
				} else {
					$this->db->insert($this->db->dbprefix('student_details'), $insertData);
					$id=$this->db->insert_id();	
					if($id)
					{
						
						$finger1 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$this->input->post('finger1Value',FALSE)));
						$finger2 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$this->input->post('finger2Value',FALSE)));
						$finger3 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$this->input->post('finger3Value',FALSE)));
						$finger4 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$this->input->post('finger4Value',FALSE)));
						$finger5 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '',$this->input->post('finger5Value',FALSE)));
						
						if (!is_dir('./media/upload/student/'.$id))
						{
							mkdir('./media/upload/student/'.$id, 0777);
						}
						
						$finger1_image_name='finger1_'.time().rand(1,988).'.bmp';
						$finger1_path = './media/upload/student/'.$id.'/'.$finger1_image_name;
						file_put_contents($finger1_path, $finger1);

						$finger2_image_name='finger2_'.time().rand(1,988).'.bmp';
						$finger2_path = './media/upload/student/'.$id.'/'.$finger2_image_name;
						file_put_contents($finger2_path, $finger2);

						$finger3_image_name='finger3_'.time().rand(1,988).'.bmp';
						$finger3_path = './media/upload/student/'.$id.'/'.$finger3_image_name;
						file_put_contents($finger3_path, $finger3);

						$finger4_image_name='finger4_'.time().rand(1,988).'.bmp';
						$finger4_path = './media/upload/student/'.$id.'/'.$finger4_image_name;
						file_put_contents($finger4_path, $finger4);

						$finger5_image_name='finger5_'.time().rand(1,988).'.bmp';
						$finger5_path = './media/upload/student/'.$id.'/'.$finger5_image_name;
						file_put_contents($finger5_path, $finger5);

						$updatefinger=array();         
						$updatefinger['finger1']=SITE_URL.'media/upload/student/'.$id.'/'.$finger1_image_name;
						$updatefinger['finger2']=SITE_URL.'media/upload/student/'.$id.'/'.$finger2_image_name;
						$updatefinger['finger3']=SITE_URL.'media/upload/student/'.$id.'/'.$finger3_image_name;
						$updatefinger['finger4']=SITE_URL.'media/upload/student/'.$id.'/'.$finger4_image_name;
						$updatefinger['finger5']=SITE_URL.'media/upload/student/'.$id.'/'.$finger5_image_name;
						$this->userdata->updateSpecificRowById('student_details',$updatefinger,$id);
						$responseCode=200;				
					}
				}
				
			}	
		}
		echo $responseCode;
	}


/*================================= END: Students ===========================================================================*/

/*================================= BEGIN: Batches ===========================================================================*/

	
	public function batches()
	{
		
		$this->data['role'] = $this->session->userdata('role');
		
		$distributor_id = $this->userdata->getDistributorId($this->session->userdata('role'), $this->session->userdata('usrid'));
		$distributor_condition = ('userid ='.$distributor_id);		
		if($this->session->userdata('role') =="admin") {
			$this->data['batches'] = $this->userdata->listTableData('batches','id','DESC',0);
		} else {
			$this->data['batches'] = $this->userdata->listTableDataCondition($distributor_condition, 'batches');
		}
		if($this->session->userdata('role')=='operator') {
			$this->data['page'] = 'dashboard';
		} else {
			$this->data['page'] = 'batch_list';
		}
		if($this->session->userdata('role') !="admin") {
		if($this->userdata->getAllowSudentLimit($distributor_id) == 0) {
			$this->data['page'] = 'permission_denied';
		}
		}

        $this->load->view('layout/template_dashboard', $this->data);
	}
	public function batch_new()
	{
		$condition="role ='distributor'";
		$distributor_id = $this->userdata->getDistributorId($this->session->userdata('role'), $this->session->userdata('usrid'));
		$this->data['role'] = $this->session->userdata('role');
		$this->data['users'] = $this->userdata->listTableDataCondition($condition,'users');
		if($this->session->userdata('role')=='operator') {
			$this->data['page'] = 'dashboard';
		} else {
			$this->data['page'] = 'batch_new';
		}
		if($this->session->userdata('role') !="admin") {
    		if($this->userdata->getAllowSudentLimit($distributor_id) == 0) {
    			$this->data['page'] = 'permission_denied';
    		} 
		}
        $this->load->view('layout/template_dashboard', $this->data);
	}

	
	
	public function submit_batch_data()
	{
		$responseCode="";
		//print_r($this->input->post());
		if($this->input->post('submit'))
		{			 	  
		  $this->form_validation->set_rules('batch_name', 'Batch Name', 'required|is_unique[apanel_batches.batch_name]');
		  if($this->session->userdata('role') =="admin") {
		  		$this->form_validation->set_rules('user', 'User', 'required');	
		  }
		  
		 if ($this->form_validation->run() == FALSE)
		  {
			$responseCode="201";
		  }		 
		  else
		  {			
				$users = ($this->session->userdata('role') =="admin")? ($this->input->post('user',TRUE)):($this->session->userdata('usrid')."##".$this->session->userdata('username'));
				$user = explode("##", $users);
				$insertData=array();
				$insertData["userid"]=$user[0];				
				$insertData["username"]=$user[1];
				$insertData["batch_name"]=$this->input->post('batch_name',TRUE);
				$insertData["created_by"]=$this->session->userdata('username');
				$insertData["creation_ip"]=$this->input->ip_address();
				$insertData["creation_date"]=date("d-m-Y H:i:s");
				$insertData["active"]='Y';
				$this->db->insert($this->db->dbprefix('batches'), $insertData);
				$responseCode="200";				
			}	
		}
		echo $responseCode;
	}
/*================================= END: Batches ===========================================================================*/


}
