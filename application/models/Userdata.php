<?php
/**
 * ANCGROUP userModel Class
 *
 * helps to achieve common tasks related to the user like user creation, retreiving data, delete user information, update user information
 * 
 */
 class UserData extends CI_Model {
 
	function __construct()
		{
			parent::__construct();
		}
/**
* Public Member Function declaration 
*
**/
/*=================BEGIN: Common Method =============================*/


//List All data of a specific tables
function listTableData($tablename, $orderbycol, $order, $limit)
{
	$this->db->order_by($orderbycol, $order)->limit($limit);
	  $allData = $this->db->get($this->db->dbprefix($tablename));
	  if($allData->num_rows() > 0)
	  {	
		  $data=array();
		  foreach ($allData->result() as $row) {
				  $data[] = $row;
			  }
		   return $data;			  
	  }
	  return false;	
}
function listTableDataCondition($condition,$tablename)
{
	$data=array();
	if($condition!="") {
		$this->db->where($condition);
	}
   if($tablename == "student_details"){
		if($this->session->userdata('role') == "distributor") {
			$this->db->limit($this->session->userdata('total_allow_students'));
		}
	}
	$allData = $this->db->get($this->db->dbprefix($tablename));
	  if($allData->num_rows() > 0)
	  {	
		  
		  foreach ($allData->result() as $row) {
				  $data[] = $row;
			  }
		   return $data;			  
	  }
	  return $data;	
}
//List All data of a specific tables with one condition
function listTableDataByColumn($column,$colvalue,$tablename)
{
	  if($colvalue!="") $this->db->where($column,$colvalue);
	  $this->db->order_by("id", "asc");
	  $allData = $this->db->get($this->db->dbprefix($tablename));
	  if($allData->num_rows() > 0)
	  {	
		  $data=array();
		  foreach ($allData->result() as $row) {
				  $data[] = $row;
			  }
		   return $data;			  
	  }
	  return false;	
}
//List only specific record of id parameter
function listSpecificRowById($id,$tablename)
{
	$this->db->where('id',$id);
	$this->db->order_by("id", "desc");
	$specificData = $this->db->get($this->db->dbprefix($tablename));	
	if($specificData->num_rows() > 0)
	{	
		return $specificData->row();
		
	}
	return false;
}

//List only specific record of column name parameter
function listSpecificRowByColumn($column,$colvalue,$tablename)
{
	$this->db->where($column,$colvalue);
	$specificData = $this->db->get($this->db->dbprefix($tablename));	
	if($specificData->num_rows() > 0)
	{	
		return $specificData->row();
		
	}
	return false;
}
//Update Specific Row
function updateSpecificRowById($tablename,$updateData,$id)
   {
	  $this->db->update($this->db->dbprefix($tablename), $updateData, array('id' => $id));
	  return 1;
   }


//Delete Specific Row
function deleteSpecificRowById($tablename,$id)
   {
	  $this->db->delete($this->db->dbprefix($tablename), array('id' => $id));
	  return 1;
   }
public function uniqueCheck($columnname,$columnvalue,$id,$tablename)
	{		
		$this->db->where($columnname,$this->db->escape_str($columnvalue));
		$this->db->where('id!=',$id);
		$query = $this->db->get($this->db->dbprefix($tablename));
		if ($query->num_rows() > 0)
		return true;
		else
		return false;		
	}
public function countRecords($tablename, $wherecondition) {
	return $this->db->where($wherecondition)->from($this->db->dbprefix($tablename))->count_all_results();
}
/*=================END: Common Method =============================*/


/*================BEGIN: User  =========================*/
function loginAccess($user_login_data) {
	  $this->db->where('username',$this->db->escape_str($user_login_data['username']));
		$this->db->where('password',md5($this->db->escape_str($user_login_data['password'])));
		$this->db->where('active','Y');
		$query = $this->db->get($this->db->dbprefix('users'));
		if ($query->num_rows() > 0)
		{
			$row=$query->row(); 
			$usernm=$row->username;
			$useremail=$row->email;
		    $usrid=$row->id;		
			$role=$row->role;	
			$user_photo=$row->user_photo_thumbnail;	
			$total_allow_students = $row->total_allow_students;
			
			$login_time=date("d-m-Y H:i:s");
			$this->db->update($this->db->dbprefix('users'), array('lastlogin' => $login_time), array('id' => $usrid));
			
			$user_tracking_data=array();
			$user_tracking_data['uid']=$usrid;
			$user_tracking_data['email']=$useremail;
			$user_tracking_data['username']=$usernm;
			$user_tracking_data['ip_address']=$this->input->ip_address();
			$user_tracking_data['login_time']=$login_time;
			$this->db->insert($this->db->dbprefix('login_details'), $user_tracking_data);
			
			// Store session data
			$this->session->set_userdata('username', $usernm);
			$this->session->set_userdata('usrid', $usrid); 
			$this->session->set_userdata('role', $role);	
			$this->session->set_userdata('total_allow_students', $total_allow_students);
			if($user_photo) {
				$this->session->set_userdata('profile_photo', SITE_URL."media/upload/user/".$usrid."/".$user_photo);	
			} else {
				$this->session->set_userdata('profile_photo', SITE_URL."media/img/user.jpg");	
			}					
			return 1;			
		}
		else
		{
			return 0;
		}		
    }
	function getRemainingBatch($id)
	{
		$this->db->select('remaining_batch');
		$this->db->where('id', $id);
		$query = $this->db->get($this->db->dbprefix('users'));
		return $query->result();
	}
	public function delete_user_by_id($user_id) {
		$this->db->where('id', $user_id);
		return $this->db->delete($this->db->dbprefix('users'));
	}
	
/*================END: User  =========================*/

/*==================== BEGIN: Student Listing ==========================*/

    public function fetch_student_data($limit, $start, $search, $order, $dir, $batch = null) {
        $this->db->limit($limit, $start);
		if($this->session->userdata('role') =="operator") {
			$this->db->where('added_by_userid', $this->session->userdata('usrid'));
		} else if($this->session->userdata('role') =="distributor") {
			$this->db->where('added_for_userid', $this->session->userdata('usrid'));
		}
		
		if ($batch) {
			$this->db->where('Batch_Name', $batch);
		}
        if ($search) {
            $this->db->like('Student_Name', $search);
			$this->db->or_like('Batch_Name', $search);
        }
		$this->db->where('active="Y"');
		
        $this->db->order_by($order, $dir);
		
        $query = $this->db->get($this->db->dbprefix('student_details'));
        return $query->result();
    }

    public function count_filtered($search, $batch = null) {
		if($this->session->userdata('role') =="operator") {
			$this->db->where('added_by_userid', $this->session->userdata('usrid'));
		} else if($this->session->userdata('role') =="distributor") {
			$this->db->where('added_for_userid', $this->session->userdata('usrid'));
		}
		if ($batch) {
			$this->db->where('Batch_Name', $batch);
		}
        if ($search) {
            $this->db->like('Student_Name', $search);
			$this->db->or_like('Batch_Name', $search);
        }
		$this->db->where('active="Y"');
		
		if($this->session->userdata('role') == "distributor") {
			$this->db->limit($this->session->userdata('total_allow_students'));
		}
		
        $query = $this->db->get($this->db->dbprefix('student_details'));
        return $query->num_rows();
    }

    public function count_all() {
		if($this->session->userdata('role') =="operator") {
			$this->db->where('added_by_userid', $this->session->userdata('usrid'));
		} else if($this->session->userdata('role') =="distributor") {
			$this->db->where('added_for_userid', $this->session->userdata('usrid'));
		}
		$this->db->where('active="Y"');
        $query = $this->db->get($this->db->dbprefix('student_details'));		
		if($this->session->userdata('role') == "distributor") {
			$this->db->limit($this->session->userdata('total_allow_students'));
		}
        return $query->num_rows();
    }

	public function isAllowStudentsEnd($userId) {
		$this->db->where('id',$userId);
		$batch = $this->db->get($this->db->dbprefix('users'));
		$row=$batch->row();	
		$total_allow = $row->total_allow_students;
		$this->db->where('added_for_userid',$userId);
		$students = $this->db->get($this->db->dbprefix('student_details'));	
		//return "Student allow===".$total_allow."  number of student====". $students->num_rows()."===";
		if($students->num_rows() > $total_allow) { return true; } else { return false; }
	}

	public function getBatchLimitation($userId) {
		$this->db->where('id',$userId);
		$user = $this->db->get($this->db->dbprefix('users'));
		$row=$user->row(); 
		return $row->total_allow_students;
	}
	public function getDistributorId($role, $userId) {
		$this->db->where('id',$userId);
		$user = $this->db->get($this->db->dbprefix('users'));
		$row=$user->row(); 
		if($role == "operator") { return $row->distributor_id; }
		else if($role == "distributor") { return $row->id; }
	}
	public function getBatchUserId($batchId) {
		$this->db->where('id',$batchId);
		$batch = $this->db->get($this->db->dbprefix('batches'));
		$row=$batch->row(); 
		return $row->userid;
	}
	public function getBatchName($batchId) {
		$this->db->where('id',$batchId);
		$batch = $this->db->get($this->db->dbprefix('batches'));
		$row=$batch->row(); 
		return $row->batch_name;
	}
	public function getAllowSudentLimit($userId) {
		$this->db->where('id',$userId);
		$user = $this->db->get($this->db->dbprefix('users'));
		$row=$user->row(); 
		return $row->total_allow_students;
	}
	
	public function distributorsDetails() {
		$data=array();
		
		$this->db->where("role='distributor' AND active='Y'");
		$allData = $this->db->get($this->db->dbprefix("users"));
		if($allData->num_rows() > 0)
		{	
			
			foreach ($allData->result() as $row) {
					$data[] = $row;
				}
			return $data;			  
		}
		return $data;	
	}


/*================== END: Student Listing ============================*/
/*=================== BEGIN: Batches =================================*/
public function get_batches() {
    $this->db->select('id, batch_name');
    $query = $this->db->get($this->db->dbprefix('batches'));
    return $query->result();
}


/*================= END: Batches ====================================*/

}
// End UserData Class
   
/* End of file userdata.php */ 
/* Location: ./app/models/userdata.php */
?>