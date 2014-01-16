<?php
/*
 * Автозагрузка необычных классов.
 * Собственная автозагрузка классов/
 */

class Dune_Loader_Autoloader implements Zend_Loader_Autoloader_Interface
{

    protected $_autoloaders = null;


    public function  __construct($autoloaders = array())
    {
        $this->_autoloaders = $autoloaders;
    }

    /**
     * Autoload a class
     *
     * @abstract
     * @param   string $class
     * @return  mixed
     *          False [if unable to load $class]
     *          get_class($class) [if $class is successfully loaded]
     */
    public function autoload($class)
    {
//        echo $class;
        foreach($this->_autoloaders as $value)
        {
            if ($value->check($class))
                return true;
        }
        return false;
    }
}
