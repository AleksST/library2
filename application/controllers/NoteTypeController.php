<?php
require_once 'AppController.php';
/**
 * NoteTypeController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class NoteTypeController extends AppController
{
    protected $_noteType;
    
    protected $_columns = array ( 'name', 'cod', 'name_short');

    public function init()
    {
        $this->_noteType = new Application_Model_DbTable_NoteType();
        $this->_form = new Application_Form_NoteType();
    }
    
    public function indexAction()
    {
       $this->view->noteTypes = $this->_noteType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_noteType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_noteType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->noteType = $this->_noteType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_noteType->checkDelete($id)){
               $this->_noteType->del($id);
           }
       }
       $this->_redirect('/noteType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->noteTypes = $this->_noteType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_noteType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}