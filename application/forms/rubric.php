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
                'title' => 'Филиал'
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
        
        $thesaurus_id = Application_Form_Elements::getHidden('thesaurus_id');
        
        // js cod here use var "library" in views/scripts/branch/index.phtml
        $thesaurus_name = new ZendX_JQuery_Form_Element_AutoComplete(
            'thesaurus_name',
            array('JQueryParams' => array( 
                'source' => '/thesaurus/autocomplete/',
                'select'=> new Zend_Json_Expr('function(event, ui){
                    $("#thesaurus_id").val(ui.item.id);
                    thesaurus = ui.item;}')
            ))
        );
        $thesaurus_name->setLabel('Тезаурус');
         
        $name = new Zend_Form_Element_Text('name');
        $name->setRequired()->setLabel('Название')
             ->addErrorMessage('Обязательное поле');
        
        $rubric_type_id = new Zend_Form_Element_Text('rubric_type_id');
        $rubric_type_id->setLabel('тип рубрики (срп)');
        
        $alternative_id = new Zend_Form_Element_Text('alternative_id');
        $alternative_id->setLabel('альтернативная форма имени');
        
        $parent_id = new Zend_Form_Element_Text('parent_id');
        $parent_id->setLabel('родительская рубрика');
        
        $note = new Zend_Form_Element_Text('note');
        $note->setLabel('замечание');
        
        return compact('id', 'name', 'rubric_type_id', 'thesaurus_id', 'thesaurus_name'
                    ,'alternative_id', 'parent_id', 'note');
    }
}