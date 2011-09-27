<?php

class AppController extends Zend_Controller_Action
{
    protected $_columns = array();
    protected $_form ;


    protected function _getDiffColumns($row)
    {
        if(! is_array($this->_columns)) {
            return false;
    	}
      	// return array from request wich keys correspond $_columns
        $diff = array_diff_assoc($this->_getAllParams(), $row);
        return array_intersect_key($diff, array_flip($this->_columns));
    }
    
    public function postDispatch() 
    {
        if ($this->_form instanceof  Zend_Form){
            $this->view->form = $this->_form;
        }
    }
    
    protected function _getColumnsFromRequest()
    {
        return array_diff(array_intersect_key($this->_getAllParams(), array_flip($this->_columns)), array('', null, 0));
    }
    
}