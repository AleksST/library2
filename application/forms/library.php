<?php

class Application_Form_Library extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        $this->setName('library');
        $this->setMethod('post');
        $this->setAction('/library/');
        
        $id = new Zend_Form_Element_Hidden('id');
        $name = $this->createElement('text', 'name');
        $name->setRequired(true)->setLabel('name');
        
        $address = $this->createElement('text', 'address');
        $address->setLabel('address');
        
        $short_name = $this->createElement('text', 'short_name');
        $short_name->setLabel('короткое имя');
        
        $note = $this->createElement('text', 'note');
        $note->setLabel('note');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/library/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/library/delete');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        
        $this->addElements(
            compact('id', 'name', 'address', 'short_name', 'note'
                    , 'searchBtn' , 'addBtn', 'deleteBtn'
        ));
    }
}