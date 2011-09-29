<?php

/**
 * ItemLanguage
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemLanguage extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_language';

    protected $_referenceMap    = array(
        'Language' => array(
            'columns'           => 'author_id',
            'refTableClass'     => 'Application_Model_DbTable_Language',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}