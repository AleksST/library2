<?php

/**
 * Publisher
 * 
 * @publisher Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Publisher extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'publisher';

    protected $_dependentTables = array('Application_Model_DbTable_ItemPublisher');
   // protected $_referenceMap    = array(
//        'AlternativePublisher' => array(
//            'columns'           => 'alternativename_id',
//            'refTableClass'     => 'Application_Model_DbTable_Publisher',
//            'refColumns'        => 'id'
//        ),
 //   );

    public function checkDelete($id) 
    {
//        return !$this->hasChild($this->getRow($id), 'Application_Model_DbTable_Publisher');
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