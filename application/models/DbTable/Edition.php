<?php

/**
 * Edition
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Edition extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'edition';

    protected $_referenceMap    = array(
       'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}