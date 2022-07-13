<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->select('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
    public function findDate(int $id): array
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT trajet.date from trajet
                LEFT JOIN user on user.id = trajet.user_id
                    where user.id = :id
                 order by trajet.date desc limit 1
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['id' => $id]);

        // returns an array of arrays (i.e. a raw data set)

        return $resultSet->fetchAllAssociative();
//
//        $entityManager = $this->getEntityManager();
//
//        $query = $entityManager->createQuery(
//            'SELECT trajet.date from trajet
//                LEFT JOIN user on user.id = trajet.user_id
//                    where user.id = :id
//                 order by trajet.date desc limit 1'
//        )->setParameter('price', $price);
//
//        // returns an array of Product objects
//        return $query->getResult();
    }

    //TODO : function a finir, elle devra remplacer le totalkilometerAll dans dashboard/index.html.twig pour eviter les erreurs de calcule du nombre de kil
    public function nombreKilometreAll(){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT  SUM(total_kilometre) as total from App\Entity\User'
        );

        // returns an array of Product objects
        return $query->getResult();

    }
// req sql pour le nombre de killometre fait pour chaque user (nouvelle version permet de minimiser les erreur de clacule
    public function nombreKilometreAllParUser(){
//        SELECT lieu_tp.kilometrage, user.first_name from lieu_tp
//left join trajet on trajet.lieu_tp_id = lieu_tp.id
//left join user on user.id = trajet.user_id
//where user.id = 2
    }
}
