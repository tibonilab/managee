<?php

/**
 * Description of group_features_model
 *
 * @author alberto
 */
class Group_features_model extends MY_Model {
    
    function __construct() {
        parent::__construct();
    }

        public function init_validation_rules()
    {
        $rules = array(
            array(
                'field' => 'group_features[name]',
                'label' => 'Nome Gruppo',
                'rules' => 'trim|required'
            ),
        );
        
        foreach($this->languages as $lang)
        {
            $content_rules = array(
                    array(
                        'field' => 'content['.$lang->iso.'][label]',
                        'label' => 'Etichetta in lingua "'. $lang->iso .'"',
                        'rules' => ''
                    )
            );
            
            $rules = array_merge($rules, $content_rules);
        }
        
        return $rules;
    }
    
    public function get_all()
    {
        $groups_features = $this->db->order_by('name')->get('groups_features')->result('group_features');
        
        foreach($groups_features as $group_features)
        {
            $group_features->set_contents($this->_get_contents($group_features->id));
        }
        
        return $groups_features;
    }
    
    public function get($id)
    {
        $group_features = $this->db->get_where('groups_features', array('id' => $id))->row(0, 'group_features');
        
        if( ! $group_features)
            return FALSE;
        
        $group_features->set_contents($this->_get_contents($id));
        
        return $group_features;
    }
    
    private function _get_contents($group_id)
    {
        $contents = $this->db->get_where('group_features_contents', array('group_features_id' => $group_id))->result('group_features_content');
        
        $return = array();
        foreach($contents as $content)
        {
            $return[$content->iso] = $content;
        }
        return $return;
    }
    
    
       public function delete($group_features)
    {        
        $this->db->delete('groups_features', array('id' => $group_features->id));
    }
    
    
    
    public function save($id, $group_features_data, $content_data)
    {
        if( ! $id)
        {
            $this->db->insert('groups_features', $group_features_data);
            $id = $this->db->insert_id();
            
            $this->_insert_contents($id, $content_data);
        }
        else
        {
            $this->db->where('id', $id)
                    ->update('groups_features', $group_features_data);
            
            $this->_update_contents($id, $content_data);
        }
        
        return $id;
    }
    
    
     
    
    
    private function _update_contents($group_features_id, $contents)
    {
        foreach($contents as $iso => $data)
        {
            // update content for the iso
            $data['active']     = (isset($data['active'])) ? $data['active'] : 0;
            
            $this->db->where(array('group_features_id' => $group_features_id, 'iso' => $iso))
                    ->update('group_features_contents', $data);
        }
    }    
    
    
    private function _insert_contents($group_features_id, $contents)
    {
        $insert = array();
        {
            foreach($contents as $iso => $values)
            {
                $data               = $values;
                $data['iso']        = $iso;
                $data['group_features_id']    = $group_features_id;
                $data['active']     = (isset($values['active'])) ? $values['active'] : 0;
                
                $insert[] = $data;
            }
        }
        $this->db->insert_batch('group_features_contents', $insert);
    }
    
}

?>