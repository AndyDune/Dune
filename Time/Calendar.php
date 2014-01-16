<?php
/**
 * Календарные функции.
 */
class Dune_Time_Calendar
{
    protected $_month = null;
    protected $_year = null;


    public function __construct() 
    {
        
    }

    
    /**
     * Вычиление количества дней в месяце.
     * 
     * @param type $month
     * @param type $year
     * @return type 
     */
    public function daysInMonth($month = null, $year = null) 
    { 
        // calculate number of days in a month 
        return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31); 
    }     
    
}