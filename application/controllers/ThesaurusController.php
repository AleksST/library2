<?php
require_once 'AppController.php';
/**
 * ThesaurusController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class ThesaurusController extends AppController
{
    protected $_thesaurus;
    
    protected $_columns = array ('name');


    public function init()
    {
        $this->_thesaurus = new Application_Model_DbTable_Thesaurus();
        $this->_form = new Application_Form_Thesaurus();
    }
    
    public function indexAction()
    {
       $this->view->thesauruses = $this->_thesaurus->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_thesaurus->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_thesaurus->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->thesaurus = $this->_thesaurus->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_thesaurus->checkDelete($id)){
               $this->_thesaurus->del($id);
           }
       }
       $this->_redirect('/thesaurus/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->thesauruses = $this->_thesaurus->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_thesaurus->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}