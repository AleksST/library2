<?php

class Application_Model_DbTable_Subsera extends Application_Model_ApplicationTable
{

    protected $_name = 'subseria';
    private $_seria;
    
    protected $_referenceMap    = array(
        'Seria' => array(
            'columns'           => 'seria_id',
            'refTableClass'     => 'Application_Model_DbTable_Seria',
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
    
    public function getSeria($subseria)
    {
    	return $subseria->findParentRow('Application_Model_DbTable_Seria');
    }
    
    public function getSeriaById($id)
    {
    	return $this->_getSeriaModel()->find($id)->current();
    }
    
    /**
     * 
     * Return seria model 
     */
    private function _getSeriaModel()
    {
    	if(is_object($this->_seria)){
    		return $this->_seria;
    	}
    	return $this->_seria = new Application_Model_DbTable_Seria();
    }


}

