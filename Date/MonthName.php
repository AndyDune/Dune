<?php
/**
 * Формирование названия месяца от его порядкового номера.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: MonthName.php                               |
 * | В библиотеке: Dune/Build/MonthName.php            |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.01                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 *  Версия 1.01
 *  Фуекция trim() используется ерез посредника.
 * 
 */

class Dune_Date_MonthName
{
    
    protected $_number = null;
    protected $_arrayNames = array(
                                    1 => array(
                                                1 => 'январь',
                                                2 => 'января',
                                               ),
                                    2 => array(
                                                1 => 'февраль',
                                                2 => 'февраля',
                                               ),
                                    3 => array(
                                                1 => 'март',
                                                2 => 'марта',
                                               ),
                                    4 => array(
                                                1 => 'апрель',
                                                2 => 'апреля',
                                               ),
                                    5 => array(
                                                1 => 'май',
                                                2 => 'мая',
                                               ),
                                    6 => array(
                                                1 => 'июнь',
                                                2 => 'июня',
                                               ),
                                    7 => array(
                                                1 => 'июль',
                                                2 => 'июля',
                                               ),
                                    8 => array(
                                                1 => 'август',
                                                2 => 'августа',
                                               ),
                                    9 => array(
                                                1 => 'сентябрь',
                                                2 => 'сентября',
                                               ),
                                    10 => array(
                                                1 => 'октябрь',
                                                2 => 'октября',
                                               ),
                                    11 => array(
                                                1 => 'ноябрь',
                                                2 => 'ноября',
                                               ),
                                    12 => array(
                                                1 => 'декабрь',
                                                2 => 'декабря',
                                               ),
                                    13 => array(
                                                1 => false,
                                                2 => false,
                                               ),
                                               
                                  );
    /**
     * Конструктор.
     *
     * @param integer $number порядковый номер месяца
     */
    public function __construct($number)
    {
        $str = Dune_String_Factory::getStringContainer($number);
        $this->_number = (int)$str->trim(' 0');
        if ($this->_number < 1 or $this->_number > 12)
            $this->_number = 13;
    }
    
    /**
     * Возврат имени месяца
     *
     * @return string
     */
    public function get()
    {
        return $this->_arrayNames[$this->_number][1];
    }
    
    /**
     * Возврат имени месяца в родительном падеже.
     * Например: января, февраля
     *
     * @return string
     */
    public function getGenitive()
    {
        return $this->_arrayNames[$this->_number][2];
    }
    
}