<?
/**
 * Экспериментальный
 * Класс контейне данных. Ряд ключей для кеширования. 
 * 
 * 
 *	 
 * --------------------------------------------------------
 * | Библиотека: Dune                                      |
 * | Файл: CacheKey.php                                    |
 * | В библиотеке: Dune/Data/Container/CacheKey.php        |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>            |
 * | Версия: 0.05                                          |
 * | Сайт: www.rznlf.ru                                    |
 * --------------------------------------------------------
 * 
 */

class Dune_Data_Container_CacheKey
{
    /**
     * Пространство ключей.
     * При кешировании в файлы - имя подпапки для файла кеша
     * При кешировании в dbm - имя базы
     * 
     * @var string
     */
    public $space;
    
    /**
     * Ключ для кеширования
     * При кешировании в файлы - имя файла (или часть его)
     * При кешировании в dbm - имя ключа в базе (или часть его)
     * 
     * @var string
     */
    public $key;
    
    /**
     * Модификатор ключа. Применяется, если необходимо закешировать постранично.
     *
     * @var mixed
     */
    public $modifier;
    
    public function __construct($space, $key, $modifier = '')
    {
        $this->space    = $space;
        $this->key      = $key;
        $this->modifier = $modifier;
    }
}