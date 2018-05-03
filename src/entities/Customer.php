<?php

declare(strict_types=1);

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Customer
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @var int
     */
    private $id;

    /**
     * @ORM\OneToMany(
     *     targetEntity=Server::class,
     *     mappedBy="customer",
     *     cascade={"persist"},
     *     indexBy="id"
     * )
     * @var Server[]|Collection
     */
    private $servers;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->servers = new ArrayCollection();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function addServer(Server $server) : void
    {
        $this->servers->set($server->getId(), $server);
    }

    public function removeServer(Server $server) : void
    {
        $this->servers->remove($server->getId());
    }

    /**
     * @return Collection|Server[]
     */
    public function getServers() : Collection
    {
        return $this->servers;
    }
}
