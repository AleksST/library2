<?php
class Application_Form_Authorsign extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('authorsign');
        $this->setMethod('post');
        $this->setAction('/authorsign/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('начало фамилии/названия')
             ->addErrorMessage('Обязательное поле');
        
        $sign = $this->createElement('text', 'sign');
        $sign->setLabel('авторский знак');
       
        $this->addElements(
            compact('id', 'name', 'sign'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('authorsign'));
    }
}