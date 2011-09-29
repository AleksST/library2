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
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/authorsign/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/authorsign/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/authorsign/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/authorsign/add');
        
        $this->addElements(
            compact('id', 'name', 'sign'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}