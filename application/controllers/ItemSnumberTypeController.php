<?php
require_once 'AppController.php';
/**
 * ItemSnumberController
 * 
 * @itemSnumberType Aleks S Tushin
 * @version 
 */

class ItemSnumberTypeController extends AppController
{
    protected $_itemSnumberType;
    
    protected $_columns = array ( 'snumber_type_id', 'type_id');

    public function init()
    {
        $this->_itemSnumberType = new Application_Model_DbTable_ItemSnumberType();
        $this->_form = new Application_Form_ItemSnumberType();
    }
    
    public function indexAction()
    {
       $this->view->itemSnumberTypes = $this->_itemSnumberType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_itemSnumberType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_itemSnumberType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->itemSnumberType = $this->_itemSnumberType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_itemSnumberType->checkDelete($id)){
               $this->_itemSnumberType->del($id);
           }
       }
       $this->_redirect('/itemSnumberType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->itemSnumberTypes = $this->_itemSnumberType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_itemSnumberType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}