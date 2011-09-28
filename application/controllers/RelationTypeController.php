<?php
require_once 'AppController.php';
/**
 * RelationTypeController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class RelationTypeController extends AppController
{
    protected $_relationType;
    
    protected $_columns = array ( 'name', 'cod', 'opposite_cod');

    public function init()
    {
        $this->_relationType = new Application_Model_DbTable_RelationType();
        $this->_form = new Application_Form_RelationType();
    }
    
    public function indexAction()
    {
       $this->view->relationTypes = $this->_relationType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_relationType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_relationType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->relationType = $this->_relationType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_relationType->checkDelete($id)){
               $this->_relationType->del($id);
           }
       }
       $this->_redirect('/relationType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->relationTypes = $this->_relationType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_relationType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}