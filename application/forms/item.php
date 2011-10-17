<?php
class Application_Form_Item extends ZendX_JQuery_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        
        $this->setDecorators(array(
            'FormElements', 
            array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 800px;')),
            'Form',
        ));
        
        $this->setName('item')
             ->setMethod('post')
             ->setAction('/item/')
             ->setAttrib('id', 'itemForm');
        
        //$this->getAttrib('id')
        $jqParams   = array('containerId' => 'itemForm', 'title' => 'поля');
        $fieldsets  = array('header', 'edition', 'author');
        
        $tab1 = Application_Form_Elements::getTab($jqParams, $fieldsets, 'item');
       
        //$this->addElements(Application_Form_Elements::getStandardButtons('item'));
        $this->addSubForm($tab1,'tab1');
    }
    
}