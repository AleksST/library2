<?php

class LibraryController extends Zend_Controller_Action
{
    protected $_library;
    
    protected $_columns = array('name');


    public function init()
    {
        $this->_library = new Application_Model_DbTable_Library();
    }

    public function indexAction()
    {
         if($this->getRequest()->isPost()){
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_library->insert($inserted);
        }
        $this->view->libraries = $this->_library->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()){
            $row = $this->_library->getRow($id);
            $updated = $this->_getDiffColumns($row->toArray());
            $this->_library->edit($id, $updated);
        }
        
        $this->view->library = $this->_library->getRow($id);
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->checkDelete($id)){
               $this->del($id);
           }
       }
    }

    public function searchAction()
    {
        //if($this->getRequest()->isPost()){
            //$this->_columns[] = 'created';
            //$this->_columns[] = 'modified';
            $search = $this->_getColumnsFromRequest();
            $this->view->libraries = $this->_library->getByCondition($search);
                      
        //}
        
    }

    public function addAction()
    {
       $this->_redirect('index');
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









