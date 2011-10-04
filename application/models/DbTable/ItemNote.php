<?php

/**
 * ItemNote
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemNote extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_note';

    protected $_referenceMap    = array(
        'Note' => array(
            'columns'           => 'author_id',
            'refTableClass'     => 'Application_Model_DbTable_Note',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}