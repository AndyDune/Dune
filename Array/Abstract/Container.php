<?php
/**
 * ��������� ������� ���������� ������ �� ������� �����.
 * ���� ����� ��� - ���������� �������� �� ���������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: Container.php                               |
 * | � ����������: Dune/Array/Abstract/Container.php   |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>         |
 * | ������: 1.06                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 *
 * 1.06 (2008 ��� 23)
 * ��������� ��������� ���������� � ��� ��������� ��������.
 * ����� ����� - ������� ��������������� �������.
 * 
 * 1.05 (2008 ������� 24)
 * ������ ��������� - ��������� ��� �������� null ����������.
 * 
 * 1.04 (2008 ������ 05)
 *  ��������� ��������� Countable.
 * 
 * 1.03 ��������� ���������� ������
 * 1.02 (2008 ������� 29) ��� �������� ������� �������� ������� ������ � ����� : � ������ �� ����.
 * 
 * ������ 1.00 -> 1.01
 * ���������� ������ ������������� ����� 0 � ������ get()
 * 
 * ������ 1.00 -> 1.00
 * �������������� Dune_Array_Isset
 * 
 * 
 */
abstract class Dune_Array_Abstract_Container implements ArrayAccess, Iterator, Countable
{

	protected $_array = array();
	protected $_arraySourse = array();
	protected $_defaultValue = null;
	
	protected function __construct($array, $defaultValue = null)
	{
	    if (is_array($array) and count($array) > 0)
	    {
	        $this->_arraySourse = $array;
	        $this->_array = $array;
	    }
//		$this->_array = $array;
		$this->_defaultValue = $defaultValue;
	}
	
	/**
	 * ���������� ����������� ��������� �������
	 * ��������� ��������� Countable
	 * 
	 * @return integer
	 */
	public function count()
	{
		return count($this->_array);
	}

	/**
	 * ���������� ���� ������, ���� �� ������ �������� $key
	 * ���������� ���������� ������ ������� � �������� ���������� � $key
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key = false)
	{
		if ($key !== false)
		{
			if (isset($this->_array[$key]))
				return $this->_array[$key];
			else 
				return false;
		}
		else 
			return $this->_array;
	}
	
	/**
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function set($key, $value = '')
	{
    	return $this->_array[$key] = $value;
	}	
	/**
	 * ������������� ����� �������� �� ��������� 
	 *
	 * @param unknown_type $value
	 */
	public function setDefaultValue($value)
	{
		$this->_defaultValue = $value;
	}

	/**
	 * �������� ��������� ����� � �������.
	 *
	 * @param mixed $key ���� ��� ��������
	 * @return boolean true - ���� ����������, false - ���
	 */
	public function check($key)
	{
		return isset($this->_array[$key]);
	}
	
	/**
	 * ������� ������� "��� ����"
	 *
	 * @return array
	 */
	public function toArray()
	{
	    return $this->_arraySourse;
	}
	
////////////////////////////////////////////////////////////////
///////////////////////////////     ���������� ������
    public function __set($name, $value)
    {
        $this->_array[$name] = $value;
    }
    public function __get($name)
    {
        if (isset($this->_array[$name]))
            return $this->_array[$name];
        else 
           return $this->_defaultValue;
    }  
    
    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->_array);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }
      ////////////////////////////////////////////////////////////////
///////////////////////////////     ������ ���������� ArrayAccess
    /**
     * @param mixed $key
     * @return mixed
     * @access private
     */
    public function offsetExists($key)
    {
        return isset($this->_array[$key]);
    }
    public function offsetGet($key)
    {
        if (isset($this->_array[$key]))
            return $this->_array[$key];
        else 
           return $this->_defaultValue;
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
///////////////////////////////     ������ ���������� Iterator
  // ������������� �������� �� ������ �������
  public function rewind()
  {
        return reset($this->_array);
  }
  // ���������� ������� �������
  public function current()
  {
      return current($this->_array);
  }
  // ���������� ���� �������� ��������
  public function key()
  {
    return key($this->_array);
  }
  
  // ��������� � ���������� ��������
  public function next()
  {
    return next($this->_array);
  }
  // ���������, ���������� �� ������� ������� ����� ���������� ������ rewind ��� next
  public function valid()
  {
    //return isset($this->_array[key($this->_array)]);
    return array_key_exists(key($this->_array), $this->_array);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////   

}