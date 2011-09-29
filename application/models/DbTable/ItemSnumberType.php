<?php

/**
 * ItemSnumberType
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemSnumberType extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_snumber_type';

    protected $_referenceMap    = array(
        'SnumberType' => array(
            'columns'           => 'snumber_type_id',
            'refTableClass'     => 'Application_Model_DbTable_SnumberType',
            'refColumns'        => 'id'
        ),
        'Type' => array(
            'columns'           => 'type_id',
            'refTableClass'     => 'Application_Model_DbTable_Type',
            'refColumns'        => 'id'
        ),
    );

    public function checkDelete($id) 
    {
        //return !$this->hasChild($this->getRow($id), 'Application_Model_DbTable_ItemSnumberType');
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
