<?php
class Application_Form_Subseria extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('subseria');
        $this->setMethod('post');
        $this->setAction('/subseria/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
             ->addErrorMessage('Обязательное поле');
       	
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $options = $db->fetchPairs($db->select()->from('seria', array('id', 'name'))->order('name'), 'id');
        $seria_id = $this->createElement('select', 'seria_id');
        $seria_id->addMultiOption(0, 'Не выбрано');
        $seria_id->AddMultiOptions($options)
                   ->setRequired()
                   ->registerInArrayValidator();
        $seria_id->setValue(0);
        
        $order= $this->createElement('text', 'order');
        $order->setLabel('order');
        
        $this->addElements(
            compact('id', 'name', 'seria_id', 'order'
        ));
        $this->addElements(Application_Form_Elements::getStandardButtons('subseria'));
    }
}