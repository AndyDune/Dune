<?php
/**
 * Dune Framework
 * 
 * Разбиение строки сепараторами с созданием массива.
 * Обёртка к функции explode()
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Explode.php                                 |
 * | В библиотеке: Dune/String/Explode.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.07                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * 
 * Версия 1.07  (2009 май 14)
 * Строковые функции из контейнера. Класс готов к UTF.
 * 
 * Версия 1.05  (2009 январь 22)
 * Исправлена ошибка принятия 0(нуля) за отсутствие значения.
 * 
 * Версия 1.05  (2009 январь 21)
 * Добавлена реализация интерфейса Countable.
 * 
 * Версия 1.04  (2008 декабрь 04)
 * Добавлен метод getResultArray() возврат всего маассива.
 * 
 * 
 * Версия 1.03  (2008 октябрь 23)
 * Добавлен метод getInteger() для доступа к ключам разбитого массива.
 * Добавлена возможность менять начало отсчета ключей массива.
 * 
 * Версия 1.02
 * Реализован итератор.
 * 
 * Версия 1.00 -> 1.01
 * Разбиение строки в массив при вызове конструктора, если передан парметр $separator.
 * Можно повторить разбивку (если сменили сепаратор) при вызове make()
 */

class Dune_String_Explode implements ArrayAccess, Iterator, Countable
{
	protected $_string;
	protected $_separator;
	protected $_array = array();
	protected $_count = 0;
	protected $_empty = false;
	
	
	public function __construct($string, $separator = '', $key_begin = 0)
	{
	    $str = Dune_String_Factory::getStringContainer($string);
	    $this->_string = $str->trim(' '.$separator);
//		$this->_string = trim($string, ' '.$separator);
		$this->_separator = $separator;
		if ($this->_separator)
			$this->make($key_begin);
		
	}
	
	public function setSeparator($separator)
	{
		$this->_separator = $separator;
	}
	
	public function count()
	{
		return $this->_count;
	}
	
	public function leaveEmpty($bool = true)
	{
		$this->_empty = $bool;
	}

	public function getInteger($key = 0, $default = null)
	{
        if (isset($this->_array[$key]))
            return (int)$this->_array[$key];
        else 
           return $default;
	}
	
	/**
	 * Преобразует стоку в массив по разделителю. Удаляет пустые.
	 *
	 * @return integer
	 */
    public function make($key_begin = 0)
    {
        $array_result = array();
        if ($this->_string)
        {
            $array_begin = explode($this->_separator, $this->_string);
            foreach ($array_begin as $value)
            {
                $x = trim($value);
                if ($x != '' or $this->_empty)
                {
                    $array_result[$key_begin] = $x;
                    $key_begin++;
                }
            }
        }
        $this->_array = $array_result;
        $this->_count = count($array_result);
        
        return $this->_count;
    }

    /**
     * Возврат всего результирующего массива.
     *
     * @param boolean $in_container
     * @return array
     */
    public function getResultArray($in_container = false)
    {
        if ($in_container)
            return new Dune_Array_Container($this->_array);
        return $this->_array;
    }

    
//////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    public function offsetExists($key)
    {
        return isset($this->_array[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($this->_array[$key]))
            return $this->_array[$key];
        else 
           return null;
    }
    
    public function offsetSet($key, $value)
    {
        $this->_array[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->_array[$key]);
    }    

    ////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($this->_array);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($this->_array);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->_array);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->_array);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($this->_array[key($this->_array)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   
    
    
}

