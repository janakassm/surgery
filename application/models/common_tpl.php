<?php
class Common_tpl extends CI_Model {
	var $user	=	array();
	var $ci;
	public function __construct()
    {
        parent::__construct();
		$ci = get_instance();
		$ci->load->model('Ezauth_model','auth');
		$this->load->model('Public_manage_model','manage');
		$ci->load->library('parser');
		
		$this->auth->program = 'member';
	}
	
	function auth()
	{
		if ($this->session->userdata('ez_user')) {
			$this->user = $this->session->userdata('ez_user');
		}
		$auth = $this->auth->authorize("profile", false);
		return $auth['authorize'];
	}
	
	public function gettempletes($hdata = array(),$fdata = array(),$cdata=array(),$addtpl=array())
	{
		
		if($this->auth() && $this->user)
		{
			$hdata['userData'] = $this->user;
			$cdata['userData'] = $this->user;			
			$addTplCommonData = array('base_url'=>base_url());
			$this->load->model('messager');
			$this->load->model('notifications_model');			
			$addTplCommonData['unreadMessagesCount'] = $this->messager->getNumberOfUnreadMessages($this->user->id);
			$addTplCommonData['unreadNotificationCount'] =$this->notifications_model->getNumberOfUnreadNotifications($this->user->id);			
			$hdata['accUM'] = $addTplCommonData['unreadMessagesCount']+$addTplCommonData['unreadNotificationCount'];
		}
		
		$headdata = array_merge($hdata,array('base_url'=>base_url()));
		
		$this->load->helper('breadcrumb');
		
		$breadCrumb = NULL;
		if(isset($hdata['bcConf']))
			$breadCrumb = set_breadcrumb('','',$hdata['bcConf']);
		else
			$breadCrumb = set_breadcrumb();
		
		$headdata['breadCrumb'] = $breadCrumb;
		
		$data['headder'] = $this->parser->parse("common/header.tpl",$headdata,true);
		$footdata = array_merge($fdata,array('base_url'=>base_url()));
		$data['footer'] = $this->parser->parse("common/footer.tpl",$footdata,true);
		
		
		
		
		$cats = $this->manage->getProductCategoriesWithCount();
		
		foreach($cats as $key=>$itm)
		{
			$cats[$key]->lvl1 = $this->manage->getProductCategoriesWithCount(1,$itm->id);
			foreach($cats[$key]->lvl1 as $key2=>$itm2)
				$cats[$key]->lvl1[$key2]->lvl2 = $this->manage->getProductCategoriesWithCount(2,$itm2->id);
		}
		
		$catelogdata = array('base_url'=>base_url(),'cats'=>$cats);
		//var_dump($catelogdata['cats']);
		if($cdata == NULL)
			$cdata = array();
		$catelogdata = array_merge($cdata,$catelogdata);
		$data['catelogset'] = $this->parser->parse("common/catelog_set.tpl",$catelogdata,true);
		
		$googleAdsData = array();
		$data['googleAds'] = $this->parser->parse("common/google_ads.tpl",$googleAdsData,true);
		
		foreach($addtpl as $tpl)
		{
			$addtpldata = array_merge($addTplCommonData,$tpl['data']);
			$data[$tpl['template_name']] = $this->parser->parse($tpl['template_location'],$addtpldata,true);
		}
		
		return $data;
	}
	
	public function getAdminTempletes($hdata = array(),$fdata = array(),$cdata=array(),$addtpl=array())
	{
		
		if($this->auth() && $this->user)
		{
			$hdata['userData'] = $this->user;
			$cdata['userData'] = $this->user;			
			$addTplCommonData = array('base_url'=>base_url());
			$this->load->model('messager');
			$this->load->model('notifications_model');			
			$addTplCommonData['unreadMessagesCount'] = $this->messager->getNumberOfUnreadMessages($this->user->id);
			$addTplCommonData['unreadNotificationCount'] =$this->notifications_model->getNumberOfUnreadNotifications($this->user->id);			
			$hdata['accUM'] = $addTplCommonData['unreadMessagesCount']+$addTplCommonData['unreadNotificationCount'];
		}
		
		$headdata = array_merge($hdata,array('base_url'=>base_url()));
		
		$this->load->helper('breadcrumb');
		
		$breadCrumb = NULL;
		if(isset($hdata['bcConf']))
			$breadCrumb = set_breadcrumb('','',$hdata['bcConf']);
		else
			$breadCrumb = set_breadcrumb();
		
		$headdata['breadCrumb'] = $breadCrumb;
		
		$data['headder'] = $this->parser->parse("admin/common/header.tpl",$headdata,true);
		$footdata = array_merge($fdata,array('base_url'=>base_url()));
		$data['footer'] = $this->parser->parse("common/footer.tpl",$footdata,true);
		
		
		
		
		$cats = $this->manage->getProductCategoriesWithCount();
		
		foreach($cats as $key=>$itm)
		{
			$cats[$key]->lvl1 = $this->manage->getProductCategoriesWithCount(1,$itm->id);
			foreach($cats[$key]->lvl1 as $key2=>$itm2)
				$cats[$key]->lvl1[$key2]->lvl2 = $this->manage->getProductCategoriesWithCount(2,$itm2->id);
		}
		
		$catelogdata = array('base_url'=>base_url(),'cats'=>$cats);
		//var_dump($catelogdata['cats']);
		if($cdata == NULL)
			$cdata = array();
		$catelogdata = array_merge($cdata,$catelogdata);
		$data['catelogset'] = $this->parser->parse("common/catelog_set.tpl",$catelogdata,true);
		
		$googleAdsData = array();
		$data['googleAds'] = $this->parser->parse("common/google_ads.tpl",$googleAdsData,true);
		
		foreach($addtpl as $tpl)
		{
			$addtpldata = array_merge($addTplCommonData,$tpl['data']);
			$data[$tpl['template_name']] = $this->parser->parse($tpl['template_location'],$addtpldata,true);
		}
		
		return $data;
	}
	
}
?>