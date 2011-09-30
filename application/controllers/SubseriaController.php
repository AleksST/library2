<?php
require_once 'AppController.php';
/**
 * SubseriaController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class SubseriaController extends AppController
{
    protected $_subseria;
    
    protected $_columns = array ('seria_id', 'name', 'order');

    public function init()
    {
        $this->_subseria = new Application_Model_DbTable_Subseria();
        $this->_form = new Application_Form_Subseria();
    }
    
    public function indexAction()
    {
       $this->view->subseries = $this->_subseria->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_subseria->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_subseria->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->subseria = $this->_subseria->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_subseria->checkDelete($id)){
               $this->_subseria->del($id);
           }
       }
       $this->_redirect('/subseria/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->subseries = $this->_subseria->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_subseria->insubsert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}