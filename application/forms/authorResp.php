<?php
class Application_Form_AuthorResp extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('author-resp');
        $this->setMethod('post');
        $this->setAction('/author-resp/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $name = $this->createElement('text', 'name');
        $name->setRequired()->setLabel('название ответственности')
             ->addErrorMessage('Обязательное поле');
        
        $cod = $this->createElement('text', 'cod');
        $cod->setLabel('код ответственности');
        
        $name_short = $this->createElement('text', 'name_short');
        $name_short->setLabel('сокращенная форма названия');
        
        $this->addElements(
            compact('id', 'name', 'name_short', 'cod'
        ));
        $this->addElements(Application_Form_Elements::getStandartButtons('author-resp'));
    }
}