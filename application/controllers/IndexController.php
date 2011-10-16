<?php

class IndexController extends Zend_Controller_Action
{
    
    public function init()
    {
       $this->_udc = new Application_Model_DbTable_Udc();
    }

    public function indexAction()
    {
       //$this->parseHtml('http://teacode.com/online/udc/index.html');
    }
    
    private function parseHtml($url, $parent_id = null)
    {
        $html = $this->getHtml($url);
        $count = preg_match_all("|<tr bgcolor=\"\#eaeaea\">(.*)?</tr>|sU", $html, $lines);
        
        foreach ($lines['1'] as $line){
            $count = preg_match_all("|<font .*>(.*)?</font>|sU", $line, $rows);
            list($cod, $text, $note) = $rows['1'];
            list($cod, $link) = $this->getLink($cod, $url);
            
            $cod = (strlen($cod) > 50) ? current(explode (' ', substr($cod, 0, 50))) : $cod;
            $text = substr(strip_tags($text), 0, 2000);
            $note = substr(strip_tags($note), 0, 4000);
            
            $id = $this->_udc->insert(compact('cod', 'text', 'note', 'parent_id'));
          
            if( $link != ''){
                // recursion
                $this->parseHtml($link, $id);
            }
        }
        
    }


    private function getHtml($link)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $link);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $html = mb_convert_encoding(curl_exec($ch), 'utf-8', 'cp1251');
        curl_close($ch);
        return $html;
    }

    private function getLink($cod, $url)
    {
        $link = '';
        if(strpos($cod, 'href')){
            preg_match('|href="(.*)?">(.*){3}<|sU', $cod, $matches);
            list(, $link, $cod ) = $matches;
            if(0 === strpos($link, './')) {
                $link = substr($link, 2); 
            }
            $link = substr($url, 0 , strrpos($url, '/')) . '/' . $link;
        }
        return array($cod, $link);
    }
}

