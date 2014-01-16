<?php
/**
 * Результат выполнения запроса (итератор).
 * Итератор с массовом по одному столбцу в результате запроса.
 * 
 * -------------------------------------------------------
 * | Библиотека: Dune                                     |
 * | Файл: ResultCol.php                                  |
 * | В библиотеке: Dune/Mysql/Iterator/ResultCol.php     |
 * | Автор: Андрей Рыжов (Dune) <dune@rznlf.ru>           |
 * | Версия: 1.00                                         |
 * | Сайт: www.rznlf.ru                                   |
 * -------------------------------------------------------
 *
 */

class Dune_Mysqli_Iterator_ResultCol extends Dune_Mysql_Iterator_Parent_Result
{
    protected function getEl()
    {
        $r = mysql_fetch_row($this->result);
        return $r[0];
    }
}
