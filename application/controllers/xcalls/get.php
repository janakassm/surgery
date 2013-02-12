<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get extends Guest_Controller {
		
	public function categories()
	{
		$level = $_POST['level'];
		
		if( is_null($level) )
			$level = 0;
		
		$this->db->where('category_level',$level);
		$result = $this->db->get('category');
		
		
		
		
		jsonEcho($result->result());
	}
	
	public function getCategoriesAsOptions()
	{
		$this->load->library('TemplateHelper');
		
		$level = $this->input->post('level');
		$selId = $this->input->post('selected_id');
		
		if($level !== false)
		{
			$optionsHtml = TemplateHelper::GetCategoryByLevelAsOptions($level,NULL,$selId);
			jsonEcho(array('success'=>true, 'html' => $optionsHtml));
		}
		
		jsonEcho(array('success'=>false));
		
	}
	
}
