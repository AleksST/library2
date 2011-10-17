<?php
require_once 'AppController.php';
/**
 * RubricController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class RubricController extends AppController
{
    protected $_rubric;
    
    protected $_columns = array ('name', 'rubric_type_id', 'thesaurus_id',
    				'alternative_id', 'parent_id', 'note');

    public function init()
    {
        $this->_rubric = new Application_Model_DbTable_Rubric();
        $this->_form = new Application_Form_Rubric();
    }
    
    public function indexAction()
    {
       $this->view->rubrics = $this->_rubric->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_rubric->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_rubric->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->rubric = $this->_rubric->getRow($id);
        $this->view->thesaurus = $this->_rubric->getThesaurus($this->view->rubric);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_rubric->checkDelete($id)){
               $this->_rubric->del($id);
           }
       }
       $this->_redirect('/rubric/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->rubrics = $this->_rubric->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_rubric->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }
    
    //@todo: bad style: rewrite it!
    public function autocompleteAction()
    {
    	$select = $this->_rubric->select();
    	$term = str_replace('*', '%', $this->getRequest()->getParam('term'));
    	$select->where('name like (?)', $term  . '%')
               ->order('name');
    	$res = $this->_rubric->fetchAll($select)->toArray();
    	foreach ($res as $i=>$row){
    		$res2[$i]['value'] = $row['name'];
    		$res2[$i]['id'] = $row['id'];
    	}
    	echo Zend_Json::encode($res2);exit;
    }
}