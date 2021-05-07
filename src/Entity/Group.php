<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
     /**
     * @OneToMany(targetEntity="User", mappedBy="group")
     */
    private $users;
    
    
    public function __construct() {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    
    
    public function addUser(User $user)
    { 
        $this->users -> add($user);
        $user->setGroup($this);

    }
    
    public function removeUser(User $user)
    {    
        $this->users->removeElement($user);
    }
    
    public function getUsers()
    {
        $array = $this->users->toArray();
        return $array;
    }
        
}
