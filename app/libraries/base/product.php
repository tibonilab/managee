<?php
/**
 * Product - Product data
 *
 * @package CodeIgniter
 * @subpackage ecommerce
 * @category products
 * @author Tiboni Alberto - http://www.tibonilab.com/
 */
class Product extends Route {

    public $id          = FALSE;
	public $category_id;
	public $name;
	public $code;
	public $is_new		= FALSE;
    public $published   = FALSE;
    public $default_image_id;
    public $type_products_id;
    public $lat			= 0;
	public $lng			= 0;
	public $city;
    public $distance;
	
	protected $_category;
	
	private $_content		= NULL;
    private $_contents		= NULL;
    private $_images		= NULL;
	private $_versions		= NULL;
	private $_videos		= NULL;
    private $_default_image = NULL;
	private $_default_video = NULL;
    private $_groups_features	= array();
    private $_properties		= array();
	private $_links				= array();
	private $_related_products	= NULL;
	
	private $_prev	= NULL;
	private $_next	= NULL;
	
    function __construct()
    {
        parent::__construct();
        
        // init empty contents
		if($this->environment == 'admin')
		{
			$this->_init_contents();
		}
    }
    
	public function is_new()
	{
		return (bool) $this->is_new;
	}
	
	public function set_links()
	{
		$this->_links = $this->front_link_model->get_product_links($this);
	}
	
	public function get_links()
	{
		return $this->_links;
	}
	
	/**
	 * set empty product content translations list
	 * 
	 * @access private
	 */
    private function _init_contents()
    {
        foreach($this->languages as $lang)
        {
            $content = new Product_content();
            $content->iso = $lang->iso;

            $this->_contents[$lang->iso] = $content;
        }
    }
    
	public function set_content()
	{
		$this->_content = $this->front_product_model->get_content($this->id);
		
		$this->set_route();
	}
	
	private function _set_content()
	{
		$this->_content = $this->front_product_model->get_content($this->id);
		
		$this->set_route();
	}
	
	public function get_content($field, $trim = FALSE)
	{
		if(is_null($this->_content))
		{
			$this->_set_content();
		}
		return ($trim) ? substr(strip_tags($this->_content->$field), 0, $trim) . '...' : $this->_content->$field;
	}
	
	
	/**
	 * product publication test
	 * 
	 * @access public
	 * @return bool
	 */	
    public function is_published()
    {
        return (bool) $this->published;
    }
    
	/**
	 * set product content translations list
	 * 
	 * @access public
	 * @param array $contents
	 */
    public function set_contents($contents)
    {
        $this->_contents = $contents;
    }
    
	/**
	 * get product content tranlations list
	 * 
	 * @access public
	 * @return array
	 */
    public function get_contents()
    {
        return $this->_contents;
    }
    
	/**
	 * set product image list
	 * 
	 * @access public
	 * @param array $images
	 */
    public function set_images($images)
    {
        $this->_images = $images;
    }
	
	private function _set_images()
	{
		if($this->environment == 'front')
		{
			$this->_images = $this->front_product_model->get_images($this->id);
		}
		else
		{
			$this->_images = $this->product_model->get_product_images($this->id);
		}
	}
	
	/**
	 * get product image list
	 * 
	 * @access public
	 * @return array
	 */
    public function get_images($type = NULL)
    {
		if(is_null($this->_images))
		{
			$this->_set_images();
		}
		
		if($type) // frontend
		{
			return (isset($this->_images[$type])) ? $this->_images[$type] : array();
		}
		
		// backend 
		return $this->_images;
    }
    
	/**
	 * Check if $image_id is the default image id
	 * 
	 * @access public
	 * @param int $image_id
	 * @return bool
	 */
    public function is_default_image($image_id)
    {
        return ($this->default_image_id == $image_id);
    }
    
	/**
	 * set default image for product
	 * 
	 * @param Image $image
	 */
    public function set_default_image(Image $image)
    {
        $this->_default_image = $image;
    }
    
	private function _set_default_image()
    {
		if($this->environment == 'admin')
		{
			$this->_default_image = $this->image_model->get_image($this->default_image_id);
		}
		else
		{
			$this->_default_image = $this->front_image_model->get($this->default_image_id);
		}
    }
	
    /**
     * get default image for product
     * 
	 * @access public
     * @return Image
     */
    public function get_default_image()
    {
		if(is_null($this->_default_image))
		{
			$this->_set_default_image();
		}
        return $this->_default_image;
    }
    
	/**
	 * set product category
	 * 
	 * @access public
	 * @param Category $category
	 */
    public function set_category(Category $category)
    {
        $this->_category = $category;
    }

	private function _set_category()
	{
		if($this->environment == 'front')
		{
			$this->set_category($this->front_category_model->get($this->category_id));
		}
		else
		{
			$this->set_category($this->category_model->get_category($this->category_id));
		}
	}
	
		
	/**
	 * get product category
	 * 
	 * @access public
	 * @return Category
	 */
    public function get_category()
    {
		if( is_null($this->_category))
		{
			$this->_set_category();
		}
		
        return $this->_category;
    }

