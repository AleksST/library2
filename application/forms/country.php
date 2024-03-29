<?php
class Application_Form_Country extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('country');
        $this->setMethod('post');
        $this->setAction('/country/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('name')
        	 ->addErrorMessage('Обязательное поле');
        
        $name_short = $this->createElement('text', 'name_short');
        $name_short->setLabel('короткое имя');
        
        $iso2 = $this->createElement('text', 'iso2');
        $iso2->setLabel('код ISO 2 символа')
             ->setValidators(array(new Zend_Validate_StringLength(2)))
             ->addErrorMessage('Код должен быть 2хсимвольным');
        
        $iso3 = $this->createElement('text', 'iso3');
        $iso3->setLabel('код ISO 3 символа')
             ->setValidators(array(new Zend_Validate_StringLength(3)))
             ->addErrorMessage('Код должен быть 3хсимвольным');
        
        $this->addElements(
            compact('id', 'name', 'name_short', 'iso2', 'iso3'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('country'));
    }
}