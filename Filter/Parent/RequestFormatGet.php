<?php
/**
*   Родительский абстрактный класс для ряда классов работы с массивом $_GET[]
*	Класс для инициилизации и фильтрования управляющих входных параметров
* 
* ---------------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: RequestFormatGet.php                             |
* | В библиотеке: Dune/Filter/Parent/RequestFormatGet.php  |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>            |
* | Версия: 1.01                                           |
* | Сайт: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
*
* Версия 1.00 -> 1.01
* ----------------------
*  Устранена ошибка. Числовые данные = 0 интерпретировались как отсутствие данных
* 
*/

abstract class Dune_Filter_Parent_RequestFormatGet
{

    protected $value;
    protected $have = false;
    
    /**
     * Хранит значение по умолчанию
     *
     * @var mixed
     */
    protected $defaultValue;
    
    protected function __construct($name, $def = '')
    {
    	$this->defaultValue = $def;
    	
      	if (empty($_GET[$name]))
      	{
       		$this->value = $this->defaultValue;
      	}
       	else 
       	{
            $this->makeFilter(trim($_GET[$name]));
            if ($this->value !== '')
            {
                $this->have = true;
            }
            else 
                $this->value = $this->defaultValue;
       	}
    }
    
    // Проверка на соответствие ключа фильтра предустановленным
    protected function makeFilter($value)
    {
        $this->value = $value;
    }
    
    public function get()
    {
    	return $this->value;
    }
    
    public function have()
    {
    	return $this->have;
    }

}