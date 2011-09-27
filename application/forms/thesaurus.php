<?php
class Application_Form_thesaurus extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('thesaurus');
        $this->setMethod('post');
        $this->setAction('/thesaurus/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
        	 ->addErrorMessage('Обязательное поле');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/thesaurus/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/thesaurus/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/thesaurus/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/thesaurus/add');
        
        $this->addElements(
            compact('id', 'name'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}