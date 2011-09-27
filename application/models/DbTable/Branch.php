<?php

/**
 * Description of branch
 *
 * @author Aleks S Tushin
 */
class Application_Model_DbTable_Branch extends Application_Model_ApplicationTable {

    protected $_name = 'branch';
    private $_library;

    protected $_referenceMap    = array(
        'Library' => array(
            'columns'           => 'library_id',
            'refTableClass'     => 'Application_Model_DbTable_Library',
            'refColumns'        => 'id'
        )
    );

    public function checkDelete($id) {
        // todo write logic then add other relation table 
        return false;
    }
    
 	public function getAll() {
        $select = $this->select();
        return $this->fetchAll($select);
    }
    
	public function getRow($id) {
        return $this->find($id)->current();
    }
    
    public function getByCondition($search)
    {
        $select = $this->select();
        foreach ($search as $column=>$value){
            if(strpos($value, '*') !== false) {
                $select->where($column.' like(?)', str_replace('*', '%',$value));
            } else {
                $select->where($column.' = ?', $value);
            }
        }
        return $this->fetchAll($select);
    }
    
    /**
     * 
     * Return parent library for the branch
     * @param obj Row $branch
     */
    public function getLibrary($branch)
    {
    	return $branch->findParentRow('Application_Model_DbTable_Library');
    }
    
    /**
     * 
     * Get library row by library id
     * used for add new branch with known library_id
     * @param int $id
     * @return model row Library
     */
    public function getLibraryById($id)
    {
    	return $this->_getLibraryModel()->find($id)->current();
    }
    
    /**
     * 
     * Return library model 
     */
    private function _getLibraryModel()
    {
    	if(is_object($this->_library)){
    		return $this->_library;
    	}
    	return $this->_library = new Application_Model_DbTable_Library();
    }

}