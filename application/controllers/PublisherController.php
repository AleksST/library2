<?php
require_once 'AppController.php';
/**
 * PublisherController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class PublisherController extends AppController
{
    protected $_publisher;
    
    protected $_columns = array ('name', 'address');


    public function init()
    {
        $this->_publisher = new Application_Model_DbTable_Publisher();
        $this->_form = new Application_Form_Publisher();
    }
    
    public function indexAction()
    {
       $this->view->publishers = $this->_publisher->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_publisher->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_publisher->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->publisher = $this->_publisher->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_publisher->checkDelete($id)){
               $this->_publisher->del($id);
           }
       }
       $this->_redirect('/publisher/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->publishers = $this->_publisher->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_publisher->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}