<?php
require_once 'AppController.php';
/**
 * AuthorController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class AuthorController extends AppController
{
    protected $_author;
    
    protected $_columns = array ('surname', 'name', 'patronymic', 'author_type_id', 'authorsign_id',
    							'alternativename_id', 'initials', 'additions', 'number', 
    							'organization', 'dates');

    public function init()
    {
        $this->_author = new Application_Model_DbTable_Author();
        $this->_form = new Application_Form_Author();
    }
    
    public function indexAction()
    {
       $this->view->authors = $this->_author->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_author->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_author->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->author = $this->_author->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_author->checkDelete($id)){
               $this->_author->del($id);
           }
       }
       $this->_redirect('/author/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->authors = $this->_author->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_author->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}