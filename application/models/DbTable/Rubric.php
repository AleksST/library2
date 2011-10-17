<?php

/**
 * Rubric
 * 
 * @author Aleks S Tushin
 * @version 
 */

class Application_Model_DbTable_Rubric extends Application_Model_ApplicationTable {
    /**
     * The default table name 
     */
    protected $_name = 'rubric';

    protected $_dependentTables = array('Application_Model_DbTable_Rubric',
    									'Application_Model_DbTable_ItemRubric'
    );
    
    protected $_referenceMap    = array(
        'AlternativeRubric' => array(
            'columns'           => 'alternative_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubric',
            'refColumns'        => 'id'
        ),
        'RubricType' => array(
            'columns'           => 'rubric_type_id',
            'refTableClass'     => 'Application_Model_DbTable_RubricType',
            'refColumns'        => 'id'
        ),
        'ParentRubric' => array(
            'columns'           => 'parent_id',
            'refTableClass'     => 'Application_Model_DbTable_Rubric',
            'refColumns'        => 'id'
        ),
        'Thesaurus' => array(
            'columns'           => 'thesaurus_id',
            'refTableClass'     => 'Application_Model_DbTable_Thesaurus',
            'refColumns'        => 'id'
        ),
    );

    public function checkDelete($id) 
    {
        //return !$this->hasChild($this->getRow($id), 'Application_Model_DbTable_Rubric');
        return false;
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
    
    public function getRubricType($rubric)
    {
    	return $rubric->findParentRow('Application_Model_DbTable_RubricType');
    }
	
    public function getAlternativeRubric($rubric)
    {
    	return $rubric->findParentRow('Application_Model_DbTable_Rubric','AlternativeRubric');
    }
    
    public function getParentRubric($rubric)
    {
    	return $rubric->findParentRow('Application_Model_DbTable_Rubric','ParentRubric');
    }
    
    public function getThesaurus($rubric)
    {
    	return $rubric->findParentRow('Application_Model_DbTable_Thesaurus');
    }
}