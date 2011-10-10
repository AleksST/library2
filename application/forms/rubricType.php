<?php
class Application_Form_RubricType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('rubric-type');
        $this->setMethod('post');
        $this->setAction('/rubric-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название типа рубрики')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код поля типа рубрики по русмарк');
               
        $this->addElements(
            compact('id', 'name', 'cod'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('rubric-type'));
    }
}