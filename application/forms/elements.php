<?php
class Application_Form_Elements
{
    /**
     * 
     * Standard CRUD buttons for add, delete, update, search 
     * controller actions
     * @param string $name - controller name
     * @return array of Zend_Form_Element_Submit objs
     */
    public static function getStandardButtons($name = null)
    {
        $sufix = 'Btn';
        $buttons = array(
            'search' => 'Поиск', 
            'add'    => 'Добавить',
            'update' => 'Редактировать',
            'delete' => 'Удалить'
        );
        
        foreach ($buttons as $action => $label){
            $elem = new Zend_Form_Element_Submit($label, array('disableLoadDefaultDecorators' => true));
            $elem->setAttrib('formaction', "/$name/$action")
                    ->setDecorators(array(array('ViewHelper', 'Form')));
            $elements[ $action . $sufix ] = $elem;
        }

        return $elements;
    }

    /**
     * Standard hidden form element
     * @return obj Zend_Form_Element_Hidden
     * @param string $id - html element id
     */
    public static function getHidden($id = 'id')
    {
        $elem = new Zend_Form_Element_Hidden($id, array('disableLoadDefaultDecorators' => true));
        $elem->setDecorators(array(array('ViewHelper')));
        return $elem;
    }
    
    public static function getMultivalueElement($name, $label)
    {
        $text = new Zend_Form_Element_Text($name, array('disableLoadDefaultDecorators' => true));
        $text->setLabel($label)->setIsArray(true)->setDecorators(array(array('ViewHelper'),'Label'));
        
        $add = new Zend_Form_Element_Button('add' . ucfirst($name), array('disableLoadDefaultDecorators' => true));
        $add->setAttrib('type', 'button')->setLabel("+")
            ->setAttrib('onclick', self::getJsAddElement())
            ->setDecorators(array(array('ViewHelper')));
        
        $remove = new Zend_Form_Element_Button('remove' . ucfirst($name), array('disableLoadDefaultDecorators' => true));
        $remove->setAttrib('type', 'button')->setLabel("-")
            ->setAttrib('onclick', self::getJsRemoveElement())
            ->setDecorators(array(array('ViewHelper')));
        
        return array($name=>$text, 'add' . $name . 'Btn'=>$add, 'remove' . $name . 'Btn'=>$remove);
    }

    /**
     * 
     * Return form with headers fields
     * @param string $name - this fieldset html id
     * @return Zend_Form
     */
    public static function getFieldsetHeader($name)
    {
    
        $db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $header_types = $db->fetchAll($db->select()->from('header_type', array('id', 'name')));
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            'Form',
            'Fieldset'
        ));
        
        $form->setLegend('Заглавия');
        foreach ($header_types as $header_type){
            $form->addDisplayGroup(
                    self::getMultivalueElement('header_type_' . $header_type['id'], $header_type['name']), 
                    strtolower('header_type_' . $header_type['id']) .'Set',
                    array('disableLoadDefaultDecorators' => true, 
                          'id' => 'header_type_' . $header_type['id'] . 'Form'));
        }
        
        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
      //$form->addElements(self::getFieldsetButtons($name . 'Set'));
        
        return $form;
    }

    /**
     * 
     * Return form with editions fields
     * @param string $name - this fieldset html id
     * @return array of form elements
     */
    public static function getFieldsetEdition($name)
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            'Form',
            'Fieldset'
        ));
        
        $form->setLegend('Издание');
        $text = new Zend_Form_Element_Text($name, array('disableLoadDefaultDecorators' => true));
        $text->setLabel('Сведения об издании')
             ->setDecorators(array(array('ViewHelper'),'Label'));
        $form->addElement($text);
        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
        $form->addElements(self::getFieldsetButtons($name . 'Set'));
        
        return $form;
    }
    
    public static function getFieldsetAuthor()
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            'Form',
            'Fieldset'
        ));
        
        $form->setLegend('Заглавия'); 
        return $form;
    }

    /**
     * 
     * Return form with subforms
     * @param string $containerId - parent html id
     * @param string $name tab display name
     * @param array $feildsets - names of fieldset need to include into form (x)array('header', 'edition')
     * @return ZendX_JQuery_Form tab subform for container
     */
    public static function getTab($jqParams, $fieldsets = array(), $controllerName = '')
    {
        $form = new ZendX_JQuery_Form();
        $form->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'fieldset','class' => 'tab')),
            array('TabPane', array('jQueryParams' => $jqParams)),
            'Form'
        ));
        
        foreach ($fieldsets as $fieldsetName){
            $methodName = 'getFieldset' . ucfirst($fieldsetName); 
            if(method_exists('Application_Form_Elements', $methodName)){
                $form->addSubForm( self::$methodName($fieldsetName), $fieldsetName);
            }
        }
        
//        $form->setDisplayGroupDecorators(array('FormElements', 'Fieldset'));
        $form->addElements(self::getStandardButtons($controllerName));
        return $form;
    }

    /**
     * 
     * Return standard buttons for fieldset(subforms)
     * @param string $fieldsetName
     */
    public static function getFieldsetButtons($fieldsetName)
    {
        $add = new Zend_Form_Element_Button('add' . $fieldsetName, array('disableLoadDefaultDecorators' => true));
        $add->setAttrib('type', 'button')->setLabel("+")
            ->setAttrib('onclick', self::getJsAddFieldset($fieldsetName))
            ->setDecorators(array(array('ViewHelper')));
 
        $remove = new Zend_Form_Element_Button('remove' . $fieldsetName, array('disableLoadDefaultDecorators' => true));
        $remove->setAttrib('type', 'button')->setLabel('-')
            ->setAttrib('onclick', self::getJsRemoveFieldset())
            ->setDecorators(array(array('ViewHelper')));

        return compact('add', 'remove');
    }

    private static function getJsAddFieldset()
    {
        return 'fset = $(this).parents("fieldset").first(); fset.after(fset.clone());';
    }

    private static function getJsRemoveFieldset()
    {
        return '$(this).parents("fieldset").first().remove();';
    }
    
    private static function getJsAddElement()
    {
        return self::getJsAddFieldset();
    }
    
    private static function getJsRemoveElement()
    {
        return self::getJsRemoveFieldset();
    }
}