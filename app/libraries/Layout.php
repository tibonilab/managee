<?php
/**
 * CodeIgnighter layout support library
 *  with Twig like inheritance blocks
 *
 * v 1.0
 *
 *
 * @author Constantin Bosneaga
 * @email  constantin@bosneaga.com
 * @url    http://a32.me/
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Layout {
    private $obj;
    private $layout_view;
    private $title;
    private $metadata = array();
    private $css_list = array(), $js_list = array();
    private $block_list, $block_new, $block_replace = false;
	
	private $theme = NULL;
	private $themes_path = NULL;
	
	private $components_path = 'components';	
	private $snippets_path = 'snippets';
	private $widgets_path = 'widgets';
	
	function __construct() {
        $this->obj =& get_instance();
        // Error prevent if layout not declared from called controller
        $this->layout_view = "layouts/default.php"; 
    }
	
	function set_theme($folder) {
		$this->theme = str_replace('/','', $folder) . '/';
		$this->themes_path = 'themes';
	}
	
	function get_theme() {
		return $this->theme;
	}

    function view($view, $data = null, $return = false) {
        // Grab layout data from called controller
        if (isset($this->obj->layout_view)) $this->layout_view = $this->obj->layout_view;
        if (isset($this->obj->title)) $this->title = $this->obj->title;
        
        // grab data setted on controller
        $data = $this->obj->get_data();
        
        // Render template
        $data['content_for_layout']         = $this->obj->load->view($this->_layout_view($view), $data, true);
        $data['title_for_layout']           = $this->title;
        
        // metadata
        $data['metadata'] = '';
        foreach($this->metadata as $k => $v)
            $data['metadata'] .= sprintf('<meta name="%1$s" value="%2$s">', $k, $v);
		
        // Render resources
        $data['js_for_layout'] = '';
        foreach ($this->js_list as $v)
            $data['js_for_layout'] .= sprintf('<script type="text/javascript" src="assets/js/%s"></script>', $v);

        $data['css_for_layout'] = '';
        foreach ($this->css_list as $v)
            $data['css_for_layout'] .= sprintf('<link rel="stylesheet" type="text/css"  href="%s" />', $v);
        
        // Render template
        $this->block_replace = true;
        $output = $this->obj->load->view($this->_layout_view(), $data, $return);

        return $output;
    }
	
	private function _layout_view($view = NULL) {
		if	($view)
		{
			return  (is_null($this->theme)) ? $view : $this->themes_path . '/' . $this->theme . $view;
		}
		else
		{
			return  (is_null($this->theme)) ? $this->layout_view : $this->themes_path . '/' . $this->theme . $this->layout_view;
		}
	}
	
	
	public function load_view($view, $data = NULL)
	{
		return $this->obj->load->view($this->themes_path . '/' . $this->theme . $view, $data, TRUE);
	}
	
	
/*
	private function _layout_view($view = NULL) {
		if	($view)
		{
			return  $this->theme . $view;
		}
		else
		{
			return  $this->theme . $this->layout_view;
		}
	}
*/	
	
	
    /**
     * Set page title
     *
     * @param $title
     */
    function set_title($title) {
        $this->title = $title;
    }
    
    function set_metadata($name, $value)
    {
        $this->metadata[$name] = $value;
    }

    /**
     * Adds Javascript resource to current page
     * @param $item
     */
    function add_js($item) {
        $this->js_list[] = $item;
    }

    /**
     * Adds CSS resource to current page
     * @param $item
     */
    function add_css($item) {
        $this->css_list[] = $item;
    }

    /**
     * Twig like template inheritance
     *
     * @param string $name
     */
    function block($name = '') {
        if ($name != '') {
            $this->block_new = $name;
            ob_start();
        } else {
            if ($this->block_replace) {
                // If block was overriden in template, replace it in layout
                if (!empty($this->block_list[$this->block_new])) {
                    ob_end_clean();
                    echo $this->block_list[$this->block_new];
                }
            } else {
                $this->block_list[$this->block_new] = ob_get_clean();
            }
        }
    }
	
	
	function snippet($view, $data = NULL)
	{
		$expl = explode('/', $view);
		
		$slugs = array(
			$this->themes_path,
			$this->theme,
			$expl[0],
			'snippets',
			$expl[1]
		);
		
		$view = implode('/', $slugs);
		
		return $this->obj->load->view($view, $data, TRUE);
	}	
		
	function component($view, $data = NULL)
	{
		
		return $this->obj->load->view($this->_get_view($view, 'component'), $data, TRUE);
	}	
	
	function widget($view, $data = NULL)
	{
		return $this->obj->load->view($this->_get_view($view, 'widget'), $data, TRUE);
	}
	
	
	private function _get_view($view, $type)
	{
		// get caller method name to get element's path
		$path	= $type .'s_path';
		
		// generate path/to/view array
		$segments = array();
		$segments[] = $this->$path;
		$segments[] = $view;
		
		
		// return path/to/view string 
		return  implode('/', $segments);
	}

}