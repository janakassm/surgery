<?php
class TemplateManager {
	private $CI;
	
	public function __construct()
    {
		$this->CI = & get_instance();
	}
	
	public function GetTempletes($gdata = array(),$hdata = array(),$fdata = array(),$addtpl=array())
	{
		$data = array();
		$headdata = array_merge($hdata,$gdata);
		
		$data['headder'] = $this->CI->parser->parse("common/header.tpl",$headdata,true);
		$footdata = array_merge($fdata,$gdata);
		
		$data['footer'] = $this->CI->parser->parse("common/footer.tpl",$footdata,true);
		
		
		
		$addTplCommonData = array();
		
		foreach($addtpl as $tpl)
		{
			$addtpldata = array_merge($addTplCommonData,$tpl['data']);
			$data[$tpl['template_name']] = $this->CI->parser->parse($tpl['template_location'],$addtpldata,true);
		}
		
		return $data;
	}
}
?>