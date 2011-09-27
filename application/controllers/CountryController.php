<?php
require_once 'AppController.php';
/**
 * CountryController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class CountryController extends AppController
{
    protected $_country;
    
    protected $_columns = array ('name', 'name_short', 'iso2', 'iso3');


    public function init()
    {
        $this->_country = new Application_Model_DbTable_Country();
        $this->_form = new Application_Form_Country();
    }
    
    public function indexAction()
    {
       $this->view->countries = $this->_country->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()) {
            // if form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_country->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_country->edit($id, $updated);
            } else { 
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->country = $this->_country->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->_country->checkDelete($id)){
               $this->_country->del($id);
           }
       }
       $this->_redirect('/country/');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = array_diff($this->_getColumnsFromRequest(), array('',null));
            $this->view->countries = $this->_country->getByCondition($search);
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_country->insert($inserted);
        }
        $this->view->errors = $this->_form->getErrors();
        $this->_forward('index');
    }

}