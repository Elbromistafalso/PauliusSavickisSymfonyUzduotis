<?php

namespace App\Repository;

use App\Entity\Group;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, Group::class);
        $this->manager = $manager;
    }

    // /**
    //  * @return Group[] Returns an array of Group objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Group
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    
    public function saveGroup(){
        
        $newGroup = new Group();

        $this->manager->persist($newGroup);
        $this->manager->flush();
        
    }
    
    public function removeGroup(Group $group)
    {
        
        $this->manager->remove($group);
        $this->manager->flush();
    }
    
    
    public function addUser(Group $group, User $user){
        
        $group->addUser($user);
        $this->manager->persist($group);
        $this->manager->persist($user);
        $this->manager->flush();
    }
    
    public function transform(Group $group)
    {
        return [
            'id'    => (int) $group->getId()
    ];    
    }

    public function transformAll()
    {
        $groups = $this->findAll();
        $groupsArray = [];

        foreach ($groups as $group) {
            $groupsArray[] = $this->transform($group);
        }

    return $groupsArray;
}
}
