<?php

class LibraryController extends Zend_Controller_Action
{
    protected $_library;
    protected $_form;
    
    protected $_columns = array('name', 'short_name', 'address', 'note');


    public function init()
    {
        $this->_library = new Application_Model_DbTable_Library();
        $this->_form = new Application_Form_Library();
    }

    public function indexAction()
    {
        $this->view->libraries = $this->_library->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
        	// if form submit
	        if($this->_form->isValid($this->_request->getParams())) {
	            $row = $this->_library->getRow($id);
	            $updated = $this->_getDiffColumns($row->toArray());
	            $this->_library->edit($id, $updated);
	        } else { 
	        	$this->view->errors = $this->_form->getErrors();
	        }
        }
        $this->view->library = $this->_library->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_library->checkDelete($id)){
               $this->_library->del($id);
           }
       }
       $this->_redirect('/library/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            // only columns defined in $_columns and not empty
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->libraries = $this->_library->getByCondition($search);
        }
        
    }

    public function addAction()
    {
    	if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_library->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }
    
	public function postDispatch() 
	{
		 $this->view->form = $this->_form;
	}
    
    protected function _getDiffColumns($row)
    {
        if(! is_array($this->_columns)) {
            return false;
    	}
      	// return array from request wich keys correspond $_columns
        $diff = array_diff($this->_getAllParams(), $row);
        return array_intersect_key($diff, array_flip($this->_columns));
    }
    
    protected function _getColumnsFromRequest()
    {
        return array_intersect_key($this->_getAllParams(), array_flip($this->_columns));
    }


}









