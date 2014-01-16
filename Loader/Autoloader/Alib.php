<?php

/*
 * Загрузка класса-компонета
 *
 * История:
 *  2011-012-10 Создан
 */
class Dune_Loader_Autoloader_Alib
{
    protected $_dir = '';
    public function __construct()
    {
        //$reg        = Zend_Registry::getInstance();
        //$this->_dir = $reg->get('dir');
        $this->_dir = APPLICATION_PATH_VAR . '/library/';
    }


    /**
     *
     *
     *
     * @param <type> $name
     * @return <type>
     */
    public function check($name)
    {
        $parts = explode('\\', $name);
        if ($parts[0] != 'Alib')
        {
            return false;
        }
        $file = $this->_dir
                . implode('/', $parts)
                . '.php';
//        echo '<br />', $file;
        if (!is_file($file))
            return false;
        require $file;
        return true;
    }
}




