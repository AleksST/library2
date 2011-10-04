<?php

/**
 * ItemPublicher
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemPublicher extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_publicher';

    protected $_referenceMap    = array(
        'Publicher' => array(
            'columns'           => 'publicher_id',
            'refTableClass'     => 'Application_Model_DbTable_Publicher',
            'refColumns'        => 'id'
        ),
        'Seria' => array(
            'columns'           => 'seria_id',
            'refTableClass'     => 'Application_Model_DbTable_Seria',
            'refColumns'        => 'id'
        ),
        'Subseria' => array(
            'columns'           => 'seria_id',
            'refTableClass'     => 'Application_Model_DbTable_Subseria',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}