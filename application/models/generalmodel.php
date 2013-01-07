<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Defines Data Management functions of FoodCategory Library
 * 
 */

class GeneralModel extends CI_Model
{
    
    /*
     * Static db reference
     */
    protected static $db;
    protected static $CI;
	
    public function __construct()
    {
        parent::__construct();
        self::$db = & get_instance() -> db;              
		self::$CI = & get_instance(); 
    }
    
    protected static function MapData($inputArray, $mappingTable)
    {
        $returnArray = array();
        
        foreach($mappingTable as $key => $field)
        {
            if(array_key_exists($key, $inputArray))
            {
                $returnArray[$field] = $inputArray[$key];
            }
        }
        
        return $returnArray;
    }
    
    protected static function ReverseMapData($inputArray, $mappingTable)
    {
        $returnArray = array();
        $row_index = 0;
        foreach ($inputArray as $row) 
        {            
            foreach($mappingTable as $key => $field)
            {                
                if(array_key_exists($field, $row))
                {                    
                    $returnArray[$row_index][$key] = $row[$field];
                }
            }
            
            $row_index++;
        }
        
        
        return $returnArray;
    }
    
    
    /*
     * Helper functions
     */
     
    protected function ReturnIfDataExist($sqlResult,$defaultReturnValue)
    {
        if($sqlResult->num_rows() > 0)
            return $sqlResult;
        else
            return $defaultReturnValue;
        
    }
    
	
	public function Validate($data,$validationRules)
	{
		$output = array();
		$output['errors'] = false;
		$output['errorMessages'] = array();
		
		foreach ($validationRules as $validationIndex => $propertyValidation) 
		{
			
			if(array_key_exists($validationIndex, $data))
			{
				$validaitons = explode("|", $propertyValidation);
				
				foreach ($validaitons as $rule) {
					$ret = $this->ValidateData($data[$validationIndex], $rule);
					if($ret['error'])
					{
						
						$output['errors'] = true;
						
						$output['errorMessages'][$validationIndex][] = $ret['message'];
						
					}
					
				}
				
			}
			
		}
		
		return $output;
	}
	
	protected function ValidateData($data,$rule,$parameters=NULL)
	{
		$return = array();
		$return['error'] = false;
		$return['message'] = '';
		
		$this->load->library('validate',NULL,'validator');
		
		switch ($rule) {
			case 'required':
				
				if( empty($data) )
				{
					$return['error'] = true;
					$return['message'] = " is Required";				
				}
				break;
				
			case 'interger':
				
				if( $this->validator->check_integer($data) )
				{
					$return['message'] = $this->validator->error;
					$return['error'] = true;				
				}
				
				
				break;
		}
		
		
		
		
		return $return;
	}
	
}