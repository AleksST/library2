<?php
class Application_Form_Rubric extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('rubric');
        $this->setMethod('post');
        $this->setAction('/rubric/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('Название')
             ->addErrorMessage('Обязательное поле');
        
        $rubric_type_id = $this->createElement('text', 'rubric_type_id');
        $rubric_type_id->setLabel('тип рубрики (срп)');
        
        $thesaurus_id = $this->createElement('text', 'thesaurus_id');
        $thesaurus_id->setLabel('тезаурус');
        
        $alternative_id = $this->createElement('text', 'alternative_id');
        $alternative_id->setLabel('альтернативная форма имени');
        
        $parent_id = $this->createElement('text', 'parent_id');
        $parent_id->setLabel('родительская рубрика');
        
        $note = $this->createElement('text', 'note');
        $note->setLabel('замечание');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/rubric/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/rubric/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/rubric/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/rubric/add');
        
        $this->addElements(
            compact('id', 'name', 'rubric_type_id', 'thesaurus_id'
                    ,'alternative_id', 'parent_id', 'note'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}