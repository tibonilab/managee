<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/** 
 * MY_Autoloader Class 
 * 
 * @package CodeIgniter 
 * @subpackage Hooks 
 * @category Hooks 
 * @author Shane Pearson <shane@highermedia.com> 
 */ 
class MY_Autoloader {
	
	private $_include_paths = array();
	
	public function register(array $paths = array()) { 
	  $this->_include_paths = $paths; 
	  spl_autoload_register(array($this, 'autoloader')); 
	}
    
	public function autoloader($class) { 
	  
	  foreach($this->_include_paths as $path) { 
	    $filepath = strtolower("./".$path . $class . EXT); 
		
		if(!class_exists($class, FALSE) && is_file($filepath)) { 
		
		  include_once($filepath); break; 
		  
		} 
	  } 
	}
}