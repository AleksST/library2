<?php
class Application_Form_AuthorType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('author-type');
        $this->setMethod('post');
        $this->setAction('/author-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название ответственности')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('первые 2 цифры поля по русмарк');
        
        $this->addElements(
            compact('id', 'name', 'cod'
        ));
        $this->addElements(Application_Form_Elements::getStandardButtons('author-type'));
    }
}