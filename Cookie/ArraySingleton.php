<?php
/**
 * Dune Framework
 * 
 * Класс для работы с одной записью cookie как с массивом.
 * Наследует общий класс для работы с пиргами
 * Реализует ArrayAccess 
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: ArraySingleton.php                          |
 * | В библиотеке: Dune/Cookie/ArraySingleton.php      |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.08                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.08 (2008 ноябрь 12)
 * Добавлены магические методы __isset() и __unset()
 * 
 * Версия 1.07 (2008 ноябрь 10)
 * Устранение ошибки при уничтожении пирога.
 * 
 * Версия 1.05 -> 1.06
 * Исправлена ошибка миератора.
 * 
 * Версия 1.04 -> 1.05
 * Добавлен итератор.
 * Флаг криптования сделан статичным.
 * Добавленв методы: getArray(), count()
 * 
 * 
 * Версия 1.03 -> 1.04
 * Изменение: $hours и $domain в вызов класса включать необязательно - 
 * 
 * Версия 1.02 -> 1.03
 * Убрано часть ошибок (установка пустых куки - удаление, работа с пустой кукой, )
 * 
 * Версия 1.01 -> 1.02
 * Укорочены названия некоторых методов. Убрано исключение при считыванияя значения массива из пирога.
 * Введена функция интерфейса для вызова классом-регистратором объектов.
 * При выводе инф. о сущ пирга. учитывается: $this->cookieExists AND $this->isArray
 * 
 * Версия 1.00 -> 1.01
 * Возможно создать несколько объектов. Помещаются в массив, ключи от которого - имя записи пирога
 * 
 * 
 */

class Dune_Cookie_ArraySingleton extends Dune_Cookie_Parent_Base implements ArrayAccess, Dune_Interface_BeforePageOut, Iterator 
{
    /**
     * Имя пирога-массива
     *
     * @var string
     * @access private
     */
    protected $cookieName;
    
    /**
     * Флаг установки пирога
     *
     * @var boolean
     * @access private
     */
    protected $cookieExists = false;
    
    /**
     * Флаг корректного считывания пирога
     *
     * @var boolean
     * @access private
     */
    protected $isArray = false;
    
    /**
     * Флаг шифровки пирогов. true - шифруются
     *
     * @var boolean
     * @access private
     */
    static public $cryptCookie = false;
    
    /**
     * Флаг запуска метода doBeforePageOut()
     *
     * @var boolean
     * @access private
     */
    protected $doneBeforePageOut = false;
    
    /**
     * Регитсрация синглетонов
     *
     * @var array
     * @access private
     */
    static private $instance = array();   
     
   /**
    * Создаёт реализацию класса при первом вызове
    * Возвращает сохранённый указатель объекта при последующих вызовах
    *
    * @param string $fileName
    * @return Dune_Cookie_ArraySingleton
    */
    static function getInstance($name, $hours = null, $domain = null, $path = "/", $secure = 0)
    {
        if (!array_key_exists($name, self::$instance))
        {
            if ($hours == null)
                $hours = Dune_Parameters::$cookieLifeTime;
            if ($domain == null)
                $domain = Dune_Parameters::$cookieSiteDomain;
            
            self::$instance[$name] = new Dune_Cookie_ArraySingleton($name, $hours, $domain, $path, $secure);
        }
        return self::$instance[$name];
    }

    
        
    protected function __construct($name, $hours, $domain, $path, $secure)
    {
        // Смотрим флаг шифрования пирога в файле настроек
        self::$cryptCookie = Dune_Parameters::$cookieMcript;

        $this->cookieName = $name;
        if (array_key_exists($name,$_COOKIE))
        {
            $this->cookieExists = true;
            if (self::$cryptCookie)
            {
                $this->getCryptCookie();
            }
            else 
            {
                $this->getCookie();
            }
            //$this->cookieExists = $this->isArray;
        }
        parent::__construct($hours, $domain, $path, $secure);  
     }
    
    
    /**
     * Проверка существования пирога. Даже если десериализовать не удалось
     *
     * @param string $name имя пирога
     * @return boolean
     */
    public function isExist()
    {
        return $this->cookieExists;
    }

    
    /**
     * Проверка корректного считывания пирога
     *
     * @param string $name имя пирога
     * @return boolean
     */
    public function isCorrect()
    {
        return $this->isArray;
    }

    /**
     * Количество элементов в массива из пирога.
     *
     */
    public function count()
    {
        return count($this->cookieArray);
    }

