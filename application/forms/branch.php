<?php
class Application_Form_Branch extends ZendX_JQuery_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $this->setDecorators(array(
		    'FormElements', 
		    array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 600px;')),
		    'Form',
		));
        
        $this->setName('branch');
        $this->setMethod('post');
        $this->setAction('/branch/');
        $this->setAttrib('id', 'branchForm');
        
		$form = new ZendX_JQuery_Form();
		$form->setDecorators(array(
		    'FormElements',
		    array('HtmlTag', array('tag' => 'dl')),
		    array('TabPane', array('jQueryParams' => array(
		        'containerId' => 'branchForm',
		        'title' => 'Филиал'
		    ))),
		    'Form'
		));
		
		$id = Application_Form_Elements::getHidden('id');
		
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('Название')
        	 ->addErrorMessage('Обязательное поле');

        $library_id = new Zend_Form_Element_Hidden('library_id');
        	 
        $library_name = new ZendX_JQuery_Form_Element_AutoComplete(
                'library_name',
                array('JQueryParams' => array( 
                	'source' => '/library/autocomplete/',
                	'select'=> new Zend_Json_Expr('function(event, ui){
                		$("#library_id").val(ui.item.id);
                		library = ui.item;
    				}')
                ))
                
        );
        $library_name->setLabel('Библиотека');
        
        $name_short = new Zend_Form_Element_Text('name_short');
		$name_short->setLabel('Короткое имя: ');
		
		$address = new Zend_Form_Element_Text('address');
		$address->setLabel('Адрес: ');
        
        $form->addElements(
            compact('id', 'name', 'library_name', 'library_id', 'address', 'short_name', 'note'
        ));
        
        $form->addElements(Application_Form_Elements::getStandardButtons('branch'));

        $this->addSubForm($form, 'subform');
    }
}