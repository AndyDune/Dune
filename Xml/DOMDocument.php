<?php
/**
 * Расширение DOMDocument
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: DOMDocument.php                             |
 * | В библиотеке: Dune/Xml/DOMDocument.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 *
 */
class Dune_Xml_DOMDocument extends DOMDocument
{
    
    
    /**
     * Быстрая простая загрузка данных в xml. Принимает так же массив.
     *
     * @param unknown_type $name
     * @param unknown_type $value
     */
    public function appendArray($name, $value)
    {
        $root = $this->appendChild($this->createElement($name));
        $this->_recurseNode($value, $root);
    }

    
    /**
     * Извлечение массива из нода.
     * !! Вложенность невозможна.
     *
     * @param string $name
     * @return array
     */
    public function getArray($name)
    {
        $content = $this->getElementsByTagName($name); // gets NodeList
        $nod = $content->item(0); //Node 
        return $array = $this->_getContent($content, $nod);
    }
    
    public function _getContent($node_content = "", $nod)
    {
        $array = array();
        $nod_list = $nod->childNodes;
        
        for( $j=0 ;  $j < $nod_list->length; $j++ )
        { 
            $current_nod = $nod_list->item($j);//Node j
            $nodemane  = $current_nod->nodeName;
            $nodevalue = $current_nod->nodeValue;
//            if($current_nod->nodeType == XML_TEXT_NODE)
            $array[$nodemane] =  $nodevalue;
        }
        return $array;
    }    
    
    
    
        /**
         * recurse a nested array and return dom back
         *
         * @param array $data
         * @param dom element $obj
         */
        private function _recurseNode($data, $obj)
        {
            $i = 0;
            $sub_obj = array();
            foreach($data as $key => $value)
            {
                if(is_array($value))
                {
                    //recurse if neccisary
                    $sub_obj[$i] = $this->createElement($key);
                    $obj->appendChild($sub_obj[$i]);
                    $this->_recurseNode($value, $sub_obj[$i]);
                }
                elseif(is_object($value)) 
                {
                    //no object support so just say what it is
                    $sub_obj[$i] = $this->createElement($key, 'Object: "' . $key . '" type: "'  . get_class($value) . '"');
                    $obj->appendChild($sub_obj[$i]);
                }
                else
                {
                    //straight up data, no weirdness
                    $sub_obj[$i] = $this->createElement($key);
                    $sub_obj[$i]->appendChild($this->createCDATASection($value));
//                    $sub_obj[$i]->appendChild($this->createTextNode($value));
                    $obj->appendChild($sub_obj[$i]);
                }
                $i++;
            }
        }    

}