<?php

/**
 * Description of library
 *
 * @author Aleks S Tushin
 */
class Application_Model_DbTable_Library extends Application_Model_ApplicationTable {

    protected $_name = 'library';

//    protected $_referenceMap  = array();
//    protected $_dependentTables = array(
//      'ItemTable'=> array(
//            'columns'       =>  'item_id',
//            'reftableClass' =>  'ItemTable',
//            'refColumns'    =>  'id',
//        ));



    public function getAll() {
        $select = $this->select();
        return $this->fetchAll($select);
    }

    public function getRow($id) {
        return $this->find($id)->current();
    }

    public function checkDelete($id) {
        // todo write logic then add other relation table 
        return false;
    }
    
    public function del($id)
    {
        $where = $this->select()->where('id= ?',$id);
        return $this->delete($where);
    }
    
    public function edit($id, $data)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$id);
        return $this->update($data, $where);
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

}