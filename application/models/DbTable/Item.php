<?php

/**
 * Item
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Item extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item';

    protected $_dependentTables = array(
        'Application_Model_DbTable_ItemRelation',   'Application_Model_DbTable_ItemEqual',
        'Application_Model_DbTable_ItemHeader',     'Application_Model_DbTable_ItemNote',
        'Application_Model_DbTable_Edition',        'Application_Model_DbTable_Iteminfo',
        'Application_Model_DbTable_ItemAuthor',     'Application_Model_DbTable_ItemCity',
        'Application_Model_DbTable_ItemCountry',    'Application_Model_DbTable_ItemLanguage',
        'Application_Model_DbTable_ItemPublicher',  'Application_Model_DbTable_ItemRubric',
        'Application_Model_DbTable_ItemSnumber',    'Application_Model_DbTable_ItemExemplar',
    );
    
    protected $_referenceMap    = array(
        'Type' => array(
            'columns'           => 'type_id',
            'refTableClass'     => 'Application_Model_DbTable_Type',
            'refColumns'        => 'id'
        ),
    );

    public function checkDelete($id) 
    {
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
