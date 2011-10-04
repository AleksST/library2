<?php

/**
 * ItemEqual
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemEqual extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_equal';

    protected $_referenceMap    = array(
        'RelationType' => array(
            'columns'           => 'realtion_type_id',
            'refTableClass'     => 'Application_Model_DbTable_RelationType',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}