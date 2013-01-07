<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class FileUploader 
{
	
	private $CI;
		
	public function __construct()
    {
		$this->CI =& get_instance();		
	}
	
	public function UploadFile($file_input, $upload_path, $allowed_file_types = NULL, $max_size = NULL, $encrypt_name = false)
	{
		if( is_null($max_size) )
			$max_size = 5*1024; //in kB = 5mB
			
		if( is_null($allowed_file_types) )
			$allowed_file_types = 'gif|jpg|jpeg|png|doc|docx|pdf';
		
		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = $allowed_file_types;
		$config['max_size']	= $max_size;
		$config['encrypt_name'] = $encrypt_name;
		
		$this->CI->load->library('upload',$config);
		
		if( $this->CI->upload->do_upload($file_input) )
		{
			$uploadedData = $this->CI->upload->data();
			$uploadedData['file_name'] = $uploadedData['raw_name'].$uploadedData['file_ext'];
			
			return array( 'error' => false, 'data' => $uploadedData );
		}
		else
			return array( 'error' => true, 'data' => $this->CI->upload->display_errors() );
			
	}
}