<?php
class Application_Form_LanguageType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('language-type');
        $this->setMethod('post');
        $this->setAction('/language-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('Название яызкового поля')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код по русмарк');
  		 
        $this->addElements(
            compact('id', 'name', 'cod'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('language-type'));
    }
}