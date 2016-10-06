<?php
/**
 * Description of partner_model
 *
 * @author Alberto
 */
class Partner_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function init_validation_rules($id)
    {
        $rules = array(
            array(
                'field' => 'item[name]',
                'label' => 'Nome',
                'rules' => 'trim|required'
            )
        );
        
	return $rules;
    }
    
    public function get_all()
    {
		if($this->input->get('key'))
		{
			$this->db->where('label LIKE "%'.$this->input->get('key').'%"');
		}
		
        return $this->db->order_by('label')->get('partners')->result('partner');
    }
    
    
    public function get_partner($id)
    {
        $partner = $this->db->get_where('partners', array('id' => $id))->row(0, 'partner');
        
        return $partner;
  
    }
    
    
    public function delete($partner)
    {
		$this->db->delete('partners', array('id' => $partner->id));
    }
    
    
    
    public function save($id)
    {
		$partner_data = $this->input->post('item');
		
        if( ! $id)
        {
            $this->db->insert('partners', $partner_data);
            $id = $this->db->insert_id();
        }
        else
        {
            $this->db->where('id', $id);
            $this->db->update('partners', $partner_data);
        }
        
        return $id;
    }
    

}

?>
