<?php
class Application_Form_Branch extends ZendX_JQuery_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setDecorators(array(
            'FormElements', 
            array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 600px;')),
            'Form',
        ));
        
        $this->setName('branch')
             ->setMethod('post')
             ->setAction('/branch/')
             ->setAttrib('id', 'branchForm');
        
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
		
	    // add standard form elements        
        $form->addElements(self::getStandardElements());
        
        $form->addDisplayGroup(
                    Application_Form_Elements::getMultivalueElement('short_name', 'Короткое имя'), 
                    'short_name_group',
                    array('disableLoadDefaultDecorators' => true));
        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
        
        // add standard buttons
        $form->addElements(Application_Form_Elements::getStandardButtons('branch'));
        
        $this->addSubForm($form, 'subform');
        
        //@todo this for test
        $jqParams   = array('containerId' => 'branchForm', 'title' => 'Вкладка');
        $fieldsets  = array('header', 'edition');
        $controllerName = 'branch';
        $this->addSubForm(
                Application_Form_Elements::getTab($jqParams, $fieldsets, $controllerName), 
                'subform2'
        );
    }
    
    public static function getStandardElements()
    {
        $id = Application_Form_Elements::getHidden('id');
		
        $name = new Zend_Form_Element_Text('name');
        $name->setRequired()
             ->setLabel('Название')
        	 ->addErrorMessage('Обязательное поле');

        $library_id = Application_Form_Elements::getHidden('library_id');
        
        // js cod here use var "library" in views/scripts/branch/index.phtml
        $library_name = new ZendX_JQuery_Form_Element_AutoComplete(
            'library_name',
            array('JQueryParams' => array( 
                'source' => '/library/autocomplete/',
                'select'=> new Zend_Json_Expr('function(event, ui){
                    $("#library_id").val(ui.item.id);
                    library = ui.item;}')
            ))
        );
        $library_name->setLabel('Библиотека');

        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Адрес: ');
        
        return compact('id', 'name', 'library_name', 'library_id', 'address');
    }
}