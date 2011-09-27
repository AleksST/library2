<?php

class Application_Model_DbTable_City extends Application_Model_ApplicationTable
{

    protected $_name = 'city';
    private $_country;
    
    protected $_referenceMap    = array(
        'Country' => array(
            'columns'           => 'country_id',
            'refTableClass'     => 'Application_Model_DbTable_Country',
            'refColumns'        => 'id'
        )
    );
    
    public function checkDelete($id) {
        // todo write logic then add other relation table 
        return false;
    }
    
    public function getByCondition($search)
    {
        $select = $this->select();
        foreach ($search as $column=>$value){
            if(strpos($value, '*') !== false) {
                $select->where($column.' like(?)', str_replace('*', '%',$value));
            } else {
                $select->where($column.' = ?', $value);
            }
        }
        return $this->fetchAll($select);
    }
    
    public function getCountry($branch)
    {
    	return $branch->findParentRow('Application_Model_DbTable_Country');
    }
    
    public function getCountryById($id)
    {
    	return $this->_getLibraryModel()->find($id)->current();
    }
    
    /**
     * 
     * Return country model 
     */
    private function _getLibraryModel()
    {
    	if(is_object($this->_country)){
    		return $this->_country;
    	}
    	return $this->_country = new Application_Model_DbTable_Country();
    }


}

