<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('abs_path'))
{
    function abs_path()
    {	
		return str_replace("\\","/",FCPATH);
    }
}

if (!function_exists('wrapError'))
{
    function wrapError($string)
    {	
		return '<div class="error">'.$string.'</div>';
    }
}

if (!function_exists('wrapSuccess'))
{
    function wrapSuccess($string)
    {	
		return '<div class="success">'.$string.'</div>';
    }
}

if (!function_exists('deleteAll'))
{
	function deleteAll($directory, $empty = false) { 
		if(substr($directory,-1) == "/") { 
			$directory = substr($directory,0,-1); 
		} 
	
		if(!file_exists($directory) || !is_dir($directory)) { 
			return false; 
		} elseif(!is_readable($directory)) { 
			return false; 
		} else { 
			$directoryHandle = opendir($directory); 
			
			while ($contents = readdir($directoryHandle)) { 
				if($contents != '.' && $contents != '..') { 
					$path = $directory . "/" . $contents; 
					
					if(is_dir($path)) { 
						deleteAll($path); 
					} else { 
						unlink($path); 
					} 
				} 
			} 
			
			closedir($directoryHandle); 
	
			if($empty == false) { 
				if(!rmdir($directory)) { 
					return false; 
				} 
			} 
			
			return true; 
		} 
	} 
}

if (!function_exists('convertDate'))
{
	function convertDate($str,$inputFormat= NULL) {
        if (is_null($str))
            return NULL;
        
		if(is_null($inputFormat))
			$inputFormat = 'd/m/Y';

        $date = date_parse_from_format($inputFormat, $str);
		
		$time = "";
		if($date['hour'] && $date['minute'] && $date['second'])
			$time = " ".$date['hour'].":".$date['minute'].":".$date['second'];
		
		
		
        $refacteredDate = $date['day'] . "-" . $date['month'] . "-" . $date['year'].$time;
        return $refacteredDate;
    }
}



if (!function_exists('convertToMySQLdatetime'))
{
	function convertToMySQLdatetime($date) {
		return date("Y-m-d H:i:s", strtotime($date));
	}
}

if (!function_exists('jsonEcho'))
{
	function jsonEcho($data)
	{
		echo json_encode($data);
		exit();
	}
	
}

if (!function_exists('_var_dump'))
{
	function _var_dump($data)
	{
		echo "<pre>";
		echo var_dump($data);
		echo "</pre>";
	}
	
}

if (!function_exists('title2url'))
{
	function title2url($data)
	{
		echo strtolower( str_replace(' ', '-', $data) );
	}
	
}

if ( !function_exists('br2nl') )
{
	function br2nl($string)
	{
		return preg_replace('#<br\s*?/?>#i', "\n", $string);
	}

}

if ( !function_exists('roundTo2Dec') )
{
	function roundTo2Dec($value,$alwaysDecimal=true)
	{
		if($alwaysDecimal)
			return number_format(doubleval($value), 2, '.', '');
		else
			return round( doubleval($value), 2);
	}
}


if ( !function_exists('inDollers') )
{
	function inDollers($value)
	{
		//return '$'.round( doubleval($value), 2);
		return '$'.money_format('%i',round( doubleval($value), 2));		
	}
}

if ( !function_exists('infDate') )
{
	function infDate()
	{
		return '2038-01-01';
	}
}

if ( !function_exists('userDate') )
{
	function userDate($mysqlDate)
	{
		$date = new DateTime($mysqlDate);
		return $date->format('d/m/Y');
		//return date('d/m/Y', strtotime($mysqlDate));
	}
}

if ( !function_exists('today') )
{
	function today()
	{
		return date('Y-m-d');
	}
}

if ( !function_exists('now') )
{
	function now()
	{
		return date('Y-m-d H:i:s');
	}
}