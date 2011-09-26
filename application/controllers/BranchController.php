<?php

class BranchController extends Zend_Controller_Action
{
    protected $_branch;
    
    protected $_columns = array('name','library_id');


    public function init()
    {
        $this->_branch = new Application_Model_DbTable_Branch();
    }

    public function indexAction()
    {
         if($this->getRequest()->isPost()){
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_branch->insert($inserted);
        }
        $this->view->branches = $this->_branch->getAll();
        
        foreach ($this->view->branches as $branch){
        	$libraries[$branch->id] = $this->_branch->getLibrary($branch);
        }
        $this->view->libraries = $libraries;
        
        // assignment here
        if($libraryId = $this->getRequest()->getParam('library_id')){
        	$this->view->library = $this->_branch->getLibraryById($libraryId);        	
        }
    }
	
    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()){
            $row = $this->_branch->getRow($id);
            $updated = $this->_getDiffColumns($row->toArray());
            $this->_branch->edit($id, $updated);
        }
        
        $this->view->branch = $this->_branch->getRow($id);
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
        if($this->getRequest()->isPost()){
            //$this->_columns[] = 'created';
            //$this->_columns[] = 'modified';
            $search = $this->_getColumnsFromRequest();
            $this->view->branches = $this->_branch->getByCondition($search);
                      
        }
        
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
