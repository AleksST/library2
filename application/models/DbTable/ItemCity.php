<?php

/**
 * ItemCity
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemCity extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_city';

    protected $_referenceMap    = array(
        'City' => array(
            'columns'           => 'author_id',
            'refTableClass'     => 'Application_Model_DbTable_City',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}