<?php

/**
 * ItemSnumber
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemSnumber extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_snumber';

    protected $_referenceMap    = array(
        'Snumber' => array(
            'columns'           => 'snumber_id',
            'refTableClass'     => 'Application_Model_DbTable_Snumber',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}