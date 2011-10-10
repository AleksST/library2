<?php
class Application_Form_Seria extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('seria');
        $this->setMethod('post');
        $this->setAction('/seria/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
             ->addErrorMessage('Обязательное поле');
       	
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $options = $db->fetchPairs($db->select()->from('publicher', array('id', 'name'))->order('name'), 'id');
        $publicher_id = $this->createElement('select', 'publicher_id');
        $publicher_id->addMultiOption(0, 'Не выбрано');
        $publicher_id->AddMultiOptions($options)
                   ->setRequired()
                   ->registerInArrayValidator();
        $publicher_id->setValue(0);
        
        $order= $this->createElement('text', 'order');
        $order->setLabel('order');
        
        $name_parallel= $this->createElement('text', 'name_parallel');
        $name_parallel->setLabel('параллельное имя');
        
        $note= $this->createElement('text', 'note');
        $note->setLabel('короткое имя');
        
        $issn= $this->createElement('text', 'issn');
        $issn->setLabel('короткое имя');
        
        $this->addElements(
            compact('id', 'name', 'publicher_id', 'order', 'name_parallel', 'note', 'issn'
        ));
        $this->addElements(Application_Form_Elements::getStandardButtons('seria'));
    }
}