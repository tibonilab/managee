<?php
/**
 * Description of route_model
 *
 * @author Alberto
 */
class Route_model extends MY_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
	
	public function get_all()
	{
		return $this->db->get('routes')->result();
	}
	
	
    public function set_route($slug, $route, $generate = TRUE)
    {
		$to_save = $slug;
		
		if($generate)
		{
			$to_save = $this->_generate_slug($slug);
		}
        
        $this->db->insert('routes', array('slug' => $to_save, 'route' => $route));
        return $this->db->insert_id();
    }
    
    
    public function update_slug($id, $slug)
    {
		$actual_route = $this->get_route_by_id($id);
		
		$to_save = $this->_generate_slug($slug, $id);
		
        if($actual_route->slug != $to_save)
		{
			// set R 301 from old to new route 
			$this->db->where('id', $id);
			$this->db->update('routes', array(
				'response_code' => 301,
				'redirect'		=> base_url($to_save)
			));
			
			// set new route
			$id = $this->set_route($to_save, $actual_route->route, FALSE);
		}
		
		return $id;
		        
    }
    
    
    public function get_slug_by_id($id)
    {
        $route = $this->db->get_where('routes', array('id' => $id))->row();
		
		return ($route) ? $route->slug : NULL;
    }
    
    
	public function get_route_by_id($id)
	{
		return $this->db->get_where('routes', array('id' => $id))->row();
	}
	
	
    // unique slug generation
    private function _generate_slug($slug, $id = FALSE)
    {
        $to_save = $slug;
        
        $modifier = 1;
        while($this->_route_exists($to_save, $id))
        {
            $to_save = $slug . '_' . $modifier;
            $modifier++;
        }
        
        return $to_save;
    }
        
    
    // returns TRUE if slug already exists, otherwise FALSE
    private function _route_exists($slug, $id = FALSE)
    {
        if($id) $this->db->where('id !=', $id);
        
        $this->db->where('slug', $slug);
        $route = $this->db->get('routes')->row();
        
		if ( ! $route)
            return FALSE;
        else
		{
			// if existing route is a redirect, kill it and return FALSE
			if(strlen($route->redirect) > 0)
			{
				$this->db->delete('routes', array('id' => $route->id));
				return FALSE;
			}
			
			return TRUE;
		}
        
    }
    
}

?>
