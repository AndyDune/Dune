<?php
/**
 * Смена кодировок во всех файлах директории.
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: ConvertEncoding.php                         |
 * | В библиотеке: Dune/Directory/Delete.php           |
 * | Автор: Андрей Рыжов (Dune) <dune@rznw.ru>         |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 *
 * 1.02 (2008 апрель 15)
 * Удаление старых файлов в папке.
 * Удаление пустых старых папок.
 * 
 * 1.01 (2008 декабрь 05)
 * При удалении проверка на существование папки
 * 
 * 
 */


class Dune_Directory_ConvertEncoding
{

	protected $_directoryName = '';
	protected $_inCharset     = 'windows-1251';
	protected $_outCharset    = 'UTF-8';
	protected $_check         = false;
	
	protected $_isDir = false;
	protected $_nesting = 0;
	
	public function __construct($name)
	{
	    $this->_directoryName = $name;
	    if (is_dir($name))
	       $this->_isDir = true;
	}
	
	public function setInCharset($value)
	{
	    $this->_inCharset = $value;
	}
	public function setOutCharset($value)
	{
	    $this->_outCharset = $value;
	}
	
	/**
	 * Сделать конвертацию.
	 *
	 */
	public function make()
	{
	    ini_set('mbstring.substitute_character', "none");
	    if ($this->_isDir)
	    {
	        setlocale(LC_CTYPE ,'ru_RU'.'.UTF8');
mb_internal_encoding('UTF-8');
    	    $this->_do($this->_directoryName, true);
	    }
	    $this->_isDir = false;
	}

	
/**
 * Функция для перекодировки данных произвольной структуры из кодировки cp1251 в кодировку UTF-8.
 * Функция может работать без использования библиотеки iconv.
 *
 * @param   mixed  $data
 * @return  mixed
 *
 * @license  http://creativecommons.org/licenses/by-sa/3.0/
 * @author   Nasibullin Rinat <nasibullin at starlink ru>
 * @charset  ANSI
 * @version  1.0.1
 */
function cp1251_to_utf8_recursive(/*mixed*/ $data)
{
    if (is_array($data))
    {
        $d = array();
        foreach ($data as $k => &$v) $d[$this->cp1251_to_utf8_recursive($k)] = $this->cp1251_to_utf8_recursive($v);
        return $d;
    }
    if (is_string($data))
    {
        if (function_exists('iconv')) return iconv('cp1251', 'utf-8//IGNORE//TRANSLIT', $data);
//        if (! function_exists('cp1259_to_utf8')) include_once 'cp1259_to_utf8.php';
//        return cp1259_to_utf8($data);
    }
    if (is_scalar($data) or is_null($data)) return $data;
    #throw warning, if the $data is resource or object:
    trigger_error('An array, scalar or null type expected, ' . gettype($data) . ' given!', E_USER_WARNING);
    return $data;
}
	
	
	
	/**
	 * Удаляем с параметрами.
	 *
	 * @param string $dir имя директории.
	 * @return boolean
	 *
	 * @access private
	 */
    protected function _do($dir)
    { 
        $this->_nesting++;
        $handle = opendir($dir);  
        while (false !== ($file = readdir($handle)))  
        {  
            if ($file != "." && $file != "..")  
            {  
                $del_file = $dir . "/" . $file; 
                if(!is_dir($del_file))
                {
//$content=htmlentities(file_get_contents("incoming.txt"), ENT_QUOTES, "Windows-1252");
//file_put_contents("outbound.txt", html_entity_decode($content, ENT_QUOTES , "utf-8"));                    
                    
                    $str = file_get_contents($del_file);
                    $del_file_temp = $del_file . '_t';
//                    $out_str = mb_convert_encoding($str, $this->_outCharset, $this->_inCharset);
                    
                    $out_str = $this->cp1251_to_utf8_recursive($str);
                    
                    
                    file_put_contents($del_file_temp, $out_str);
                    if (unlink($del_file))
                    {
                        rename($del_file_temp, $del_file);
                    }
                }
                else
                { 
                    $this->_do($del_file);
                } 
             } 
         } 
         closedir($handle);  
         $this->_nesting--;
         return true;
    }	
    
    
    
}