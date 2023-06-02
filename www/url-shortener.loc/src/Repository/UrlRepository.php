<?php

namespace App\Repository;

use App\Entity\Url;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Url|null find($id, $lockMode = null, $lockVersion = null)
 * @method Url|null findOneBy(array $criteria, array $orderBy = null)
 * @method Url[]    findAll()
 * @method Url[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Url::class);
    }

    public function findOneByHash(string $value): ?Url
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.hash = :val')
            ->andWhere('u.isExpired = 0')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByUrl(string $value): ?Url
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.url = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }


    public function isExistUrl(string $url): bool
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->select($qb->expr()->count('ur'))
            ->from(Url::class, 'ur')
            ->andWhere($qb->expr()->eq('ur.url', ':newUrl'));

        $qb->setParameter('newUrl', $url);

        return $qb->getQuery()->getSingleScalarResult() > 0;
    }

    public function updateIsExpired(): void
    {
        $this->getEntityManager()
            ->createNativeQuery(
                'START TRANSACTION; UPDATE url SET is_expired = 1 WHERE is_expired = 0 AND NOW() > ADDDATE(created_date, INTERVAL ttl SECOND); COMMIT;',
                new ResultSetMapping()
            )
        ->execute();
    }
}
