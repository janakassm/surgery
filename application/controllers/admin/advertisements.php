<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisements extends Guest_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Advertisement');
	}
	
	public function index()
	{
		
		$css = array('style-admin.css');
		$js_links = array('jquery.autosize.js','jquery.fineuploader-3.0.min.js');
		
		$tplData = $this->GetCommonTpls('Manage advertisements',NULL,NULL,NULL,NULL,$css);
		
		$this->parser->parse("admin/advertisements/index.tpl",$tplData);
	}
	
	public function add()
	{
		$title = 'Add Advertisement';
		
		//Clear session data if new advertisement selected
		if($this->input->get('new'))
		{
			$this->session->unset_userdata('admin_current_advertisement_id');
			redirect( base_url('admin/advertisements/add') );
		}
			
		$advertisement = new Advertisement();
		
		//this will be null or advertisement id (if available)
		$advertisement->advertisement_id = intval($this->session->userdata('admin_current_advertisement_id'));
		
		//load from sessions (if available)
		if( !$advertisement->IsAdvertisement() )
		{
			$advertisement->PreRegister();
			$this->session->set_userdata('admin_current_advertisement_id', $advertisement->advertisement_id);
			
		}
		
		//set sessions to avoid redundent items on refresh
		$this->session->set_userdata('admin_current_advertisement_id', $advertisement->advertisement_id);
		
		//_var_dump($advertisement->GetObjectVars());		
		
		
		$css_links = array('style-admin.css');
		$js_links = array('tiny_mce/tiny_mce.js','jQuery.validity.js','jquery.autosize.js','jquery.fineuploader-3.0.min.js');
		
		$tplData = $this->GetCommonTpls($title,NULL,NULL,NULL,$js_links,$css_links);
		
		
		if($this->input->post('save'))
		{
			//populate temp post data
			$advertisement->ParseToObject( $this->input->post() );
			
			$this->form_validation->set_rules('advertisement_title', 'Advertisement Title', 'trim|required' );
			$this->form_validation->set_rules('advertisement_brief', 'Brief', 'trim|required' );
			$this->form_validation->set_rules('advertisement_body', 'Main Advertisement', 'trim|required' );

			if ( $this->form_validation->run() )
			{
				$advertisement->ParseToObject( $this->input->post() );
				
				$advertisement->advertisement_body = htmlspecialchars($advertisement->advertisement_body);
				
				$advertisement->advertisement_expire_date = convertToMySQLdatetime( convertDate($advertisement->advertisement_expire_date) );
				
				$advertisement->advertisement_start_date = convertToMySQLdatetime( convertDate($advertisement->advertisement_start_date) );
				
				$advertisement->Save();
				
				if( $backTo = $this->session->userdata('back_to') )
				{
					redirect( base_url($backTo) );
				}
				else
				{
					redirect( base_url('admin/advertisements/') );
				}
			
			}
			else 
			{
				$tplData['msg'] = validation_errors('<div class="error">', '</div>');
			}
			
		}
		
		
		
		$tplData['advertisement'] = $advertisement;
		
		$this->parser->parse("admin/advertisements/add-edit.tpl",$tplData);
	}
	
	
	public function UploadImage()
	{
		
		$uploadPath = '';
		$uploadUrl = '';
		
		$advertisementId = $this->input->get('id');
		
		$this->load->library('qquploadedfilexhr');
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array('png', 'jpeg', 'jpg', 'gif', 'bmp');
		// max file size in bytes
		$sizeLimit = 1 * 1024 * 1024;
		//max width and height
		$dimentions = array('width'=>300, 'height'=> 300,  );
		
		$dimentions['thumb'] = array('width'=> ($dimentions['width']/100)*20, 'height'=> ($dimentions['height']/100)*20);
		
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		
		if( $advertisementId && (intval($advertisementId) > 0) )
		{
			$uploadPath .= './user_data/advertisements/'.$advertisementId.'/images/';
			$uploadUrl .= 'user_data/advertisements/'.$advertisementId.'/images/';
			
			if( !is_dir($uploadPath) )
			{
				mkdir($uploadPath,0666,true);
			}
			
			$advertisement = new Advertisement();
			$advertisement->advertisement_id = $advertisementId;
			
			if( !$advertisement->IsAdvertisement() )
			{
				jsonEcho( array('error'=>true,'message'=>'advertisement not found') );
				return;
			}
			
			$advertisement->Refresh();
			
			$result = $uploader->handleUpload($uploadPath,false,$dimentions,true);
			
			if( isset($result['success']) && $result['success'] )
			{
				$imgUrl = $uploadUrl.$result['filename'];
				$result['file_url'] = $imgUrl;
				
				$fileData = array('index'=> $result['filename_we'],'data' => array('fileName'=>$result['filename'],'filePath' =>  $uploadPath . $result['filename'], 'fileUrl' => $imgUrl));
				
				if( !$advertisement->InsertImage($fileData) )
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
		$advertisementId = $this->input->post('pid');		
		$fileId = $this->input->post('file');
		if( $advertisementId && (intval($advertisementId) > 0) )
		{
			$uploadPath = './userdata/advertisements/'.$advertisementId.'/images/';
			
			$advertisement = new Advertisement();
			$advertisement->advertisement_id = $advertisementId;
			
			if( !$advertisement->IsAdvertisement() )
			{
				jsonEcho( array('error'=>true,'message'=>'Advertisement not found') );
				return;
			}
			
			$advertisement->Refresh();
			
			if( $fildeId = $advertisement->DeleteImage($fileId) )
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
