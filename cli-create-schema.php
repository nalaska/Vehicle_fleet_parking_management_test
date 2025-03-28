<?php

declare(strict_types=1);
use Doctrine\ORM\Tools\SchemaTool;

require_once __DIR__ . '/vendor/autoload.php';

$entityManager = require __DIR__ . '/bootstrap/doctrine.php';
$schemaTool = new SchemaTool($entityManager);

$classes = $entityManager->getMetadataFactory()->getAllMetadata();
$schemaTool->updateSchema($classes);

echo 'Schema updated successfully.';
