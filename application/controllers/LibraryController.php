<?php
require_once 'AppController.php';
class LibraryController extends AppController
{
    protected $_library;
    protected $_columns = array('name', 'short_name', 'address', 'note');

    public function init()
    {
        $this->_library = new Application_Model_DbTable_Library();
        // after _forward() function don't rewrite $_form
        if(empty($this->view->library)) {
        	$this->_form = new Application_Form_Library();
        }
    }

    public function indexAction()
    {
        list($this->view->libraries, $this->view->branches) = $this->_library->getAll();
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
                $this->_form->populate();
            }
        }
        $this->view->library = $this->_library->getRow($id);
        $this->_form = new Application_Form_Library(null, $this->view->library);
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
            $search = $this->_getColumnsFromRequest();
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
    
    //@todo: bad style: rewrite it!
    public function autocompleteAction()
    {
    	$select = $this->_library->select();
    	
    	$select->where('name like (?)', $this->getRequest()->getParam('term') . '%')
    		   ->order('name');
    	$res = $this->_library->fetchAll($select)->toArray();
    	foreach ($res as $i=>$row){
    		$res2[$i]['value'] = $row['name'];
    		$res2[$i]['id'] = $row['id'];
    	}
    	echo Zend_Json::encode($res2);exit;
    }

}

