<?php
class Application_Form_City extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('city');
        $this->setMethod('post');
        $this->setAction('/city/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
             ->addErrorMessage('Обязательное поле');
       	
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $options = $db->fetchPairs($db->select()->from('country', array('id', 'name'))->order('name'), 'id');
        $country_id = $this->createElement('select', 'country_id');
        $country_id->addMultiOption(0, 'Не выбрано');
        $country_id->AddMultiOptions($options)
                   ->setRequired()
                   ->registerInArrayValidator();
        $country_id->setValue(0);
        
        $short_name = $this->createElement('text', 'short_name');
        $short_name->setLabel('короткое имя');
        
        $this->addElements(
            compact('id', 'name', 'country_id', 'short_name'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('city'));
    }
}