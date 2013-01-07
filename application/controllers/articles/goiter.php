<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Goiter extends Guest_Controller {
		
	public function index()
	{
		$tplData = $this->GetCommonTpls('Home');
		
		
		
		
		$this->parser->parse("articles/goiter.tpl",$tplData);
	}
}
