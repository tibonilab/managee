<?php
/**
 * Description of Category_content
 *
 * @author Alberto
 */
class Feature_content {
    
    public $category_id = FALSE;
    public $iso;
    public $active  = TRUE;
    
    public $label;
	public $value;
    public $extra;
    
    private $slug;
    
    public function is_active()
    {
        return (bool) $this->active;
    }
    
    public function set_slug($slug)
    {
        $this->slug = $slug;
    }
    
    public function get_slug()
    {
        return $this->slug;
    }
	
	public function set_value($data)
	{		
		$this->value = (isset($data->value)) ? $data->value : NULL;
	}
    
}

?>
