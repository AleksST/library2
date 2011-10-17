<?php
class Application_Form_Rubric extends ZendX_JQuery_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setDecorators(array(
            'FormElements', 
            array('TabContainer', array('id' => 'TabContainer', 'style' => 'width: 600px;')),
            'Form',
        ));
        
        $this->setName('rubric')
            ->setMethod('post')
            ->setAction('/rubric/')
            ->setAttrib('id', 'rubricForm');
        
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl')),
            array('TabPane', array('jQueryParams' => array(
                'containerId' => 'rubricForm',
                'title' => 'Рубрика'
            ))),
            'Form'
        ));
        
        $form->addElements(self::getStandatdElements());
        
        $form->addElements(Application_Form_Elements::getStandardButtons('rubric'));
        
        $this->addSubForm($form, 'rubric');
    }
    
    public static function getStandatdElements()
    {
        $id = Application_Form_Elements::getHidden('id');
        
        list($thesaurus_id, $thesaurus_name) = Application_Form_Elements
              ::getAutocompleteElement('thesaurus_id', 'thesaurus_name', 'thesaurus', 'Тезаурус');
         
        $name = new Zend_Form_Element_Text('name');
        $name->setRequired()->setLabel('Название')
             ->addErrorMessage('Обязательное поле');
        
        $rubric_type_id = new Zend_Form_Element_Text('rubric_type_id');
        $rubric_type_id->setLabel('тип рубрики (срп)');
        
        list($alternative_id, $alternative_name) = Application_Form_Elements
             ::getAutocompleteElement('alternative_id', 'alternative_name', 'rubric', 'Альтернативная рубрика');
        list($parent_id, $parent_name) = Application_Form_Elements
             ::getAutocompleteElement('parent_id', 'parent_name', 'rubric', 'Родительская рубрика');
        
        $note = new Zend_Form_Element_Text('note');
        $note->setLabel('замечание');
        
        return compact('id', 'name', 'parent_id', 'parent_name', 'rubric_type_id', 
             'thesaurus_id', 'thesaurus_name' ,'alternative_id', 'alternative_name', 'note');
    }
}