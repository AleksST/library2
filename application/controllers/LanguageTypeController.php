<?php
require_once 'AppController.php';
/**
 * LanguageController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class LanguageTypeController extends AppController
{
    protected $_languageType;
    
    protected $_columns = array ( 'name', 'cod');

    public function init()
    {
        $this->_languageType = new Application_Model_DbTable_LanguageType();
        $this->_form = new Application_Form_LanguageType();
    }
    
    public function indexAction()
    {
       $this->view->languageTypes = $this->_languageType->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_languageType->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_languageType->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->languageType = $this->_languageType->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_languageType->checkDelete($id)){
               $this->_languageType->del($id);
           }
       }
       $this->_redirect('/languageType/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->languageTypes = $this->_languageType->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_languageType->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}