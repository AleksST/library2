<?php
class Application_Form_Branch extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('branch');
        $this->setMethod('post');
        $this->setAction('/branch/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
        	 ->addErrorMessage('Обязательное поле');
       	
	$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $options = $db->fetchPairs($db->select()->from('library', array('id', 'name'))->order('name'), 'id');
        $library_id = $this->createElement('select', 'library_id');
        $library_id->addMultiOption(0, 'Не выбрано');
        $library_id->AddMultiOptions($options)
                   ->setRequired()
                   ->registerInArrayValidator();
        $library_id->setValue(0);
        
        $address = $this->createElement('text', 'address');
        $address->setLabel('address');
        
        $short_name = $this->createElement('text', 'short_name');
        $short_name->setLabel('короткое имя');
        
        $searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', '/branch/search');
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', '/branch/delete');
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', '/branch/update');
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', '/branch/add');
        
        $this->addElements(
            compact('id', 'name', 'library_id', 'address', 'short_name', 'note'
                    ,'searchBtn' , 'addBtn', 'editBtn',  'deleteBtn'
        ));
    }
}