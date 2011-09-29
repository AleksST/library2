<?php

/**
 * Authorsign
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Authorsign extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'authorsign';

    protected $_dependentTables = array('Application_Model_DbTable_Author');

    public function checkDelete($id) 
    {
        //return !$this->hasChild($this->getRow($id), 'Application_Model_DbTable_Authorsign');
        return false;
    }
	
    public function getByCondition($search) 
    {
        $select = $this->select();
        foreach ( $search as $column => $value ) {
            if (strpos ( $value, '*' ) !== false) {
                $select->where($column . ' like(?)', str_replace('*', '%', $value));
            } else {
                $select->where($column . ' = ?', $value);
            }
        }

        return $this->fetchAll($select);
    }
    
}
