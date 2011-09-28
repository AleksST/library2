<?php
require_once 'AppController.php';
/**
 * RubricTypeController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class RubricTypeController extends AppController
{
    protected $_rubricType;
    
    protected $_columns = array ( 'name', 'cod');

    public function init()
    {
        $this->_rubricType = new Application_Model_DbTable_RubricType();
        $this->_form = new Application_Form_RubricType();
    }
    
    public function indexAction()
    {
       $this->view->rubricTypes = $this->_rubricType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_rubricType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_rubricType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->rubricType = $this->_rubricType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_rubricType->checkDelete($id)){
               $this->_rubricType->del($id);
           }
       }
       $this->_redirect('/rubricType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->rubricTypes = $this->_rubricType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_rubricType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}