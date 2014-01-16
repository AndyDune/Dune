<?php
/**
 * Основное исключение библиотеки
 *
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Base.php                                    |
 * | В библиотеке: Dune/Exception/Base.php             |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.02                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 1.02 (2009 сентябрь 28)
 * Устранение ошибки приема кода. !! Критично.
 * 
 */
class Dune_Exception_Base extends Exception 
{
//    protected $trace;
    
//    public function getTrace()
//    {
//        return $this->trace;
//    }
    public function __construct($string = '', $code = 0)
    {
        parent::__construct($string, $code);
    }
}