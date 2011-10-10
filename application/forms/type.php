<?php
class Application_Form_type extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('type');
        $this->setMethod('post');
        $this->setAction('/type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
        	 ->addErrorMessage('Обязательное поле');
                
        $this->addElements(
            compact('id', 'name'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('type'));
    }
}