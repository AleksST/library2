<?php
class Application_Form_ItemSnumberType extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('item-snumber-type');
        $this->setMethod('post');
        $this->setAction('/item-snumber-type/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        
        $snumber_type_id = $this->createElement('text', 'snumber_type_id');
        $snumber_type_id->setLabel('id названия системного номера (ISBN) ')->setRequired()
        				->addErrorMessage('Обязательное поле');
        
        $type_id = $this->createElement('text', 'type_id');
        $type_id->setLabel('ID типа описания')->setRequired()
        		->addErrorMessage('Обязательное поле');
    
        $this->addElements(
            compact('id', 'snumber_type_id', 'type_id'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('item-snumber-type'));
    }
}