<?php
/**
 * Description of Page_content
 *
 * @author Alberto
 */
class Showcase_content {
    public $showcase_id = FALSE;
    public $iso;
    public $active  = TRUE;
    
    public $title;
    public $content;
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
