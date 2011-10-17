<?php

class Application_Model_Elements_Autocomplete 
{
    
    public static function getElements($hidden_id, $visible_id, $label, $JQueryParams = array())
    {
        $name = current(explode('_', $visible_id));
        
        $default = array(
            'source' => "/$name/autocomplete/",
            'select'=> new Zend_Json_Expr('function(event, ui){
                    $(":hidden[id$=\''.$hidden_id.'\']").val(ui.item.id);
                    '.$hidden_id.' = ui.item;}'));
        
        $JQueryParams = array_merge($JQueryParams, $default);

        $hidden = Application_Model_Elements_Hidden::getElement($hidden_id);
        
        $visible = new ZendX_JQuery_Form_Element_AutoComplete(
            $visible_id,
            array('JQueryParams' => $JQueryParams,
                'class' => 'library_complete')
        );
        $visible->setLabel($label);
        
        return array($hidden, $visible);
    }
}