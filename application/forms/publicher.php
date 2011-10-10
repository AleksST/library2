<?php
class Application_Form_Publisher extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('publisher');
        $this->setMethod('post');
        $this->setAction('/publisher/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('Фамилия')
             ->addErrorMessage('Обязательное поле');
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Имя');
        
        $this->addElements(
            compact('id', 'name', 'address'
        ));
        $this->addElements(Application_Form_Elements::getStandardButtons('publisher'));
    }
}