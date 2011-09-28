<?php
class Application_Form_HeaderType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('headerType');
        $this->setMethod('post');
        $this->setAction('/headerType/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название заглавия')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код поля по русмарк');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/headerType/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/headerType/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/headerType/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/headerType/add');
        
        $this->addElements(
            compact('id', 'name', 'cod'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}