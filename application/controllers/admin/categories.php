<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categories extends Guest_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Category');
	}
	
	public function index()
	{
		$this->load->library('TemplateHelper');
		
		if($this->input->post('edit'))
		{
			$catId = intval($this->input->post('cat_id'));
			redirect(base_url('admin/categories/edit?id='.$catId));
		}
		
		
		$css_links = array('style-admin.css');
		$js_links = array('jQuery.validity.min.js');
		
		
		$tplData = $this->GetCommonTpls('Site categories',NULL,NULL,NULL,$js_links,$css_links);
		
		$tplData['mainMenuHtml'] = TemplateHelper::GetCategoryByLevelAsOptions(0);
		$tplData['sideMenuHtml'] = TemplateHelper::GetCategoryByLevelAsOptions(1);
		$tplData['bottomMenuHtml'] = TemplateHelper::GetCategoryByLevelAsOptions(2);
		
		
		$this->parser->parse("admin/categories/index.tpl",$tplData);
	}
	
	public function edit()
	{
		$catId = intval($this->input->get('id'));
		if( is_null($catId) || $catId == 0)
		{
			redirect( base_url('admin/categories/?error=no_id') );
		}
		
		$category = new Category();
		$category->category_id = $catId;
		
		if( !$category->IsCategory() )
		{
			redirect( base_url('admin/categories/?error=no_category') );
		}
		
		$css_links = array('style-admin.css');
		$js_links = array('jQuery.validity.min.js');
		
		
		$tplData = $this->GetCommonTpls('Site categories',NULL,NULL,NULL,$js_links,$css_links);
		
		if($this->input->post('save'))
		{
			$category->ParseToObject( $this->input->post() );
			$this->form_validation->set_rules('category_title_sin', 'Sinhala Title', 'trim|required' );
			if($this->form_validation->run())
			{
				
				$category->ParseToObject( $this->input->post() );
				
				if(!$category->category_parent_id || $category->category_parent_id == 0)
					$category->category_parent_id = NULL; 
				
				if( $category->Save() )
					$tplData['msg'] = wrapSuccess('Category saved');
				else
					$tplData['msg'] = wrapError('Opps something went worng while saving');
				
			}
			else
			{
				$tplData['msg'] = validation_errors('<div class="error">', '</div>');
			}
			
		}
		else if($this->input->post('delete'))
		{
			if( $category->Delete() )
				redirect(base_url('admin/categories'));
			else
				$tplData['msg'] = wrapError('Opps something went worng while deleting');
		}
		
		
		$tplData['category'] = $category;
		
		$this->parser->parse("admin/categories/add-edit.tpl",$tplData);
	}
	
	public function add()
	{
		
		$tmp_category = new Category();
		
		
		$css = array('style-admin.css');
		$tplData = $this->GetCommonTpls('Add New Cateogry',NULL,NULL,NULL,NULL,$css);
		
		if($this->input->post('save'))
		{
			$tmp_category->ParseToObject( $this->input->post() );
			$this->form_validation->set_rules('category_title_sin', 'Sinhala Title', 'trim|required' );
			if($this->form_validation->run())
			{
				
				$tmp_category->ParseToObject( $this->input->post() );
				
				if(!$tmp_category->category_parent_id || $tmp_category->category_parent_id == 0)
					$tmp_category->category_parent_id = NULL; 
				if( $id = $tmp_category->Register() )
					redirect(base_url('admin/categories/edit?id='.$id));
				
			}
			else
			{
				$tplData['msg'] = validation_errors('<div class="error">', '</div>');
			}
			
			
		}
		
		
		$categoryList = Category::GetCategories( NULL, 0);
		
		$tplData['categoryList'] = $categoryList;
		$tplData['category'] = $tmp_category;
		
		$this->parser->parse("admin/categories/add-edit.tpl",$tplData);
	}
}
