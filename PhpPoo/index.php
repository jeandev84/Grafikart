<?php
namespace Framework;


/**
 * Class Application
 * @package Framework
*/
class Application
{

    /** @var array */
    private $container;


    /** @var Application */
    private static $instance;


    /**
     * Application constructor.
     * @param string $rootPath
    */
    private function __construct(string $rootPath)
    {
        $this->bind('project_root', $rootPath);
    }

    /**
     * @param string $rootPath
     * @return Application
    */
    public static function instance(string $rootPath)
    {
       if(is_null(self::$instance))
       {
           self::$instance = new self($rootPath);
       }
       return self::$instance;
    }


    /**
     * @param string $key
     * @param mixed $resolver
    */
    public function bind(string $key, $resolver)
    {
        $this->container[$key] = $resolver;
    }

    /** Run Application */
    public function run()
    {
        echo '<pre>'. print_r($this->container, true) . '</pre>';
        echo 'Application runned!';
    }
}


$app = Application::instance(__DIR__.'/');
$app->bind('db', 'DatabaseConnection::class');
$app->run();