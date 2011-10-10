<?php
class Application_Form_Author extends Zend_Form
{
    public function __construct($options = null) {
        parent::__construct($options);
        
        $this->setName('author');
        $this->setMethod('post');
        $this->setAction('/author/');
        
        $id = new Zend_Form_Element_Hidden('id');
        
        $surname = $this->createElement('text', 'surname');
        $surname->setRequired()->setLabel('Фамилия')
             ->addErrorMessage('Обязательное поле');
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Имя');
        
        $patronymic = $this->createElement('text', 'patronymic');
        $patronymic->setLabel('отчество');
        
        $author_type_id = $this->createElement('text', 'author_type_id');
        $author_type_id->setLabel('тип автора (срп)');
        
        $authorsign_id = $this->createElement('text', 'authorsign_id');
        $authorsign_id->setLabel('авторский знак(спр)');
        
        $alternativename_id = $this->createElement('text', 'alternativename_id');
        $alternativename_id->setLabel('альтернативная форма имени');
        
        $initials = $this->createElement('text', 'initials');
        $initials->setLabel('Иинциалы');
        
        $additions = $this->createElement('text', 'additions');
        $additions->setLabel('Дополнения');
        
        $number = $this->createElement('text', 'number');
        $number->setLabel('Числа');
        
        $organization = $this->createElement('text', 'organization');
        $organization->setLabel('организация');
        
        $dates = $this->createElement('text', 'dates');
        $dates->setLabel('Даты');
        
        $this->addElements(
            compact('id', 'surname', 'name', 'patronymic',  'initials', 'author_type_id', 'authorsign_id'
                    ,'alternativename_id', 'additions', 'number', 'organization', 'dates'
        ));
        
        $this->addElements(Application_Form_Elements::getStandardButtons('author'));
    }
}