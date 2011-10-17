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
        $form->addElements(
                Application_Model_Elements_Autocomplete::getElements('library_id', 'library_name' , 'библиотека'));
        $form->addElements(self::getGroupButtons('librarySet'));
        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
        
        return $form;
    }
    
  
    
    public static function getGroupButtons($fieldsetName)
    {
        $add = new Zend_Form_Element_Button('add' . $fieldsetName, 
                array('disableLoadDefaultDecorators' => true));
        $add->setAttrib('type', 'button')->setLabel("+")
            ->setAttrib('onclick', self::getJsAddFieldset($fieldsetName))
            ->setDecorators(array(array('ViewHelper')));
 
        $remove = new Zend_Form_Element_Button('remove' . $fieldsetName,
                array('disableLoadDefaultDecorators' => true));
        $remove->setAttrib('type', 'button')->setLabel('-')
            ->setAttrib('onclick', self::getJsRemoveFieldset())
            ->setDecorators(array(array('ViewHelper')));

        return compact('add', 'remove');
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