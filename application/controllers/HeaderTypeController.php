<?php
require_once 'AppController.php';
/**
 * AuthorController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class HeaderTypeController extends AppController
{
    protected $_headerType;
    
    protected $_columns = array ( 'name', 'cod');

    public function init()
    {
        $this->_headerType = new Application_Model_DbTable_headerType();
        $this->_form = new Application_Form_headerType();
    }
    
    public function indexAction()
    {
       $this->view->headerTypes = $this->_headerType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_headerType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_headerType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->HeaderType = $this->_headerType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_headerType->checkDelete($id)){
               $this->_headerType->del($id);
           }
       }
       $this->_redirect('/headerType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->headerTypes = $this->_headerType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_headerType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}