<?php
class Application_Model_Elements_Hidden
{
    public static function getElement($id = 'id')
    {
        $hidden = new Zend_Form_Element_Hidden($id, array('disableLoadDefaultDecorators'=>true));
        $hidden->setDecorators(array(array('ViewHelper')));
        return $hidden;
    }
}