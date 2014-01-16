<?php
/**
*   Родительский абстрактный класс для ряда классов работы с текстом
* 
* ---------------------------------------------------------
* | Библиотека: Dune                                       |
* | Файл: Containet.php                                    |
* | В библиотеке: Dune/Text/Parent/Containet.php           |
* | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>            |
* | Версия: 1.00                                           |
* | Сайт: www.rznlf.ru                                     |
* ---------------------------------------------------------
* 
*
* Версия 1.00 -> 1.01
* ----------------------
* 
*/

abstract class Dune_Text_Parent_Containet
{
    /**
     * Исходный текст
     *
     * @var string
     * @access private
     */
    protected $_text = '';
    
    /**
     * Результирующий текст
     *
     * @var string
     * @access private
     */
    protected $_textResult = '';
    
    /**
     * Текущая кодировка.
     *
     * @var string
     * @access private
     */
    protected $_coding = '';
    
    
    const ENC_UTF8 = 'utf-8';
    const ENC_WIN  = 'windows-1251';
    
    
    /**
     * Конструктор.
     *
     * @param string $text
     * @param string $coding кодировка, используйте константы класса
     */
    protected function __construct($text, $coding = 'windows-1251')
    {
    	$this->_text = $text;
    	$this->_coding = $coding;
    }
    

    /**
     * Установка формата текста.
     * Бывает: text и html
     *
     * @return string
     */
    public function setFormat($format = 'text')
    {
    	return $this->_textFormat = $format;
    }
    
    
    /**
     * Возвращает обработанный текст.
     *
     * @return string
     */
    public function get()
    {
    	return $this->_textResult;
    }
    
	public function replaceWindowsCodes()
	{
		$after = array('&#167;', '&#169;', '&#174;', '&#8482;', '&#176;', '&#171;', '&#183;',
				       '&#187;', '&#133;', '&#8216;', '&#8217;', '&#8220;', '&#8221;', '&#164;', '&#166;',
				       '&#8222;', '&#8226;', '&#8211;', $this->plusmn, $this->tire, $this->number, '&#8240;',
				       '&#8364;', '&#182;', '&#172;');

		$before = array('§', '©',  '®', '™',  '°', '«', '·',
			            '»', '…', '‘', '’', '“', '”', '¤', '¦',
			            '„', '•', '–', '±', '—', '№', '‰',
			            '€', '¶', '¬');

		$this->_text = str_replace($before, $after, $this->_text);
	}
    
    
}