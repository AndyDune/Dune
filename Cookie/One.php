<?php
/**
 * Класс для работы с перемиенной пимрога
 * 
 * ----------------------------------------------------
 * | Библиотека: Dune                                  |
 * | Файл: One.php                                     |
 * | В библиотеке: Dune/Cookie/One.php                 |
 * | Автор: Андрей Рыжов (Dune) <dune@pochta.ru>       |
 * | Версия: 1.00                                      |
 * | Сайт: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * История версий:
 * -----------------
 * 
 * Версия 1.00 -> 1.01
 */

class Dune_Cookie_One extends Dune_Cookie_Parent_One
{
    
    public function __construct($name)
    {
        $this->_name = $name;
    }
}