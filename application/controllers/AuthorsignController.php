<?php
require_once 'AppController.php';
/**
 * AuthorsignController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class AuthorsignController extends AppController
{
    protected $_authorsign;
    
    protected $_columns = array ( 'name', 'sign');

    public function init()
    {
        $this->_authorsign = new Application_Model_DbTable_Authorsign();
        $this->_form = new Application_Form_Authorsign();
    }
    
    public function indexAction()
    {
       $this->view->authorsigns = $this->_authorsign->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_authorsign->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_authorsign->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->authorsign = $this->_authorsign->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_authorsign->checkDelete($id)){
               $this->_authorsign->del($id);
           }
       }
       $this->_redirect('/authorsign/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->authorsigns = $this->_authorsign->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_authorsign->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}