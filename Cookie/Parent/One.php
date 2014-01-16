<?php
/**
 * Класс для работы с перемиенной пимрога.
 * Шаблон для дочерних классов.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: One.php                                     |
 * | В библиотеке: Dune/Cookie/One.php                 |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 */

abstract class Dune_Cookie_Parent_One
{
    /**
     * Имя переменной пирога
     *
     * @var string
     * @access private
     */
    protected $_name;

    /**
     * Значение пирога
     *
     * @var mixed
     * @access private
     */
    protected $_value = '';
    
    /**
     * Домен
     *
     * @var string
     * @access private
     */
    protected $_domain = '';

    /**
     * Папка
     *
     * @var string
     * @access private
     */
    protected $_path = '';
    
    /**
     * Время пирога
     *
     * @var string
     * @access private
     */
    protected $_expire = 0;


    /**
     * Время пирога
     *
     * @var string
     * @access private
     */
    protected $_secure = 0;
    
    
    public function get()
    {
        if (isset($_COOKIE[$name]))
            return $_COOKIE[$name];
        return null;
    }    

    /**
     * Установка переменной пирога
     *
     * @param mixed $value
     */
    public function set($value)
    {
        $this->_value = $value;
        $this->_set();
        return $this;
    }    

    public function setPath($value)
    {
        $this->_path = $value;
        return $this;
    }
    public function setDomain($value)
    {
        $this->_domain = $value;
        return $this;
    }
    
    public function setDomain($value)
    {
        $this->_domain = $value;
        return $this;
    }

    public function reset()
    {
        setcookie($this->_name, '', time() - 3600, $this->_path, $this->_domain, $this->_secure);
        return $this;
    }
    
    
    /**
     * Время жизни пирога.
     * Если не передано время жизни до закрытия браузера.
     *
     * @param integer $value секундф от сего момента
     */
    public function setExpireRelative($value)
    {
        $this->_expire = time() + $value;
        return $this;
    }
    
    
    /**
     * Провока установки переменной пирога.
     *
     * @return boolean
     */
    public function check()
    {
        if (isset($_COOKIE[$name]))
            return true;
        return false;
    }    

    
    protected function _set()
    {
        setcookie($this->_name, $this->_value, $this->_expire, $this->_path, $this->_domain, $this->_secure);
    }
    
}