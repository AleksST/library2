<?php
class Application_Model_Forms_Library extends ZendX_JQuery_Form
{
    public function init($options = null, $library = null) {
        parent::init();
        
        $this->setName('library')
             ->setMethod('post')
             ->setAction('/library/')
             ->setAttrib('id', 'libraryForm');
        
        $this->setDecorators(array(
            'FormElements', 
            array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 700px;')),
            'Form',
        ));
        $this->setIsArray(true);
        
        $this->addSubForm(self::getTab($this->getAttrib('id')), 'library');
    }
    
    // возвращает форму для закладки или всплывающего окна
    public static function getForm($containerId = '')
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl')),
            'Form'
        ));
        
        $form->addSubForm(Application_Model_Groups_Library::getGroup(), 'library_0');
        $form->addElements(Application_Form_Elements::getStandardButtons('library'));
        $form->setElementsBelongTo('lib[0]');
        
        return $form;
    }
    
    // формирование формы для справочника
    public static function getTab($containerId)
    {
        $form = self::getForm($containerId);
        $form->addDecorator('TabPane', 
              array('jQueryParams' => array(
                'containerId' => $containerId,
                'title' => 'Библиотека'
            )));
        return $form;
    }
}