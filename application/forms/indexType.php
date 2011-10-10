<?php
class Application_Form_IndexType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('index-type');
        $this->setMethod('post');
        $this->setAction('/index-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название индекса')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код индекса по русмарк');
        
        $this->addElements(
            compact('id', 'name', 'cod'
        ));
        $this->addElements(Application_Form_Elements::getStandardButtons('index-type'));
    }
}