    /**
     * Выбора всего массива
     *
     */
    public function getArray()
    {
        return $this->cookieArray;
    }
    
    
    /**
     * Удаление пирога
     *
     */
    public function clear()
    {
        // Устаревает пирог
        setcookie($this->cookieName, '', 0, $this->path, $this->domain, $this->secure);
        // Удаляет только содержимое пирога
        //setcookie($this->cookieName);
        $this->isArray = false;
        $this->cookieArray = array();
        $this->cookieExists = false;
    }
    /**
     * Установка пирога-массива
     *
     */
    public function set()
    {
        if (self::$cryptCookie)
        {
            $this->setCryptCookie();
        }
        else 
        {
            $this->setCookie();
        }
    }

    /**
     * Реализация метода интерфейса Dune_Interface_BeforePageOut.
     * 
     * Действие после работы скрипта, перед выводом страницы.
     *
     */
    public function doBeforePageOut()
    {
        // Если массив есть и выполнение происходит 1-й раз
        if (!$this->doneBeforePageOut)
        {
            $this->set();
            $this->doneBeforePageOut = true;
        }
    }
///////////////////////////////////////////////////////////////
////////////        Закрытые методы    
    protected function getCookie()
    {
        $str_array = urldecode($_COOKIE[$this->cookieName]);
        $this->cookieArray = @unserialize($str_array);
        if (is_array($this->cookieArray))
            $this->isArray = true;
        else 
            $this->cookieArray = array();
    }
    
    protected function getCryptCookie()
    {
        $str_array = Dune_Encrypt_McryptCookie::decrypt(urldecode($_COOKIE[$this->cookieName]));
        $this->cookieArray = @unserialize($str_array);
        if (is_array($this->cookieArray))
            $this->isArray = true;
        else 
            $this->cookieArray = array();
    }
    
    protected function setCryptCookie()
    {
        if (count($this->cookieArray) > 0)
        {
            $str_array = serialize($this->cookieArray);
            $str_array = urlencode(Dune_Encrypt_McryptCookie::encrypt($str_array));
            setcookie($this->cookieName, $str_array, $this->expires, $this->path, $this->domain, $this->secure);        
        }
        else 
        {
            $this->clear();
        }
    }
    protected function setCookie()
    {
        if (count($this->cookieArray) > 0)
        {
            $str_array = urlencode(serialize($this->cookieArray));
            setcookie($this->cookieName, $str_array, $this->expires, $this->path, $this->domain, $this->secure);
        }
        else 
        {
            $this->clear();
        }
    }
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы

    public function __toString()
    {
    	$string = '<pre>';
    	ob_start();
    	print_r($this->cookieArray);
    	$string .= ob_get_clean();
    	return  '</pre>' . $string;
    }


    /**
     * Поддержка isset() перегружено в PHP 5.1
     *
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->cookieArray[$name]);
    }

    /**
     * Поддержка unset() перегружено в PHP 5.1
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        unset($this->cookieArray[$name]);
    }
    
    
    public function __set($name, $value)
    {
        $this->cookieArray[$name] = $value;
    }
    public function __get($name)
    {
        if (!key_exists($name,$this->cookieArray))
            return false;
        return $this->cookieArray[$name];
    }
/////////////////////////////
////////////////////////////////////////////////////////////////
    
    
////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->cookieArray);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->cookieArray))
            //throw new Exception('Ошибка чтения значения массива: ключа '.$key.' не существует');
            return false;
        return $this->cookieArray[$key];
    }
    
    public function offsetSet($key, $value)
    {
        $this->cookieArray[$key] = $value;
    }
    public function offsetUnset($key)
    {
        unset($this->cookieArray[$key]);
    }

/////////////////////////////
////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса Iterator
  // устанавливает итеретор на первый элемент
  public function rewind()
  {
        return reset($this->cookieArray);
  }
  // возвращает текущий элемент
  public function current()
  {
      return current($this->cookieArray);
  }
  // возвращает ключ текущего элемента
  public function key()
  {
    return key($this->cookieArray);
  }
  
  // переходит к следующему элементу
  public function next()
  {
    return next($this->cookieArray);
  }
  // проверяет, существует ли текущий элемент после выполнения мотода rewind или next
  public function valid()
  {
    return isset($this->cookieArray[key($this->cookieArray)]);
  }    
/////////////////////////////
////////////////////////////////////////////////////////////////    
    
    
}