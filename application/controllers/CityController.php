<?php

/**
 * CityController
 * 
 * @author Aleks S Tushin
 * @version 
 */


class CityController extends Zend_Controller_Action
{
    protected $_city;
    
    protected $_columns = array ('name', 'country_id', 'short_name');


    public function init()
    {
        $this->_city = new Application_Model_DbTable_city();
    }

    public function indexAction()
    {
         if($this->getRequest()->isPost()){
             $inserted = $this->_getColumnsFromRequest();
             $id = $this->_city->insert($inserted);
        }
        $this->view->cities = $this->_city->getAll();
    }

    public function updateAction()
    {
        $id = $this->getRequest()->getParam('id');
        if($this->getRequest()->isPost()){
            $row = $this->_city->getRow($id);
            $updated = $this->_getDiffColumns($row->toArray());
            $this->_city->edit($id, $updated);
        }
        
        $this->view->city = $this->_city->getRow($id);
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
            $this->view->cities = $this->_city->getByCondition($search);           
        }
        
    }

    public function addAction()
    {
       $this->_redirect('index');
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