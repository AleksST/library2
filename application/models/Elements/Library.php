<?php
class Application_Model_Elements_Library
{
    public static function getElements()
    {
        $elements = array(
            'id'        => 'Id',
            'name'      => 'Name',
            'name_short'=> 'NameShort',
            'address'   => 'Address',
            'note'      => 'Note',
            'library'   => 'Autocomplete',
        );
        
        $out = array();
        foreach ($elements as $id=>$name){
            $method = 'get'.$name;
            if(method_exists('Application_Model_Elements_Library', $method))
            $out[$id] = self::$method();
        }
        
        return $out;
    }
    
    public static function getId()
    {
        return Application_Model_Elements_Hidden::getElement('id');
    }
    
    public static function getName()
    {
        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Название: ')
             ->setRequired(true);
        return $name;
    }
    
    public static function getNameShort()
    {
        $name_short = new Zend_Form_Element_Text('name_short');
        $name_short->setLabel('Короткое имя: ');
        return $name_short;
    }
    
    public static function getAddress()
    {
        $address = new Zend_Form_Element_Text('address');
        $address->setLabel('Адрес: ');
        return $address;
    }
    
    public static function getNote()
    {
        $note = new Zend_Form_Element_Textarea('note');
        $note->setLabel('Примечание: ')
             ->setAttribs(array('cols'=>'60', 'rows'=> '3'));
        return $note;
    }
    
}