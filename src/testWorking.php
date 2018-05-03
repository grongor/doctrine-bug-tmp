<?php

use Doctrine\ORM\EntityManagerInterface;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var EntityManagerInterface $entityManager */
$entityManager = require_once 'prepareDatabase.php';

/** @var Customer $customer1 */
$customer1 = $entityManager->createQueryBuilder()
    ->select('c')
    ->from(Customer::class, 'c')
    ->where('c.id = 1')
    ->getQuery()
    ->getSingleResult();

$servers = $customer1->getServers();
assert(count($servers) === 2);
$server1 = $servers[1];
$server2 = $servers[2];
assert($server1->getCustomer() === $customer1);
assert($server2->getCustomer() === $customer1);

foreach ($customer1->getServers() as $server) {
    $customer1->removeServer($server);
    $server->setCustomer(null);
}

assert(count($customer1->getServers()) === 0);
assert($server1->getCustomer() === null);
assert($server2->getCustomer() === null);

$entityManager->flush();

$serversScalar = $entityManager->getConnection()->executeQuery('
    SELECT id, customer_id
    FROM server
    ORDER BY id
')->fetchAll(PDO::FETCH_KEY_PAIR);

assert($serversScalar === [
    1 => null,
    2 => null,
]);
