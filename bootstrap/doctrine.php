<?php
declare(strict_types=1);

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Doctrine\UuidType;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once __DIR__ . '/../vendor/autoload.php';

if (!Type::hasType('uuid')) {
    Type::addType('uuid', UuidType::class);
}

$paths = [__DIR__ . '/../src/Domain/Model'];

$config = new Configuration();

$metadataDriver = new AttributeDriver($paths);
$config->setMetadataDriverImpl($metadataDriver);

$cache = new ArrayAdapter();
$config->setMetadataCache($cache);
$config->setQueryCache($cache);

$config->setProxyDir(__DIR__ . '/../proxies');
$config->setProxyNamespace('App\\Proxies');
$config->setAutoGenerateProxyClasses(true);

$connectionParams = [
    'driver'   => 'pdo_mysql',
    'host'     => '127.0.0.1',
    'port'     => 3306,
    'dbname'   => 'fleet',
    'user'     => 'fleet_user',
    'password' => 'fleet_password',
    'charset'  => 'utf8mb4',
];

$connection = DriverManager::getConnection($connectionParams, $config);

return new EntityManager($connection, $config);

