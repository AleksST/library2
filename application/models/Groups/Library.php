<?php 
class Application_Model_Groups_Library
{
    
    public static function getGroup()
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            'Form',
            'Fieldset'
        ));
        $form->setLegend('Библиотека');
        
        $form->addElements(Application_Model_Elements_Library::getElements());
        
        $form->addSubForm(
            self::setGroup(
                Application_Model_Elements_Library::getElements(array('id', 'name', 'library'))), 
            'addr'
        );
        //$form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
//        $form->addElements(
//            Application_Model_Elements_Autocomplete::getElements('library_id', 'library_name' , 'библиотека')
//        );
        $form->addSubForm(
            self::setGroup(
             Application_Model_Elements_Autocomplete::getElements('library_id', 'library_name' , 'библиотека')),
             'library'
        );
        $form->addElements(self::getGroupButtons('librarySet'));
        
        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
        $form->setSubFormDecorators(array('FormElements', 'Fieldset'));
        
        return $form;
    }
      
    public static function getGroupButtons($fieldsetName, $fieldjs = true)
    {
        $add = new Zend_Form_Element_Button('add' . $fieldsetName
            ,array('disableLoadDefaultDecorators' => true)
        );
        $add->setAttrib('type', 'button')->setLabel("+")
            ->setAttrib('onclick', self::getJsAddFieldset($fieldsetName))
            ->setDecorators(array(array('ViewHelper')));
        if(!$fieldjs){
            $add->setAttrib('onclick', self::getJsAddGroup());
        }
 
        $remove = new Zend_Form_Element_Button('remove' . $fieldsetName
            ,array('disableLoadDefaultDecorators' => true)
        );
        $remove->setAttrib('type', 'button')->setLabel('-')
            ->setAttrib('onclick', self::getJsRemoveFieldset())
            ->setDecorators(array(array('ViewHelper')));
            
        return compact('add', 'remove');
    }
    
    public static function setGroup(array $elements)
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            'Form',
            'Fieldset'
        ));
        
        foreach ($elements as &$element) {
           $element->setIsArray(true);
        }
        
        $form->addElements($elements);
        $form->addElements(self::getGroupButtons('add_multi', false));
        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
        return $form;
    }
    
    private static function getJsAddGroup()
    {
        return 'fset = $(this).parents("fieldset").first(); fset.after(fset.clone());setAutocomplete()';
    }
    
    private static function getJsAddFieldset()
    {
        return 'clone_fieldset(this);';
    }

    private static function getJsRemoveFieldset()
    {
        return '$(this).parents("fieldset").first().remove();';
    }
}