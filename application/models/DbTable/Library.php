<?php

/**
 * Description of library
 *
 * @author Aleks S Tushin
 */
class Application_Model_DbTable_Library extends Application_Model_ApplicationTable {

    protected $_name = 'library';

    protected $_dependentTables = array('Application_Model_DbTable_Branch');

    public function checkDelete($id) 
    {
        return !$this->hasChild($this->getRow($id), 'Application_Model_DbTable_Branch');
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

}