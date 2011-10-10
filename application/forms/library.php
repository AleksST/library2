<?php

class Application_Form_Library extends ZendX_JQuery_Form
{
    public function __construct($options = null, $library = null) {
        parent::__construct($options);
        
        $this->setDecorators(array(
		    'FormElements', 
		    array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 600px;')),
		    'Form',
		));
        
        $this->setName('library');
        $this->setMethod('post');
        $this->setAction('/library/');
        $this->setAttrib('id', 'libraryForm');
        
		$form = new ZendX_JQuery_Form();
		$form->setDecorators(array(
		    'FormElements',
		    array('HtmlTag', array('tag' => 'dl')),
		    array('TabPane', array('jQueryParams' => array(
		        'containerId' => 'libraryForm',
		        'title' => 'Библиотека'
		    ))),
		    'Form'
		));
		
		$id = new Zend_Form_Element_Hidden('id');
		
		$name = new Zend_Form_Element_Text('name');
		$name->setLabel('Название: ')->setRequired();
		
		$name_short = new Zend_Form_Element_Text('name_short');
		$name_short->setLabel('Короткое имя: ');
		
		$address = new Zend_Form_Element_Text('address');
		$address->setLabel('Адрес: ');
		
		$note = new Zend_Form_Element_Textarea('note');
		$note->setLabel('Примечание: ')->setAttribs(array('cols'=>'60', 'rows'=> '3'));
		
		$form->addElements(array(
			$id, $name, $name_short, $address, $note));
        $form->addElements(Application_Form_Elements::getStandardButtons('library'));
		$this->addSubForm($form, 'subform');
    }
}