<?php
/**
 * Анализирует входную строку (число) и создаёт единицы вркмени (год, месяц...)
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: Date.php                                    |
 * | В библиотеке: Dune/Data/Parsing/Date.php          |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 0.95                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * Версия 0.95 (2009 декабрь 17)
 * Возврат секунд юникса.
 * 
 * Версия 0.94 (2009 ноябрь 19)
 * Возможность возврата всех данных без ведущих нулей
 * 
 * Версия 0.93 (2009 октябрь 14)
 * Заполнение переменных часа, минуты, секунды нулями при отсутствии во входных данных.
 * Выборка опцилнално дня месяца
 * 
 * Версия 0.92 (2009 сентябрь 10)
 * Добавлена возможность работы с данными TIMESTAMP
 * 
 * Версия 0.91 (2009 июнь 29)
 * Выбор имени месаца в 3-х падежах: январь, января, январе
 * 
 * 
 * 
 */
class Dune_Data_Parsing_Date
{

	/**
	 * Данные для обработки
	 *
	 * @var mixed
	 * @access private
	 */
	protected $_source;
	
	/**
	 * @var string
	 * @access private
	 */
	protected $_type;
	
	const TYPE_DATE 	 = 'DATE';
	const TYPE_TIME		 = 'TIME';
	const TYPE_DATATIME  = 'DATATIME';
	const TYPE_TIMESTAMP = 'TIMESTAMP';

	/**
	 * @var string
	 * @access private
	 */
	protected $_year = '';

	/**
	 * @var string
	 * @access private
	 */
	protected $_month = '';

	/**
	 * @var string
	 * @access private
	 */
	protected $_day = '';
	
	/**
	 * @var string
	 * @access private
	 */
	protected $_hour = '00';

	
	/**
	 * @var string
	 * @access private
	 */
	protected $_minute = '00';

	/**
	 * @var string
	 * @access private
	 */
	protected $_second = '00';
	

	/**
	 * @var integer
	 * @access private
	 */
	protected $_unix = 0;

	/**
	 * @var boolean
	 * @access private
	 */
	protected $_parsed = false;
	
	
	/**
	 * @var string
	 * @access private
	 */
	protected $_monthName = array(
	                               0 => array(1 => 'месяц', 'месяца', 'месяце'),
	                               1 => array(1 => 'январь', 'января', 'январе'),
	                               2 => array(1 => 'февраль', 'февраля', 'феврале'),
	                               3 => array(1 => 'март', 'марта', 'марте'),
	                               4 => array(1 => 'апрель', 'апрелья', 'апреле'),
	                               5 => array(1 => 'май', 'мая', 'мае'),
	                               
	                               6 => array(1 => 'июнь', 'июня', 'июне'),
	                               7 => array(1 => 'июль', 'июля', 'июле'),
	                               8 => array(1 => 'август', 'августа', 'августе'),
	                               9 => array(1 => 'сентябрь', 'сентября', 'сентябре'),
	                               10 => array(1 => 'октябрь', 'октября', 'октябре'),
	                               11 => array(1 => 'ноябрь', 'ноября', 'ноябре'),
	                               12 => array(1 => 'декабрь', 'декабря', 'декабре'),
	                              );
	
	
	
	public function __construct($source, $type = 'DATATIME')
	{
	    if ($type == self::TYPE_TIMESTAMP)
	    {
	        $this->_source = date('Y-m-d H:i:s', $source);
	        $this->_unix = $source;	        
	    }
	    else
        {
		  $this->_source = $source;
        }
	    $this->_type = self::TYPE_DATATIME;
	}
	
	public function getYear($part = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($part)
	       return substr($this->_year, 2, 2);
        return $this->_year;	    
	}

	public function getMonth($no_zero = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($no_zero)
            return (int)$this->_month;	    
        return $this->_month;	    
	}
	
	
	public function getMonthName($key = 1)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
        return $this->_monthName[(int)$this->_month][$key];
	}
	
	
	public function getDay($no_zero = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($no_zero)
            return (int)$this->_day;	    
        return $this->_day;
	}

	public function getHour($no_zero = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($no_zero)
            return (int)$this->_hour;	    
        return $this->_hour;
	}

	public function getMinute($no_zero = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($no_zero)
            return (int)$this->_minute;	    
        return $this->_minute;
	}
	
	public function getSecond($no_zero = false)
	{
	    if (!$this->_parsed)
	    {
	        $this->parse();
	    }
	    if ($no_zero)
            return (int)$this->_second;
        return $this->_second;
	}

	
	public function getTimeStamp()
	{
	   if (!$this->_unix)
	   {
           $this->parse();
	       $this->_unix = mktime((int)$this->_hour, (int)$this->_minute, (int)$this->_second, (int)$this->_month, (int)$this->_day, (int)$this->_year);
	   }
	   return $this->_unix;
	}	
/////////////////////////////////////////////////////////////////////
/////////       Защтщённые методы
////////////////////////////////////////////////////////////////////	
	/**
	 * @access private
	 */
	protected function parse()
	{
        switch ($this->_type)   
	    {
	       case self::TYPE_DATATIME:
	           $this->parseDate();
	           $this->parseTime();
	       break;
	       case self::TYPE_DATE :
	           $this->parseDate();
	       break;
	       case self::TYPE_TIME:
	           $this->parseTime();
	    }
//	       $this->_unix = mktime($this->_hour, $this->_minute, $this->_second, $this->_month, $this->_day, $this->_year);
	}

	/**
	 * @access private
	 */
	protected function parseTimeStamp()
	{
	    $array = getdate($this->_source);
	    $this->_year = $array['year'];
	    $this->_month = $array['mon'];
 	    $this->_day = $array['mday'];
	    $this->_hour = $array['hour'];
	    $this->_minute = $array['minute'];
	    $this->_second = $array['second'];
	    $this->_unix = $array[0];
	}

	/**
	 * @access private
	 */
	protected function parseDate()
	{
	    $pos1 = strpos($this->_source, '-');
	    
	    if ($pos1 === false)
	       throw new Dune_Exception_Base('Ошибка выборки временных параметров из свтроки');
	    $pos1 = $pos1 + 1;
	    $pos2 = strpos($this->_source, '-', $pos1) + 1;

	       
	    $this->_year = substr($this->_source, 0, 4);
	    $this->_month = substr($this->_source, $pos1, 2);
 	    $this->_day = substr($this->_source, $pos2, 2);
	}


	/**
	 * @access private
	 */
	protected function parseTime()
	{
	    $pos1 = strpos($this->_source, ':');
	    if ($pos1 === false)
	    {
//	        throw new Dune_Exception_Base('Ошибка выборки временных параметров из строки');	        
    	    $this->_hour = '00';
    	    $this->_minute = '00';
     	    $this->_second = '00';
     	    return false;
	    }
	    $pos1 = $pos1 + 1;
	    $pos2 = strpos($this->_source, ':', $pos1) + 1;
	    $this->_hour = substr($this->_source, $pos1 - 3, 2);
	    $this->_minute = substr($this->_source, $pos1, 2);
 	    $this->_second = substr($this->_source, $pos2, 2);
	}
	
}