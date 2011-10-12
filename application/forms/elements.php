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
		return $elem;
	}

	/**
	 * 
	 * Return form with headers fields
	 * @param string $containerId - parent container html id
	 * @param string $name - this fieldset html id
	 */
	public function getFieldsetHeader($containerId, $name)
	{
		$form = new ZendX_JQuery_Form();
		$form_id = 'header_set';
		$form->setDecorators(array(
		    'FormElements',
		    array('HtmlTag', array('tag' => 'fieldset','id' => 'header_set', 'label'=>'Заглавия')),
		    'Form'
		));
		
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        $header_types = $db->fetchAll($db->select()->from('header_type', array('id', 'name')));
        
        foreach ($header_types as $header_type){
        	// set as array (header_type[])
        	$text = new Zend_Form_Element_Text('header_type' . $header_type['id']);
        	$text->setLabel($header_type['name']);
        	$form->addElement($text);
        }
       	
       	$form->addElements(self::getFieldsetButtons('HeaderSet', 'header_set'));
       	return $form;
	}
	
	/**
	 * 
	 * Return form with editions fields
	 * @param string $containerId - parent container html id
	 * @param string $name - this fieldset html id
	 */
	public static function getFieldsetEdition($containerId, $name)
	{
		$form = new ZendX_JQuery_Form();
		$form->setDecorators(array(
		    'FormElements',
		    array('HtmlTag', array('tag' => 'fieldset','id' => 'edition', 'label'=>'Издания')),
		    'Form'
		));
		
		$db = Zend_Db_Table_Abstract::getDefaultAdapter();
        //@todo rewrite for editions: temp for test
		$editions = $db->fetchAll($db->select()->from('header_type', array('id', 'name')));
        
        foreach ($editions as $edition){
        	$text = new Zend_Form_Element_Text('edition');
        	$text->setLabel('Издание');
        	$form->addElement($text);
        }
        
       	$form->addElements(self::getFieldsetButtons('EditionSet', 'edition'));
        return $form;
	}
	
	/**
	 * 
	 * Return form with subforms
	 * @param string $containerId - parent html id
	 * @param string $name this form name
	 * @param array $feildsets - names of fieldset need to include into this form
	 */
	public static function getTab($containerId, $name, $fieldsets = array())
	{
		$fieldsets = array('header', 'edition');
		$form = new ZendX_JQuery_Form();
		$form->setDecorators(array(
		    'FormElements',
		    array('HtmlTag', array('tag' => 'fieldset','class' => 'tab', 'label'=>'tab::')),
		    array('TabPane', array('jQueryParams' => array(
		        'containerId' => $containerId,
		        'title' => $name
		    ))),
		    'Form'
		));
		
		// @todo: second form has <form> html tsg. why ??
		foreach ($fieldsets as $fieldsetName){
			$methodName = 'getFieldset' . ucfirst($fieldsetName); 
			//if(method_exist(self::$methodName)){
			$form->addSubForm(self::$methodName('', ''), strtolower($fieldsetName) .'Set');
			//}
		}
		
		return $form;
	}
	
	/**
	 * 
	 * Return standard buttons for fieldset(subforms)
	 * @param string $fieldsetName
	 * @param string $fieldsetId
	 */
	public static function getFieldsetButtons($fieldsetName, $fieldsetId)
	{
		$add = new Zend_Form_Element_Button('add' . $fieldsetName);
        $add->setAttrib('type', 'button')->setLabel("+")
        	->setAttrib('onclick', self::getJsAddFieldset($fieldsetId));
        
        $remove = new Zend_Form_Element_Button('remove' . $fieldsetName);
        $remove->setAttrib('type', 'button')->setLabel('_')
        	->setAttrib('onclick', self::getJsRemoveFieldset());
		
        return compact('add', 'remove');
	}
	
	private static function getJsAddFieldset($fieldsetId)
	{
			return 'var val=1;
		    $("fieldset[id^='. $fieldsetId .']").each(function(){
		    	id  = parseInt(this.id.substring(this.id.lastIndexOf("_")+1)); 
		    	val = Math.max(val,parseInt(id)+1);
			});
			var fieldset_id = "' . $fieldsetId . '";
			if(val > 1) {fieldset_id = "' . $fieldsetId . '_" + id;}
		    $("#"+fieldset_id).after($("#' . $fieldsetId . '").clone().attr("id", "' . $fieldsetId . '_"+val));
		    ';
	}
	
	private static function getJsRemoveFieldset()
	{
		return '$(this).parent().parent().remove();';
	}
}