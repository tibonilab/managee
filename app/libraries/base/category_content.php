<?php
/**
 * Description of Category_content
 *
 * @author Alberto
 */
class Category_content {
    
    public $category_id = FALSE;
    public $iso;
    public $active  = TRUE;
    public $image_id;
    
    public $name;
	public $description;
    public $meta_title;
    public $meta_key;
    public $meta_descr;
    
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
    
}

?>
