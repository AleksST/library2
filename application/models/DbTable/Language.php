<?php

/**
 * Language
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Language extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'language';

    //protected $_dependentTables = array('Application_Model_DbTable_City');

    public function checkDelete($id) 
    {
        $language = $this->getRow($id);
        //$relations = $this->hasChild($language, 'Application_Model_DbTable_City');
        // return (0 == count($relations));
        return false;
    }
	
    public function getByCondition($search) {
        $select = $this->select ();
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
