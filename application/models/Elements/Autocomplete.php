<?php

class Application_Model_Elements_Autocomplete 
{
 
    public static function getElements($hidden_id, $visible_id, $label, $JQueryParams = array())
    {
//        $name = current(explode('_', $visible_id));
//        
//        $default = array(
//            'source' => "/$name/autocomplete/",
//            'select'=> new Zend_Json_Expr('function(event, ui){
//                    $(":hidden[id$=\''.$hidden_id.'\']").val(ui.item.id);
//                    '.$hidden_id.' = ui.item;}'));
        
//        $JQueryParams = array_merge($JQueryParams, $default);

        $hidden = Application_Model_Elements_Hidden::getElement($hidden_id);
        $visible = new Zend_Form_Element_Text($visible_id);
        $visible->setLabel($label);
        
        return array($hidden, $visible);
    }
}