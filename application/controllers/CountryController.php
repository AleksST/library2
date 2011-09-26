<?php

/**
 * CountryController
 * 
 * @author Aleks S Tushin
 * @version 
 */

class CountryController extends Zend_Controller_Action
{
    protected $_country;
    
    protected $_columns = array ('name', 'name_short', 'iso2', 'iso3');


    public function init()
    {
        $this->_country = new Application_Model_DbTable_Country();
    }

    public function indexAction()
    {
         if($this->getRequest()->isPost()){
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_country->insert($inserted);
        }
        $this->view->countries = $this->_country->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()){
            $row = $this->_country->getRow($id);
            $updated = $this->_getDiffColumns($row->toArray());
            $this->_country->edit($id, $updated);
        }
        
        $this->view->country = $this->_country->getRow($id);
    }

    public function deleteAction()
    {
       if($this->getRequest()->isPost()){
           $id = $this->getRequest()->getParam('id');
           if($this->checkDelete($id)){
               $this->del($id);
           }
       }
    }

    public function searchAction()
    {
        if($this->getRequest()->isPost()){
            //$this->_columns[] = 'created';
            //$this->_columns[] = 'modified';
            $search = $this->_getColumnsFromRequest();
            $this->view->countries = $this->_country->getByCondition($search);
                      
        }
        
    }

    public function addAction()
    {
       $this->render('index');
    }
    
    protected function _getDiffColumns($row)
    {
        if(! is_array($this->_columns)) {
            return false;
    	}
      	// return array from request wich keys correspond $_columns
        $diff = array_diff($this->_getAllParams(), $row);
        return array_intersect_key($diff, array_flip($this->_columns));
    }
    
    protected function _getColumnsFromRequest()
    {
        return array_intersect_key($this->_getAllParams(), array_flip($this->_columns));
    }


}