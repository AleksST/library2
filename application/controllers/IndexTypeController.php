<?php
require_once 'AppController.php';
/**
 * IndexTypeController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class IndexTypeController extends AppController
{
    protected $_indexType;
    
    protected $_columns = array ( 'name', 'cod', 'edition', 'sys_cod');

    public function init()
    {
        $this->_indexType = new Application_Model_DbTable_IndexType();
        $this->_form = new Application_Form_IndexType();
    }
    
    public function indexAction()
    {
       $this->view->indexTypes = $this->_indexType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_indexType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_indexType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->indexType = $this->_indexType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_indexType->checkDelete($id)){
               $this->_indexType->del($id);
           }
       }
       $this->_redirect('/indexType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->indexTypes = $this->_indexType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_indexType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}