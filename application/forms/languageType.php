<?php
class Application_Form_LanguageType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('languageType');
        $this->setMethod('post');
        $this->setAction('/languageType/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('Название яызкового поля')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код по русмарк');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/languageType/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/languageType/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/languageType/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/languageType/add');
        
        $this->addElements(
            compact('id', 'name', 'cod'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}