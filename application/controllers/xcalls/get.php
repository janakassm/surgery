<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get extends Guest_Controller {
		
	public function categories()
	{
		$level = $_POST['level'];
		
		if( is_null($level) )
			$level = 0;
		
		$this->db->where('category_level',$level);
		$result = $this->db->get('category');
		
		
		
		
		$this->_print($result->result());
	}
	
	
	
	private function _print($output)
	{
		echo json_encode($output);
	}
	
}
