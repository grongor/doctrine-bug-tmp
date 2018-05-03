<?php

declare(strict_types=1);

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Server
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="servers")
     * @var Customer|null
     */
    private $customer;

    public function __construct(int $id, ?Customer $customer = null)
    {
        $this->id = $id;

        $this->setCustomer($customer);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getCustomer() : ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer) : void
    {
        $this->customer = $customer;
    }
}
