<?php
require_once 'AppController.php';
/**
 * SeriaController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class SeriaController extends AppController
{
    protected $_seria;
    
    protected $_columns = array ('publisher_id', 'name', 'order', 'name_parallel', 'note', 'issn');

    public function init()
    {
        $this->_seria = new Application_Model_DbTable_Seria();
        $this->_form = new Application_Form_Seria();
    }
    
    public function indexAction()
    {
       $this->view->series = $this->_seria->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_seria->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_seria->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->seria = $this->_seria->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_seria->checkDelete($id)){
               $this->_seria->del($id);
           }
       }
       $this->_redirect('/seria/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->series = $this->_seria->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_seria->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}