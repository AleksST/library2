<?php
class Application_Form_SnumberType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('snumber-type');
        $this->setMethod('post');
        $this->setAction('/snumber-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название серийного номера')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код поля серийного номера по русмарк');
        
        $this->addElements(
            compact('id', 'name', 'cod'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('snumber-type'));
    }
}