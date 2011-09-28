<?php
require_once 'AppController.php';
/**
 * AuthorController
 * 
 * @authorType Aleks S Tushin
 * @version 
 */

class AuthorTypeController extends AppController
{
    protected $_authorType;
    
    protected $_columns = array ( 'name', 'cod');

    public function init()
    {
        $this->_authorType = new Application_Model_DbTable_AuthorType();
        $this->_form = new Application_Form_AuthorType();
    }
    
    public function indexAction()
    {
       $this->view->authorTypes = $this->_authorType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_authorType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_authorType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->authorType = $this->_authorType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_authorType->checkDelete($id)){
               $this->_authorType->del($id);
           }
       }
       $this->_redirect('/authorType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->authorTypes = $this->_authorType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_authorType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}