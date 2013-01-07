<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Pharmacist extends GeneralClass {
	
	public		
		$pharmacist_id, 
		$first_name,
		$last_name,
		$dob,
		$street_1,
		$street_2,
		$suburb,
		$state,
		$postcode,		
		$email,
		$ahpra_number,		
		$phone_no,
		$region_for_referral,		
		$aacp = NULL;
	
		
	public function __construct()
    {
        parent::__construct();
		$this->CI =& get_instance();		
	}
	
	/* Pharmacist Specific Functions */
	public function IsPharmacist($isActivated=false)
	{
		$this->CI->db->where('id',$this->id);
		
		$query = $this->CI->db->get('ez_users');
		if($query->num_rows() > 0)
		{
			
			if($isActivated && !$this->isActivated())
			{
				return false;
			}
			return true;
		}
		else
			return false;
	}
	
	public function IsActivated()
	{
		if($query->num_rows() > 0)
			return true;
		else
			return false;
	}
	
	public function GetPharmacistImage()
	{
		
		if(!is_null($this->image))
			$imageurl = $this->CI->config->base_url().'userdata/'.$this->id.'/'.$this->image;
		else
			$imageurl = $this->CI->config->base_url().'images/default/profile/noimage.jpg';
		
		return $imageurl;
	}
	
	public function GetAACP()
	{
		return $this->aacp;
	}
	
	public function UploadTmpAACP($fileInput,$session_id)
	{
		$filePath = './temp_upload_data/'.$session_id.'/aacp/';
		$allowed_file_types = 'gif|jpg|jpeg|png|doc|docx|pdf';
		$max_size = 5 * 1024;
		
		if( !is_dir($filePath) )
			mkdir($filePath,0775,true);
			
		$this->CI->load->library('FileUploader','','fileUploader');
		
		$uploadedData = $this->CI->fileUploader->UploadFile($fileInput, $filePath, $allowed_file_types, $max_size, true);
		
		
		
		$absPath = abs_path();				
		$uploaded_url = base_url().str_replace($absPath,"",$uploadedData['data']['full_path']);
		$uploaded_file_name = 	$uploadedData['data']['orig_name'] ;
		
		if( !$uploadedData['error'] )
		{
			$this->aacp = array('uploaded_url' => $uploaded_url, 'uploaded_file_name' => $uploaded_file_name, 'uploaded_file_path' => $uploadedData['data']['full_path']);
		}
		
		return $uploadedData;
	}
	
	public function DeleteAACP()
	{
		if( isset($this->aacp['uploaded_file_path']) && file_exists($this->aacp['uploaded_file_path']) )
		{
			if(unlink($this->aacp['uploaded_file_path']))
			{
				
				//chk whether already saved in db
				if(is_null($this->pharmacist_id))
					$this->aacp = NULL;
				else
				{
					
				}
			}
		}
		
	}
	
	
	/* General functions */
	
	public function Refresh()
	{
		$this->CI->db->where('id',$this->id);
		$query = $this->CI->db->get('ez_users');
		$this->parseToObject($query->row_array());
	}
	
	public function GetState()
	{
		return preg_replace('/([a-z])([A-Z])/', '$1 $2', $this->state);
	}
		
	
	
	/* Admin Related Functions */
	
	public function Register()
	{
		
	}
	
	public function Update()
	{
		if($this->isUser(true))
		{
			$this->CI->db->where('id', $this->id);
			$this->CI->db->update('ez_users', $this->getObjectVars($this)); 
		}
	}
	
	public function Delete()
	{
		if($this->isUser(false))
		{
			$this->CI->db->trans_start();
			
			$this->CI->db->where('user_id',$this->id);
			$tmpProductsQry = $this->CI->db->get('products');
			
			foreach($tmpProductsQry->result('Product') as  $tmpProduct)
			{
				$tmpProduct->delete();
			}
			
			$this->CI->db->where('user_id',$this->id);
			$this->CI->db->delete('ez_auth');
			
			$this->CI->db->where('user_id',$this->id);
			$this->CI->db->delete('ez_access_keys');
			
			$this->CI->db->where('id',$this->id);
			$this->CI->db->delete('ez_users');
						
			$this->CI->db->trans_complete();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function Suspend()
	{
		if($this->isUser(false))
		{
			$this->CI->db->trans_start();
			
			$this->CI->db->where('id',$this->id);
			$this->CI->db->update('ez_users',array('suspended'=>true));
			
			
			$this->CI->db->trans_complete();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function Resume()
	{
		if($this->isUser(false))
		{
			$this->CI->db->trans_start();
			
			$this->CI->db->where('id',$this->id);
			$this->CI->db->update('ez_users',array('suspended'=>false));
			
			
			$this->CI->db->trans_complete();
			
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	
	
	
	
}