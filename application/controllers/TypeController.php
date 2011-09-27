<?php
require_once 'AppController.php';
/**
 * TypeController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class TypeController extends AppController
{
    protected $_type;
    
    protected $_columns = array ('name');


    public function init()
    {
        $this->_type = new Application_Model_DbTable_Type();
        $this->_form = new Application_Form_Type();
    }
    
    public function indexAction()
    {
       $this->view->types = $this->_type->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_type->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_type->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->type = $this->_type->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_type->checkDelete($id)){
               $this->_type->del($id);
           }
       }
       $this->_redirect('/type/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->types = $this->_type->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_type->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}