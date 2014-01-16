<?php

/*
 * Загрузка класса-компонета
 *
 * История:
 *  2011-012-10 Создан
 */
class Dune_Loader_Autoloader_Application
{
    protected $_dir = '';
    
    protected $_types = array(
        'component' => 'components',
        'model'     => 'models',
        'Component' => 'components',
        'Model'     => 'models',
        'Library'   => 'library',
        'Record'    => 'records',
        'ControllerHelper' => 'controllers/helpers',
        'ViewHelper'       => 'views/helpers',
        'View'             => 'views/helpers',
        'Admin'            => 'admin/controller',
    );
    
    public function __construct()
    {
        //$reg        = Zend_Registry::getInstance();
        //$this->_dir = $reg->get('dir');
        $this->_dir = APPLICATION_PATH_VAR . '/modules/';
    }


    /**
     *
     * namespace rzn\lib\www\Db_Factory
     *
     * 0 - Application
     * 1 - Www (имя модуля с большой буквы)
     * 3 - Тип ресурса (Model, Library)
     * 4 - Db_Factory (имя класса)
     *
     *
     * @param <type> $name
     * @return <type>
     */
    public function check($name)
    {
        $parts = explode('\\', $name);
        if (count($parts) < 4 or $parts[0] != 'Application')
        {
            return false;
        }
        //echo $name, '<br>';
        array_shift($parts);
        $module = array_shift($parts);
        $type   = array_shift($parts);


        if ($type == 'View')
            array_shift($parts);

        $file = $this->_dir
                . $module
                . '/'
                . $this->_pathToType($type)
                . '/' 
                . $this->_pathToClass($parts)
                . '.php';
        
        //\Alib\Test::pr($parts);
        //echo '<br />', $file;
        if (!is_file($file))
            return false;
        require $file;
        return true;
    }
    
    protected function _pathToType($type)
    {
        return $this->_types[$type];
    }
    
    protected function _pathToClass($parts)
    {
        if (count($parts) > 0)
        {
            //if (current($parts) == 'Helper')
            //    array_shift($parts);

            return implode('/', $parts);
        }
        return str_replace('_', '/', $parts);
    }
    
}