	/**
	 * format price
	 * 
	 * @return string
	 */
	public function get_price()
	{
		return number_format($this->price, 2 , ',' , '.');
	}
    
    public function set_groups_features($groups_features)
    {
        $this->_groups_features = $groups_features;
    }    
    
    public function get_groups_features()
    {
		if($this->environment == 'front')
		{
			$this->load->model('front/front_feature_model');
			$this->load->model('front/front_group_features_model');
			$this->set_groups_features($this->front_feature_model->get_groups_features($this, 'product'));
		}
		
        return $this->_groups_features;
    }
	
	public function set_properties($properties)
	{
		$this->_properties = $properties;
	}
	
	public function get_properties()
	{
		return $this->_properties;
	}
	
	
	public function is_in_showcase($showcase_id)
	{
		return (bool) $this->db->get_where('showcase_products', array('showcase_id' => $showcase_id, 'product_id' => $this->id))->row();
	}
	
	public function get_next_url($hash = NULL)
	{
		$this->_set_next_item();
		
		return ($this->has_next_item()) ? $this->_next->get_route() . $hash : NULL;
	}
	
	public function has_next_item()
	{
		$this->_set_next_item();	
		
		return (bool) $this->_next;
	}
	
	private function _set_next_item()
	{
		if(is_null($this->_next))
		{
			$this->db->order_by('ord', 'asc');
			$this->db->limit(1);
			$this->db->where('category_id', $this->category_id);
			$this->db->where('ord >', $this->ord);
			$this->_next = $this->db->get('products')->row(0, 'product');
		}
	}
	
		
	public function get_prev_url($hash = NULL)
	{
		$this->_set_prev_item();
		
		return ($this->has_prev_item()) ? $this->_prev->get_route() . $hash : NULL;
	}
	
	public function has_prev_item()
	{
		$this->_set_prev_item();	
		
		return (bool) $this->_prev;
	}
	
	private function _set_prev_item()
	{
		if(is_null($this->_prev))
		{
			$this->db->order_by('ord', 'desc');
			$this->db->limit(1);
			$this->db->where('category_id', $this->category_id);
			$this->db->where('ord <', $this->ord);
			$this->_prev = $this->db->get('products')->row(0, 'product');
		}
	}

		
	private function _set_videos()
	{
		if($this->environment == 'front')
		{
			$this->_videos = $this->front_product_model->get_videos($this->id);
		}
		else
		{
			$this->_videos = $this->product_model->get_product_videos($this->id);
		}
	}
	
	/**
	 * get product video list
	 * 
	 * @access public
	 * @return array
	 */
    public function get_videos()
    {
		if(is_null($this->_videos))
		{
			$this->_set_videos();
		}
		
		return $this->_videos;
    }

	
	public function has_default_video()
	{
		return (bool) $this->get_default_video();
	}
	
	public function get_default_video()
	{
		$this->_set_default_video();
		
		return $this->_default_video;
	}
	
	private function _set_default_video()
	{
		if(is_null($this->_default_video))
		{
			$this->db->join('product_videos', 'product_videos.video_id = videos.id');
			$this->db->where('product_videos.product_id', $this->id);
			$this->db->where('product_videos.is_default', 1);
			$this->db->where('videos.published', 1);
			
			$this->_default_video = $this->db->get('videos')->row(0, 'video');
		}
	}
	
	/**
	 * 
	 * Product Related products
	 * 
	 */
	public function has_related_products()
	{
		$this->_set_related_products();
		
		return (bool) count($this->_related_products);
	}
	
	private function _set_related_products()
	{
		if(is_null($this->_related_products))
		{
			/*
			$this->db->join('related_products rp', 'rp.related_id = p.id');
			$this->db->where('rp.current_id', $this->id);
			if($this->environment == 'front')
			{
				$this->db->where('p.published', 1);
			}
			$this->db->order_by('rp.ord');
			$this->_related_products = $this->db->get('products p')->result('product');
			
			if($this->environment == 'front')
			{
				if( ! $this->_related_products)
				{*/
					$this->db->where('p.category_id', $this->category_id);
					$this->db->where('p.published', 1);
					$this->db->where('id !=', $this->id);
					$this->db->order_by('RAND()');
					$this->db->limit(4);
					$this->_related_products = $this->db->get('products p')->result('product');
					
				/*}
				*/
				foreach($this->_related_products as &$item)
				{
					$item->set_content();
					if(isset($item->default_image_id)) $item->set_default_image($this->front_image_model->get($item->default_image_id));
				}
			/*}*/
		
		}
	}
	
	public function get_related_products()
	{
		$this->_set_related_products();
		
		return $this->_related_products;
	}
	
	
	public function get_versions()
	{
		$this->_set_versions();
		
		return $this->_versions;
	}
	
	private function _set_versions()
	{
		if(is_null($this->_versions))
		{
			$this->db->where('product_id', $this->id);
			$this->_versions = $this->db->get('product_versions')->result('version');
		}
	}
	
}

?>
