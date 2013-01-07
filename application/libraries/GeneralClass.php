<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class GeneralClass {
	
	/* Common Class functions */
	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function GetObjectVars() 
	{
		
		$ref = new ReflectionObject($this);
		$pros = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
		$result = array();
		foreach ($pros as $pro) 
		{
			false && $pro = new ReflectionProperty();
			$result[$pro->getName()] = $pro->getValue($this);
		}
		
		return $result;
	}	
	
	public function ParseToObject($array) 
	{		
		$ref = new ReflectionObject($this);
		$pros = $ref->getProperties(ReflectionProperty::IS_PUBLIC);
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name=>$value) {
				
				$name = strtolower(trim($name));
				$found = false;
				foreach ($pros as $pro) {
					
					false && $pro = new ReflectionProperty();
					if($pro->getName() == $name)
					{
						
						$found = true;
					}
					
				}
				if (!empty($name) && $found) {
					$this->$name = $value;
				}
				
			}
		}
	}
}