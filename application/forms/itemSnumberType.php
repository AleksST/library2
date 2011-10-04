<?php
class Application_Form_ItemSnumberType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('item-snumber-type');
        $this->setMethod('post');
        $this->setAction('/item-snumber-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        
        $snumber_type_id = $this->createElement('text', 'snumber_type_id');
        $snumber_type_id->setLabel('id названия системного номера (ISBN) ')->setRequired()
        				->addErrorMessage('Обязательное поле');
        
        $type_id = $this->createElement('text', 'type_id');
        $type_id->setLabel('ID типа описания')->setRequired()
        		->addErrorMessage('Обязательное поле');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/item-snumber-type/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/item-snumber-type/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/item-snumber-type/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/item-snumber-type/add');
        
        $this->addElements(
            compact('id', 'snumber_type_id', 'type_id'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}