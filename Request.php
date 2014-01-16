<?php
/**
 * Сборный класс для разбора и модификации строки запроса.
 * 
 * 
 * Использует классы:
 *      Dune_Parsing_Parent_Url
 *      Dune_Filter_Get_Total
 *      Dune_Filter_Post_Total
 *      Dune_Exception_Base
 * 
 * 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Request.php                                 |
 * | В библиотеке: Dune/Request.php                    |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 * 
 * 
 * История версий:
 * -----------------
 *  2011-09-06 Сброс модификаций при вызове инстанса.
 *  2011-08-26 Сброс строки GET за исключением.
 *
 *
 */
class Dune_Request extends Dune_Parsing_Parent_Url
{
    static protected $instance = null;
    
    /**
     * Enter description here...
     *
     * @var Dune_Filter_Get_Total
     */
    protected $_GET = array();
    
    /**
     * Метод сиглетона.
     *
     * @return Dune_Request
     */
    static function getInstance()
    {
        if (static::$instance == null)
        {
            static::$instance = new static();

        }
        static::$instance->_GET = $_GET;
        static::$instance->clearModifications();
        return static::$instance;
    }


    /**
     * Возвращает контейнер _GET
     *
     * @param mixed $def значение по умолчанию
     * @return Dune_Filter_Get_Total
     */
    public function getGetConteiner($def = '')
    {
        return Dune_Filter_Get_Total::getInstance($def);
    }
    
    /**
     * Возвращает контейнер _POST
     *
     * @param mixed $def значение по умолчанию
     * @return Dune_Filter_Post_Total
     */
    public function getPostConteiner($def = '')
    {
        return Dune_Filter_Post_Total::getInstance($def);
    }
    
    
    /**
     * Сколько параметров в _GET
     *
     * @return integer
     */
    public function countGet()
    {
        return count($this->_GET);
    }

    /**
     * Установка параметра _GET
     *
     * @param string $key
     * @param mixed $value
     * @return Dune_Request
     */
    public function setGet($key, $value)
    {
        $this->_GET[$key] = $value;
        return $this;
    }
    
    /**
     * Удалить параметр _GET
     *
     * @param string $key
     * @return Dune_Request
     */
    public function deleteGet($key)
    {
        unset($this->_GET[$key]);
        return $this;
    }
    
    /**
     * Удалить все параметры _GET
     *
     * @return Dune_Request
     */
    public function cleanGet($exept = null)
    {
        if ($exept)
        {
            $array = array();
            if (is_string($exept))
            {
                $exept = array($exept);
            }
            foreach($exept as $value)
            {
                if (isset($this->_GET[$value]))
                {
                    $array[$value] = $this->_GET[$value];
                }
            }
            $this->_GET = $array;
        }
        return $this;
    }
    
    /**
     * Какие переменные в массиве _GET оставить.
     *
     * @param string|array $value
     * @return Dune_Request
     */
    public function useGetValues($value, $control = false)
    {
        if (is_string($value))
        {
            $array = explode(',', $value);
            $value = array();
            foreach ($array as $val)
            {
                $value[] = trim($val);
            }
        }
        if (!is_array($value))
            throw new Dune_Exception_Base('Должен быть массив.');

        $result = array();            
        foreach ($value as $val)
        {
            if (isset($this->_GET[$val]))
            {
                $result[$val] = $this->_GET[$val];
            }
            else if ($control)
            {
                throw new Dune_Exception_Base('В массиве _GET нет необходимого значения.');
            }
        }
        $this->_GET = $result;
        return $this;
    }
    
    /**
     * Выбрать строку запроса.
     *
     * @param boolean $urlencode ключ шифрование значение GET в urlencode
     * @param boolean $with_get ключ включения в строку параметров GET
     * @return string
     */
    public function getUrl($urlencode = false, $with_get = true)
    {
//        $str = $this->getCommandStringFile();
        $str = $this->getCommandString();
        if ($with_get)
            $str .= $this->_collectGet($urlencode);
        return $str;
    }

    public function getUrlFile($urlencode = false, $with_get = true)
    {
        $str = $this->getCommandStringFile();
        if ($with_get)
            $str .= $this->_collectGet($urlencode);
        return $str;
    }


    protected function _collectGet($urlencode)
    {
        $str = '';
        if ($this->_GET and count($this->_GET))
        {
            $connect = '?';
            foreach ($this->_GET as $key => $value)
            {
                if (is_array($value))
                    $str .= $connect . $this->_collectGetArray($value, $key, $urlencode);
                else if ($urlencode)
                    $str .= $connect . $key . '=' . urlencode($value);
                else 
                    $str .= $connect . $key . '=' . $value;
                $connect = '&';
            }
        }
        return $str;
    }

    protected function _collectGetArray($in_value, $name, $urlencode)
    {
        $str = '';
        if (count($in_value))
        {
            $connect = '';
            foreach ($in_value as $key => $value)
            {
                if ($urlencode)
                    $str .= $connect . $name . '[' . $key . ']=' . urlencode($value);
                else
                    $str .= $connect . $name . '[' . $key . ']=' . $value;
                $connect = '&';
            }
        }
        return $str;
    }


}