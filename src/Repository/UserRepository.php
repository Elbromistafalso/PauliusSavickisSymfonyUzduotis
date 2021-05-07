<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct
    (
        ManagerRegistry $registry,
        EntityManagerInterface $manager
    )
    {
        parent::__construct($registry, User::class);
        $this->manager = $manager;
    }


    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function findUserByName($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.name = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    
    public function saveUser($name)
    {
            
        $newUser = new User();

        $newUser
            ->setName($name);

        $this->manager->persist($newUser);
        $this->manager->flush();
    }
    
    public function transform(User $user)
    {
        
         return [
            'name'    => (string) $user->getName()
         ];
    }

    public function transformAll()
   {
        
         $users = $this->findAll();
         $usersArray = [];

         foreach ($users as $user) {
           $usersArray[] = $this->transform($user);
        }

         return $usersArray;
    }
    
    public function removeUser(User $user)
    {
        
    $this->manager->remove($user);
    $this->manager->flush();
        
    }
    
}
