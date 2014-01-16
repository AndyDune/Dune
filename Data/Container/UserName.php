<?
/**
 * Класс контейне данных. Содержит 3 копии имени пользователя.
 * 
 *	Защита имени пользователя от подделки.
 *  Методом замены латинских букв похожими русскими и наоборот.
 * 
 *	 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: UserName.php                                |
 * | В библиотеке: Dune/Data/Container/UserName.ph     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>        |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznlf.ru                                |
 * ----------------------------------------------------
 * 
 */

class Dune_Data_Container_UserName implements ArrayAccess
{
  private $array = array();
    
  // Массив русских букв
  private $rus = array("А", "а", "В", "Е", "е", "К", "М", "Н", "О", "о", "Р",
                       "р", "С", "с", "Т", "Х", "х");
  // Массив английских букв
  private $eng = array("A", "a", "B", "E", "e", "K", "M", "H", "O", "o", "P",
                       "p", "C", "c", "T", "X", "x");
                       
  public function __construct($name)
  {
      $this->array['original'] = $name;
      $this->array['russian'] = str_replace($this->eng, $this->rus, $name);
      $this->array['english'] =  str_replace($this->rus, $this->eng, $name);
  }
  

////////////////////////////////////////////////////////////////
///////////////////////////////     Методы интерфейса ArrayAccess
    public function offsetExists($key)
    {
        return key_exists($key,$this->array);
    }
    public function offsetGet($key)
    {
        if (!key_exists($key,$this->array))
          throw new Dune_Exception_Base('Ошибка чтения переменной: ключа '.$key.' не существует. Существуют: original, russian, english');
          //return false;
        return $this->array[$key];
    }
    
    public function offsetSet($key, $value)
    {
        throw new Dune_Exception_Base('Зарещено менять значение переменных');
    }
    public function offsetUnset($key)
    {
        throw new Dune_Exception_Base('Зарещено менять значение переменных');
    }

/////////////////////////////
////////////////////////////////////////////////////////////////
  
  
////////////////////////////////////////////////////////////////
///////////////////////////////     Магические методы

    public function __set($key, $val)
    {
        throw new Dune_Exception_Base('Зарещено менять значение переменных');
    }
    public function __get($key)
    {
        if (!key_exists($key,$this->array))
            throw new Dune_Exception_Base('Ошибка чтения переменной: '.$key.' не существует. Существуют: original, russian, english');
        return $this->array[$key];
    }
    
}