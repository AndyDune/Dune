<?php
/**
 * ����� ��� ������ � ����������� �������
 * 
 * ----------------------------------------------------
 * | ����������: Dune                                  |
 * | ����: One.php                                     |
 * | � ����������: Dune/Cookie/One.php                 |
 * | �����: ������ ����� (Dune) <dune@pochta.ru>       |
 * | ������: 1.00                                      |
 * | ����: www.rznw.ru                                 |
 * ----------------------------------------------------
 *
 * ������� ������:
 * -----------------
 * 
 * ������ 1.00 -> 1.01
 */

class Dune_Cookie_One extends Dune_Cookie_Parent_One
{
    
    public function __construct($name)
    {
        $this->_name = $name;
    }
}