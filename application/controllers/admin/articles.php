<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Articles extends Guest_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Article');
		$this->load->library('Topic');
		$this->load->library('Category');
	}
	
	public function index()
	{
		$tplData = $this->GetCommonTpls('Manage articles');
		
		$this->session->unset_userdata('admin_current_article_id');
		
		$css = array('style-admin.css');
		$js_links = array('jquery.autosize.js','jquery.fineuploader-3.0.min.js');
		
		$tplData = $this->GetCommonTpls('Add New Cateogry',NULL,NULL,NULL,NULL,$css);
		
		$tplData['articleList'] = Article::GetArticles();
		
		
		$this->parser->parse("admin/articles/index.tpl",$tplData);
	}
	
	public function add()
	{
		//Clear session data if new article selected
		if($this->input->get('new'))
		{
			$this->session->unset_userdata('admin_current_article_id');
			redirect( base_url('admin/articles/add') );
		}
			
		$article = new Article();
		
		//this will be null or article id (if available)
		$article->article_id = intval($this->session->userdata('admin_current_article_id'));
		
		//load from sessions (if available)
		if( !$article->IsArticle() )
		{
			$article->PreRegister();
		}
		
		//set sessions to avoid redundent items on refresh
		$this->session->set_userdata('admin_current_article_id', $article->article_id);
		
		//_var_dump($article->GetObjectVars());		
		
		
		$css_links = array('style-admin.css');
		$js_links = array('tiny_mce/tiny_mce.js','jQuery.validity.min.js','jquery.autosize.js','jquery.fineuploader-3.0.min.js');
		
		$categoryList = Category::GetCategories( NULL, 0);
		$advertisementList = Advertisement::GetAdvertisements();

		$tplData = $this->GetCommonTpls('Add Article',NULL,NULL,NULL,$js_links,$css_links);
		
		
		if($this->input->post('save'))
		{
			//populate temp post data
			$article->ParseToObject( $this->input->post() );
			
			
			$this->form_validation->set_rules('article_title', 'Article Title', 'trim|required' );
			$this->form_validation->set_rules('article_category', 'Category', 'trim|required' );

			//die();
			
			/*$session = $this->session->userdata('tmpUploads360');
			$imageList = $session['files'];
			$article->SetImageList360($imageList);
					
			$session = $this->session->userdata('tmpUploads');
			$imageList = $session['files'];
			$article->SetImageList($imageList);*/
					
			if ( $this->form_validation->run() )
			{
				$article->ParseToObject( $this->input->post() );
				$article->article_is_saved = true;
				$article->Save();				
				redirect( base_url('admin/articles?view=view_topics') );
				
			}
			else 
			{
				$tplData['msg'] = validation_errors('<div class="error">', '</div>');
			}
			
		}
		else if($this->input->post('add_advertisement'))
		{
			$this->session->set_userdata('back_to','admin/articles/add');
				
		}
		
		
		$tplData['advertisementList'] =  $advertisementList;
		
		$tplData['categoryList'] = $categoryList;
		
		$tplData['article'] = $article;
		
		$this->parser->parse("admin/articles/add-edit.tpl",$tplData);
	}

	public function edit()
	{
		$articleId = intval($this->input->get('id'));
		if( is_null($articleId) || $articleId == 0)
		{
			redirect( base_url('admin/articles/?error=no_id') );
		}
		
		$article = new Article();
		$article->article_id = $articleId;
		
		if( !$article->IsArticle() )
		{
			redirect( base_url('admin/articles/?error=no_property') );
		}
		
		$css_links = array('style-admin.css');
		$js_links = array('tiny_mce/tiny_mce.js','jQuery.validity.min.js','jquery.autosize.js','jquery.fineuploader-3.0.min.js');
		
		$tplData = $this->GetCommonTpls('Edit Article',NULL,NULL,NULL,$js_links,$css_links);
		
		$tplData['categoryList'] =  Category::GetCategories( NULL, 0);
		
		$tplData['topicList'] = $article->GetTopics();
		
		if($this->input->post('save'))
		{
			//populate temp post data
			$article->ParseToObject( $this->input->post() );
			
			
			$this->form_validation->set_rules('article_title', 'Article Title', 'trim|required' );
			$this->form_validation->set_rules('article_category', 'Category', 'trim|required' );

			//die();
			
			/*$session = $this->session->userdata('tmpUploads360');
			$imageList = $session['files'];
			$article->SetImageList360($imageList);
					
			$session = $this->session->userdata('tmpUploads');
			$imageList = $session['files'];
			$article->SetImageList($imageList);*/
					
			if ( $this->form_validation->run() )
			{
				$article->ParseToObject( $this->input->post() );
				$article->Save();				
				redirect( base_url('admin/articles?view=view_topics') );
				
			}
			else 
			{
				$tplData['msg'] = validation_errors('<div class="error">', '</div>');
			}
			
		}
		else if($this->input->post('add_advertisement'))
		{
			$this->session->set_userdata('back_to','admin/articles/add');
		}
		
		$tplData['article'] = $article;
		
		$this->parser->parse("admin/articles/add-edit.tpl",$tplData);
	}
	
	
	public function UploadImage()
	{
		
		$uploadPath = '';
		$uploadUrl = '';
		
		$topicId = $this->input->get('id');
		
		$this->load->library('qquploadedfilexhr');
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array('png', 'jpeg', 'jpg', 'gif', 'bmp');
		// max file size in bytes
		$sizeLimit = 1 * 1024 * 1024;
		//max width and height
		$dimentions = array('width'=>300, 'height'=> 300,  );
		
		$dimentions['thumb'] = array('width'=> ($dimentions['width']/100)*20, 'height'=> ($dimentions['height']/100)*20);
		
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		
		if( $topicId && (intval($topicId) > 0) )
		{
			$uploadPath .= './user_data/topics/'.$topicId.'/images/';
			$uploadUrl .= 'user_data/topics/'.$topicId.'/images/';
			
			if( !is_dir($uploadPath) )
			{
				mkdir($uploadPath,0777,true);
			}
			
			$topic = new Topic();
			$topic->topic_id = $topicId;
			
			if( !$topic->Istopic() )
			{
				jsonEcho( array('error'=>true,'message'=>'topic not found') );
				return;
			}
			
			$topic->Refresh();
			
			$result = $uploader->handleUpload($uploadPath,false,$dimentions,true);
			
			if( isset($result['success']) && $result['success'] )
			{
				$imgUrl = $uploadUrl.$result['filename'];
				$result['file_url'] = $imgUrl;
				
				$fileData = array('index'=> $result['filename_we'],'data' => array('fileName'=>$result['filename'],'filePath' =>  $uploadPath . $result['filename'], 'fileUrl' => $imgUrl));
				
				if( !$topic->InsertImage($fileData) )
				{
					jsonEcho( array('error'=>true,'message'=>'Image insert failed') );
					return;
				}
			}
			
			echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
		}
	}
	
	public function DeleteImage()
	{
		$topicId = $this->input->post('pid');		
		$fileId = $this->input->post('file');
		if( $topicId && (intval($topicId) > 0) )
		{
			$uploadPath = './userdata/topics/'.$topicId.'/images/';
			
			$topic = new Topic();
			$topic->topic_id = $topicId;
			
			if( !$topic->IsTopic() )
			{
				jsonEcho( array('error'=>true,'message'=>'Topic not found') );
				return;
			}
			
			$topic->Refresh();
			
			if( $fildeId = $topic->DeleteImage($fileId) )
			{	
				jsonEcho( array('success'=>true,'fileId'=>$fileId) );
				return;
			}
			else
			{
				jsonEcho( array('error'=>true,'message'=>'Image Deletion failed') );
				return;
			}
			
		}
	}
}
