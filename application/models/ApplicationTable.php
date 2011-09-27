<?php
/**
 * Description of ApplicationTable
 *
 * @author Aleks S Tushin
 */
class Application_Model_ApplicationTable extends Zend_Db_Table_Abstract {

    protected $_now;

    public function init()
    {
        $this->_now = new Zend_Db_Expr('NOW()');
    }
    
    public function del($id)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$id);
        return $this->delete($where);
    }
    
    public function edit($id, $data)
    {
        $where = $this->getAdapter()->quoteInto('id = ?',$id);
        return $this->update($data, $where);
    }

    public function update($data, $where) 
    {
        $data['modified'] = $this->_now;
        parent::update($data, $where);
    }

    public function insert($data) 
    {
        if(!count($data)) {
            return false;
        }
        $data['created']  = $this->_now;
        $data['modified'] = $this->_now;
        parent::insert($data);
    }

    public function delete($where) 
    {
        parent::delete($where);
    }

    public function checkDelete($id)
    {
        return false;
    }
}