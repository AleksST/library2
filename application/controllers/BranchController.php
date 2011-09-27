<?php
require_once 'AppController.php';

class BranchController extends AppController
{
    protected $_branch;
    
    protected $_columns = array('name','library_id', 'address', 'short_name');


    public function init()
    {
        $this->_branch = new Application_Model_DbTable_Branch();
        $this->_form = new Application_Form_Branch();
    }

    public function indexAction()
    {
        $this->view->branches = $this->_branch->getAll();
        
        $libraries = array();
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
        // if enter edit form
        if($this->getRequest()->isPost()) {
            // if edit form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_branch->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_branch->edit($id, $updated);
            } else {
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->branch = $this->_branch->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->checkDelete($id)){
               $this->del($id);
           }
       }
       $this->_forward('index');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = $this->_getColumnsFromRequest();
            $this->view->branches = $this->_branch->getByCondition($search);         
        }
    }

    public function addAction()
    {
    	if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_branch->insert($inserted);
        }
        $this->_forward('index');
    }

}
