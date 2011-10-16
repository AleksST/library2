<?php
/**
 * Description of ApplicationTable
 *
 * @author Aleks S Tushin
 */
class Application_Model_ApplicationTable extends Zend_Db_Table_Abstract {

    private $_now;
    private $_row;
    private $_rowId; 

    public function init()
    {
        $this->_now = new Zend_Db_Expr('NOW()');
    }
    
    public function del($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$id);
        $this->_removeRow($id);
        return $this->delete($where);
    }
    
    public function edit($id, $data)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$id);
        $this->_removeRow($id);
        return $this->update($data, $where);
    }

    public function update($data, $where) 
    {
        $data['modified'] = $this->_now;
        return parent::update($data, $where);
    }

    public function insert($data) 
    {
        if(!count($data)) {
            return false;
        }
        $data['created']  = $this->_now;
        $data['modified'] = $this->_now;
        return parent::insert($data);
    }

    public function delete($where) 
    {
        return parent::delete($where);
    }
    
    public function countChild(Zend_Db_Table_Row_Abstract $row, $childName = '')
    {
    	if('' == ($childName = $this->_getChildName($childName)) ) {
            return 0;
    	}
    	return count($row->findDependentRowset($childName));
    }

    public function hasChild(Zend_Db_Table_Row_Abstract $row, $childName = '')
    {
    	return ($this->countChild($row, $childName) > 0);
    }
    
    private function _getChildName($childName = '')
    {
    	if(!is_array($this->_dependentTables)){
            return '';
    	}
    	
    	if('' != $childName){
            if(in_array($childName, $this->_dependentTables)){
                return $childName;
            }
    	} else {
            // if table has only one child, return childName
            if(count($this->_dependentTables) == 1){
                return current($this->_dependentTables);
            }
    	}
    	
    	return '';
    }
    
    public function getRow($id) 
    {
    	if ($this->_rowId == $id){
    		return $this->_row;
    	}
    	$this->_rowId = $id;
        return $this->_row = $this->find($this->_rowId)->current();
    }
    
    public function getAll() 
    {
        $select = $this->select()->limit(100);
        return $this->fetchAll($select);
    }
    
    public function checkDelete($id)
    {
        return false;
    }
    
    private function _removeRow($id)
    {
        if($this->_rowId == $id) {
            $this->_row = $this->_rowId = null;
        }
    }
}