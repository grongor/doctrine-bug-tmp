<?php

use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;

$connectionConfig = [
    'url' => 'pgsql://root:root@postgres',
];

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration([__DIR__ . '/entities'], $isDevMode, null, null, false);

$entityManager = EntityManager::create($connectionConfig, $config);
$connection = $entityManager->getConnection();

$dropTables = $connection->executeQuery('
    SELECT \'drop table if exists "\' || tablename || \'" cascade;\'
    FROM pg_tables
    WHERE schemaname = \'public\'
')->fetchAll(PDO::FETCH_COLUMN);
foreach ($dropTables as $dropTable) {
    $connection->executeUpdate($dropTable);
}

$schemaTool = new SchemaTool($entityManager);
$schemaTool->createSchema($entityManager->getMetadataFactory()->getAllMetadata());

$customer1 = new Customer(1);
$server1 = new Server(1, $customer1);
$server2 = new Server(2, $customer1);

$entityManager->persist($customer1);
$entityManager->persist($server1);
$entityManager->persist($server2);
$entityManager->flush();

$entityManager->getConfiguration()->setSQLLogger(new class implements SQLLogger {
    public function startQuery($sql, array $params = null, array $types = null)
    {
        echo $sql . PHP_EOL;
        if ($params) {
            var_export($params);
            echo PHP_EOL;
        }
    }

    public function stopQuery()
    {
    }
});

$entityManager->clear();

return $entityManager;
