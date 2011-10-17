<?php
class Application_Form_Thesaurus extends ZendX_JQuery_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('thesaurus')
            ->setMethod('post')
            ->setAction('/thesaurus/')
            ->setAttrib('id', 'thesaurusForm');
        
        $this->setDecorators(array(
            'FormElements', 
            array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 800px;')),
            'Form',
        ));
        
        $jqParams   = array('containerId' => 'thesaurusForm', 'title' => 'Тезаурус');
       
        $tab1 = self::getTab($jqParams, 'thesaurus');
        $this->addSubForm($tab1,'tab1');
    }
    
    public static function getStandardElements()
    {
        $id = Application_Form_Elements::getHidden('id');
        
        $name = new Zend_Form_Element_Text('name');
        $name->setRequired()->setLabel('Тезаурус')
        	 ->addErrorMessage('Обязательное поле');
        
        return array($id, $name);
    }
    
    public static function getTab($jqParams, $controllerName)
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'fieldset','class' => 'tab')),
            array('TabPane', array('jQueryParams' => $jqParams)),
            'Form'
        ));
        
        $form->addElements(self::getStandardElements());
        $form->addElements(Application_Form_Elements::getStandardButtons($controllerName));
        return $form;
    }
}