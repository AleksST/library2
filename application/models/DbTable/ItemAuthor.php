<?php

/**
 * ItemAuthor
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemAuthor extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_author';

    protected $_referenceMap    = array(
        'Author' => array(
            'columns'           => 'author_id',
            'refTableClass'     => 'Application_Model_DbTable_Author',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
        'AuthorResp' => array(
        	'columns'           => 'author_resp_id',
            'refTableClass'     => 'Application_Model_DbTable_AuthorResp',
            'refColumns'        => 'id'
        )
    );
}