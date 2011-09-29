<?php

/**
 * ItemCountry
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemCountry extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_country';

    protected $_referenceMap    = array(
        'Country' => array(
            'columns'           => 'author_id',
            'refTableClass'     => 'Application_Model_DbTable_Country',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}