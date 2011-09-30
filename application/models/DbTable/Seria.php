<?php

class Application_Model_DbTable_Seira extends Application_Model_ApplicationTable
{

    protected $_name = 'seria';
    private $_publicher;
    
    protected $_referenceMap    = array(
        'Publicher' => array(
            'columns'           => 'publicher_id',
            'refTableClass'     => 'Application_Model_DbTable_Publicher',
            'refColumns'        => 'id'
        )
    );
    
    public function checkDelete($id) {
        // todo write logic then add other relation table 
        return false;
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
    
    public function getPublicher($seria)
    {
    	return $seria->findParentRow('Application_Model_DbTable_Publicher');
    }
    
    public function getPublicherById($id)
    {
    	return $this->_getPublicherModel()->find($id)->current();
    }
    
    /**
     * 
     * Return publicher model 
     */
    private function _getPublicherModel()
    {
    	if(is_object($this->_publicher)){
    		return $this->_publicher;
    	}
    	return $this->_publicher = new Application_Model_DbTable_Publicher();
    }


}

