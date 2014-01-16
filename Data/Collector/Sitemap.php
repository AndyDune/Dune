<?php
/**
 * ��������� ����� �������.
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                       |
 * | ����: Sitemap.php                                      |
 * | � ����������: Dune/Data/Colletor/Sitemap.php           |
 * | �����: ������ ����� (Dune) <dune@rznw.ru>              |
 * | ������: 1.00                                           |
 * | ����: www.rznw.ru                                      |
 * ---------------------------------------------------------
 *
 * ������� ������:
 *
 * 
 */
class Dune_Data_Collector_Sitemap
{
 
    protected $_string_1 = '<?xml version="1.0" encoding="';
    protected $_string_2 = '"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';    
    protected $_stringEnd = '</urlset>';
    
    protected $_stringCollector = '';
    /**
     * ��������� ������ - ���������
     *
     * @var string
     * @access private
     */
    protected $_encodingSourse = 'windows-1251';
    
    /**
     * ��������� ������ - ����������
     *
     * @var string
     * @access private
     */
    protected $_encoding = 'UTF-8';
    
    /**
     * @access private
     */
    protected $_domain = 'http://www.rzn.info';
    
    const ENC_WINDOWS1251 = 'windows-1251';
    const ENC_UTF8 = 'UTF-8';
    
    public static $isExeption = true;    
    
    /**
     * ����������� 
     * 
     * ��� �������� ��������� ��������� � ���������� ����������� ��������������� ��������� ������.
     * 
     * @param string $encoding_source ��������� ������
     * @param string $encoding ��������� ��������������� �����
     */
    public function __construct($encoding = 'windows-1251', $encoding_source = 'windows-1251')
    {
        $this->_encodingSourse = $encoding_source;
        $this->_encoding = $encoding;
    }    
    
    
    public function setDomain($value)
    {
        $this->_domain = 'http://' . rtrim($value, '/');
    }

    public function set($loc, $lastmod = null, $changefreq = 'hourly', $priority = null)
    {
        $this->_stringCollector .= '<url><loc>' . $this->_domain . '/' . ltrim($loc, '/');
        $this->_stringCollector .= '</loc>';
        if (!is_null($lastmod))
        {
            $this->_stringCollector .= '<lastmod>' . $lastmod . '</lastmod>';
        }
        if (!is_null($changefreq))
        {
            $this->_stringCollector .= '<changefreq>' . $changefreq . '</changefreq>';
        }
        if (!is_null($priority))
        {
            $this->_stringCollector .= '<priority>' . $priority . '</priority>';
        }
        
        $this->_stringCollector .= '</url>';
    }
    
    /**
     * ���������� ���� ���� � ���������� � ��������������� ������.
     *
     * @return sting
     */
    public function get()
    {
        $str =  $this->_string_1 . $this->_encoding . $this->_string_2 . $this->_stringCollector . $this->_stringEnd;        
        if ($this->_encodingSourse != $this->_encoding)        
        {
            $str_new = iconv($this->_encodingSourse, $this->_encoding, $str);
            $str = $str_new;
        }
        return $str;
    }

    
    
}