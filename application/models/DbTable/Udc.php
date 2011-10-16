<?php

class Application_Model_DbTable_Udc extends Application_Model_ApplicationTable
{

    protected $_name = 'index_udc';
    
    public function checkDelete($id) {
        // todo write logic then add other relation table 
        return false;
    }
    
}

