<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Guest_Controller {
		
	public function index()
	{
		$tplData = $this->GetCommonTpls('Home');
		
		$this->parser->parse("guest/index.tpl",$tplData);
	}
}
