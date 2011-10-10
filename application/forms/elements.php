<?php
class Application_Form_Elements
{
	/**
	 * 
	 * Standart CRUD buttons for add, delete, update, search 
	 * controller actions
	 * @param string $name - controller name
	 * @return array of Zend_Form_Element_Submit objs
	 */
	public static function getStandardButtons($name = null)
	{
		// @todo: set decarators to display buttons inline with known sizes
		$searchBtn = new Zend_Form_Element_Submit('Поиск');
        $searchBtn->setAttrib('formaction', "/$name/search");
        
        $deleteBtn = new Zend_Form_Element_Submit('Удалить');
        $deleteBtn->setAttrib('formaction', "/$name/delete");
        
        $editBtn = new Zend_Form_Element_Submit('Редактировать');
        $editBtn->setAttrib('formaction', "/$name/update");
        
        $addBtn = new Zend_Form_Element_Submit('Добавить');
        $addBtn->setAttrib('formaction', "/$name/add");
        
        return compact('searchBtn', 'deleteBtn', 'editBtn', 'addBtn');
	}
	
	/**
	 * Standart hidden form element
	 * @return obj Zend_Form_Element_Hidden
	 * @param string $id - html element id
	 */
	public static function getHidden($id = 'id')
	{
		$elem = new Zend_Form_Element_Hidden($id);
//		$elem->setDisableLoadDefaultDecorators(true);
//		$elem->removeDecorator('DtDtWrapper');	
//		$elem->removeDecorator('HtmlTag');
//		$elem->removeDecorator('Label');
		return $elem;
	}

	
}