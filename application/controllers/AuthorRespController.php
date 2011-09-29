<?php
require_once 'AppController.php';
/**
 * AuthorRespController 
 * Author's responsibility
 * 
 * @author Aleks S Tushin
 * @version 
 */

class AuthorRespController extends AppController
{
    protected $_authorResp;
    
    protected $_columns = array ( 'name', 'cod', 'name_short');

    public function init()
    {
        $this->_authorResp = new Application_Model_DbTable_AuthorResp();
        $this->_form = new Application_Form_AuthorResp();
    }
    
    public function indexAction()
    {
       $this->view->authorResps = $this->_authorResp->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_authorResp->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_authorResp->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->authorResp = $this->_authorResp->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_authorResp->checkDelete($id)){
               $this->_authorResp->del($id);
           }
       }
       $this->_redirect('/authorResp/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->authorResps = $this->_authorResp->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_authorResp->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}