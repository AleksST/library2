<?php
class Application_Form_NoteType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('note-type');
        $this->setMethod('post');
        $this->setAction('/note-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название примечания')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код поля по русмарк');
        
        $this->addElements(
            compact('id', 'name', 'cod'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('note-type'));
    }
}