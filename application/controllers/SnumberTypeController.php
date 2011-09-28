<?php
require_once 'AppController.php';
/**
 * SnumberTypeController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class SnumberTypeController extends AppController
{
    protected $_snumberType;
    
    protected $_columns = array ( 'name', 'cod');

    public function init()
    {
        $this->_snumberType = new Application_Model_DbTable_SnumberType();
        $this->_form = new Application_Form_SnumberType();
    }
    
    public function indexAction()
    {
       $this->view->snumberTypes = $this->_snumberType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_snumberType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_snumberType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->snumberType = $this->_snumberType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_snumberType->checkDelete($id)){
               $this->_snumberType->del($id);
           }
       }
       $this->_redirect('/snumberType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->snumberTypes = $this->_snumberType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_snumberType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}