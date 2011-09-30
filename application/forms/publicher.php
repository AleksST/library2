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
        
    
        $address = $this->createElement('text', 'address');
        $address->setLabel('Дополнения');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/publisher/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/publisher/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/publisher/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/publisher/add');
        
        $this->addElements(
            compact('id', 'name', 'address'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}