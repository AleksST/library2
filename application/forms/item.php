<?php
class Application_Form_Item extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('item');
        $this->setMethod('post');
        $this->setAction('/item/');
        
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        
        $id = new Zend_Form_Element_Hidden('id');
        // contries
        $countries = $db->fetchPairs($db->select()->from('country', array('id', 'name'))->order('name'), 'id');
        $country_id = $this->createElement('select', 'country_id');
        $country_id->addMultiOption(0, 'Не выбрано');
        $country_id->AddMultiOptions($countries)
                   ->setRequired()
                   ->registerInArrayValidator();
        $country_id->setValue(0);
        
        $cities = $db->fetchPairs($db->select()->from('city', array('id', 'name'))->order('name'), 'id');
        $city_id = $this->createElement('select', 'city_id');
        $city_id->addMultiOption(0, 'Не выбрано');
        $city_id->AddMultiOptions($cities)
                   ->setRequired()
                   ->registerInArrayValidator();
        $city_id->setValue(0);
        
        $type_id = $this->createElement('text', 'type_id');
        $type_id->setRequired()->setLabel('type_id')
        	 ->addErrorMessage('Обязательное поле');
        
        $this->addElements(
            compact('id', 'type_id', 'city_id', 'country_id'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('item'));
    }
}