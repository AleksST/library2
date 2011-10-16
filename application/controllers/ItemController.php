<?php
require_once 'AppController.php';
/**
 * ItemController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class ItemController extends AppController
{
    protected $_item;
    
    protected $_columns = array ('type_id');


    public function init()
    {
        $this->_item = new Application_Model_DbTable_Item();
        $this->_form = new Application_Form_Item();
    }
    
    public function indexAction()
    {
       $this->view->items = $this->_item->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_item->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_item->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->item = $this->_item->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_item->checkDelete($id)){
               $this->_item->del($id);
           }
       }
       $this->_redirect('/item/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_request->getParams(), array('',null));
            $this->view->items = $this->_item->getByCondition($search);
        }
        
        Zend_Debug::dump($this->_request->getParams());
        Zend_Debug::dump($search);
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_item->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}