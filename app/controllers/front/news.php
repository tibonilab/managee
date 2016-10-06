<?php
/**
 * Description of news
 *
 * @author Alberto
 */
class News extends Front_controller{
	
	protected $_views_path = 'news';
	
	function __construct() {
		parent::__construct();
		$this->load->model(array('news_model', 'front/front_news_model'));
		
		$this->data['breadcrumbs']['first_item'] = array('url' => base_url('news'), 'label' => 'News');
	}
	
	public function index()
	{
		$this->data['news_list'] = $this->front_news_model->get_all();
		
		
		$this->_view('index');
	}
	
	public function show($news_id)
	{
		$news = $this->front_news_model->get_news_by_id($news_id);
		
		if( ! $news ) 
		{
			redirect(home_url());
		}
		
		$this->data['breadcrumbs']['list'] = array($news);
		$this->data['news'] = $this->data['item'] = $news;
		
		$this->_view('show');
	}
	
}

?>
