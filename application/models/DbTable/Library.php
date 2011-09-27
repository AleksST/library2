<?php

/**
 * Description of library
 *
 * @author Aleks S Tushin
 */
class Application_Model_DbTable_Library extends Application_Model_ApplicationTable {

    protected $_name = 'library';

    protected $_dependentTables = array('Application_Model_DbTable_Branch');



    public function getAll() {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function getRow($id) {
        return $this->find($id)->current();
    }

    public function checkDelete($id) {
        $library = $this->find($id)->current();
        $branches = $library->findDependentRowset('Application_Model_DbTable_Branch');
        return (0 == count($branches));
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