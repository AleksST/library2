<?php
class Application_Form_RelationType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('relation-type');
        $this->setMethod('post');
        $this->setAction('/relation-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название типа связи')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код поля связи по русмарк');
        
        $opposite_cod = $this->createElement('text', 'opposite_cod');
        $opposite_cod->setLabel('код обратной связи по русмарк');
                
        $this->addElements(
            compact('id', 'name', 'cod', 'opposite_cod'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('relation-type'));
    }
}