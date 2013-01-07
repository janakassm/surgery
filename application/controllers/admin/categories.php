<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends Guest_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Category');
	}
	
	public function index()
	{
		$tplData = $this->GetCommonTpls('Site categories');
		
		$this->parser->parse("guest/index.tpl",$tplData);
	}
	
	public function add()
	{
		
		
		if($this->input->post('add_new'))
		{
			/*TODO: validate data*/
			
			if(true)
			{
				$tmp_category = new Category();
				$tmp_category->ParseToObject( $this->input->post() );
				
				//var_dump($tmp_category->GetObjectVars());
				
				$tmp_category->Register();
				
			}
			else
			{
				
			}
			
			
		}
		
		
		$categoryList = Category::GetCategories( NULL, 0);
		
		$css = array('style-admin.css');
		
		$tplData = $this->GetCommonTpls('Add New Cateogry',NULL,NULL,NULL,NULL,$css);
		
		$tplData['categoryList'] = $categoryList;
		
		$this->parser->parse("admin/categories/add.tpl",$tplData);
	}
}
