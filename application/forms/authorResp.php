<?php
class Application_Form_AuthorResp extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('authorResp');
        $this->setMethod('post');
        $this->setAction('/authorResp/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название ответственности')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код ответственности');
        
        $name_short = $this->createElement('text', 'name_short');
        $name_short->setLabel('сокращенная форма названия');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/authorResp/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/authorResp/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/authorResp/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/authorResp/add');
        
        $this->addElements(
            compact('id', 'name', 'name_short', 'cod'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}