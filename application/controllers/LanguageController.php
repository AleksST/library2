<?php
require_once 'AppController.php';
/**
 * LanguageController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class LanguageController extends AppController
{
    protected $_language;
    
    protected $_columns = array ('name', 'name_short', 'eng', 'iso3');


    public function init()
    {
        $this->_language = new Application_Model_DbTable_Language();
        $this->_form = new Application_Form_Language();
    }
    
    public function indexAction()
    {
       $this->view->languages = $this->_language->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_language->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_language->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->language = $this->_language->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_language->checkDelete($id)){
               $this->_language->del($id);
           }
       }
       $this->_redirect('/language/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->languages = $this->_language->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_language->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}