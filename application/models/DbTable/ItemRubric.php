<?php

/**
 * ItemRubric
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_ItemRubric extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'item_rubric';

    protected $_referenceMap    = array(
        'Rubric' => array(
            'columns'           => 'author_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubric',
            'refColumns'        => 'id'
        ),
        'Item' => array(
            'columns'           => 'item_id',
            'refTableClass'     => 'Application_Model_DbTable_Item',
            'refColumns'        => 'id'
        ),
    );
}