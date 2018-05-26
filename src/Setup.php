<?php namespace NumberInterpreter;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Translation\Loader\YamlFileLoader;

class Setup
{
    public static $container;
    
    public static function init()
    {
        self::$container = new ContainerBuilder();
        self::$container->setParameter('translator.language', 'nl_NL');
        
        self::initTranslator();
    }

    public static function initTranslator()
    {
        self::$container->register('translator', '\Symfony\Component\Translation\Translator')
                        ->addArgument('%translator.language%')
                        ->addMethodCall('addLoader', ['yaml', new YamlFileLoader()])
                        ->addMethodCall('addResource', ['yaml', 'translations/messages.%translator.language%.yaml', '%translator.language%'])
            ;
        
    }
}