<?php
include __DIR__."/appConfig.php";
// bootstrap.php
use Doctrine\ORM\Tools\Setup,
Doctrine\ORM\EntityManager,
Doctrine\ORM\Configuration,
Doctrine\Common\Cache\ArrayCache as Cache,
Doctrine\Common\Annotations\AnnotationRegistry,
Doctrine\Common\ClassLoader;

//autoloading
require_once __DIR__ . '/vendor/autoload.php';
$loader = new ClassLoader('Entity', __DIR__ . '/library');
$loader->register();
$loader = new ClassLoader('EntityProxy', __DIR__ . '/library');
$loader->register();

$config = new Configuration();
$cache = new Cache();
$config->setQueryCacheImpl($cache);
$config->setProxyDir(__DIR__ . '/library/EntityProxy');
$config->setProxyNamespace('EntityProxy');
$config->setAutoGenerateProxyClasses(true);

//mapping (example uses annotations, could be any of XML/YAML or plain PHP)
AnnotationRegistry::registerFile(__DIR__ . '/vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');
$driver = new Doctrine\ORM\Mapping\Driver\AnnotationDriver(
	new Doctrine\Common\Annotations\AnnotationReader(),
	array(__DIR__ . '/library/Entity')
);
$config->setMetadataDriverImpl($driver);
$config->setMetadataCacheImpl($cache);

$em = EntityManager::create($appConfig['dbconfig'],
$config );