<?php
require_once 'AppController.php';
/**
 * CityController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class CityController extends AppController
{
    protected $_city;
    
    protected $_columns = array ('name', 'country_id', 'short_name');


    public function init()
    {
        $this->_city = new Application_Model_DbTable_City();
        $this->_form = new Application_Form_City();
    }
    
    public function indexAction()
    {
        $this->view->cities = $this->_city->getAll();
        
        $countries = array();
        foreach ($this->view->cities as $city){
            $countries[$city->id] = $this->_city->getCountry($city);
        }
        $this->view->countries = $countries;
        
        // assignment here
        if($country_id = $this->getRequest()->getParam('country_id')){
            $this->view->country = $this->_city->getCountryById($country_id);        	
        }
        $this->view->cities = $this->_city->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        // if enter edit form
        if($this->getRequest()->isPost()) {
            // if edit form submit
            if($this->_form->isValid($this->_request->getParams())) {
                $row = $this->_city->getRow($id);
                $updated = $this->_getDiffColumns($row->toArray());
                $this->_city->edit($id, $updated);
            } else {
                $this->view->errors = $this->_form->getErrors();
            }
        }
        $this->view->city = $this->_city->getRow($id);
        $this->_forward('index');
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->checkDelete($id)){
               $this->del($id);
           }
       }
       $this->_forward('index');
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            $search = $this->_getColumnsFromRequest();
            $this->view->cities = $this->_city->getByCondition($search);           
        }
    }

    public function addAction()
    {
        if($this->_form->isValid($this->_request->getParams())) {
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_city->insert($inserted);
        }
        $this->_forward('index');
    }

}