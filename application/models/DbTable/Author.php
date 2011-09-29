<?php

/**
 * Author
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Author extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'author';

    protected $_dependentTables = array('Application_Model_DbTable_Author');
    protected $_referenceMap    = array(
        'AlternativeAuthor' => array(
            'columns'           => 'alternativename_id',
            'refTableClass'     => 'Application_Model_DbTable_Author',
            'refColumns'        => 'id'
        ),
        'AuthorType' => array(
            'columns'           => 'author_type_id',
            'refTableClass'     => 'Application_Model_DbTable_AuthorType',
            'refColumns'        => 'id'
        ),
        'Authorsign' => array(
            'columns'           => 'authorsign_id',
            'refTableClass'     => 'Application_Model_DbTable_Authorsign',
            'refColumns'        => 'id'
        ),
    );

    public function checkDelete($id) 
    {
        return !$this->hasChild($this->getRow($id), 'Application_Model_DbTable_Author');
    }
	
    public function getByCondition($search) 
    {
        $select = $this->select();
        foreach ( $search as $column => $value ) {
            if (strpos ( $value, '*' ) !== false) {
                $select->where($column . ' like(?)', str_replace('*', '%', $value));
            } else {
                $select->where($column . ' = ?', $value);
            }
        }

        return $this->fetchAll($select);
    }
    
    public function getAuthorType($author)
    {
    	return $author->findParentRow('Application_Model_DbTable_AuthorType');
    }
	
    public function getAlternativeAuthor($author)
    {
    	return $author->findDependentRowset('Application_Model_DbTable_Author');
    }
}