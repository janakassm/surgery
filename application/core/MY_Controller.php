<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* General Auth Controllers */

class General_Controller extends CI_Controller 
{
	protected $logged_user;
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->library('TemplateManager','','tm');
	}

	public function GetCommonTpls($title = 'No Title',$generalData = NULL ,$headderData = NULL ,
									$footerData = NULL,$jslinks = NULL,$csslinks = NULL )
	{
		if( is_null($generalData))
			$generalData = array();
		if( is_null($headderData))
			$headderData = array();
		if( is_null($footerData))
			$footerData = array();
		if( is_null($jslinks))
			$jslinks = array();
		if( is_null($csslinks))
			$csslinks = array();
		
		
		$generalData = array_merge(array ('logged_user' => $this->logged_user) ,	$generalData);	
		
		$data = array('title' => $title, 'base_url'=>base_url());
		$data = array_merge($data,$generalData);
		
		$headdata = array('title'=>$title);
		$headdata = array_merge($headdata,$headderData);
		
		$headdata['jslinks'] = array();
		$headdata['jslinks'] = array_merge($headdata['jslinks'],$jslinks);
		
		$headdata['csslinks'] = array();
		$headdata['csslinks'] = array_merge($headdata['csslinks'],$csslinks);
		
		$footdata = array('date'=>date('Y'));
		$footdata = array_merge($footdata,$footerData);
		
		$data = array_merge($data,$this->tm->GetTempletes($data,$headdata,$footdata));
		
		return $data;
	}
		
}

class Admin_Controller extends General_Controller {
	
	protected $logged_user;
		
	public function __construct()
	{
		parent:: __construct();		
		
		//Check if user is in admin group
        if ( $this->ion_auth->is_admin() ) {

            //Put User in Class-wide variable
            $this->the_user = $this->ion_auth->user()->row();

            //Store user in $data
            $data->the_user = $this->the_user;

            //Load $the_user in all views
            $this->load->vars($data);
        }
        else {
            redirect('authenticaiton/login');
        }
	}
}


class User_Controller extends General_Controller {
	
	protected $logged_user;
	protected $user_group = 'user';
		
		
	public function __construct()
	{
		parent:: __construct();
		//Check if user is in admin group
        if ( $this->ion_auth->in_group($this->user_group) ) {

            //Put User in Class-wide variable
            $this->the_user = $this->ion_auth->user()->row();

            //Store user in $data
            $data->the_user = $this->the_user;

            //Load $the_user in all views
            $this->load->vars($data);
        }
        else {
            redirect('authenticaiton/login');
        }
	}
}

class Guest_Controller extends General_Controller {
	
	
		
	public function __construct()
	{
		parent:: __construct();		
		
		//Check if user is in admin group
        if ( $this->ion_auth->logged_in() ) {

            //Put User in Class-wide variable
            $this->the_user = $this->ion_auth->user()->row();

            //Store user in $data
            $data->the_user = $this->the_user;

            //Load $the_user in all views
            $this->load->vars($data);
        }        
	}
}


/* Project specific Auth Controllers */

class Pharmacist_Controller extends User_Controller
{
	public function __construct()
	{
		$this->user_group = 'pharmacist';
		parent:: __construct();
	}
}
