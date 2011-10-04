<?php

/**
 * ItemHeader
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemHeader extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_header';

    protected $_referenceMap    = array(
        'HeaderType' => array(
            'columns'           => 'header_type_id',
            'refTableClass'     => 'Application_Model_DbTable_HeaderType',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}