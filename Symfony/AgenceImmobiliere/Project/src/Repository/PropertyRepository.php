<?php
namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /*
    public function findAllVisibleResult(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }
    */

    /**
     * @param PropertySearch $search
     * @return Query
    */
    public function findAllVisibleQuery(PropertySearch $search): Query
    {
        # Get visible query
        $query = $this->findVisibleQuery();

        # traitement avec prix max
        if($maxprice = $search->getMaxPrice())
        {
            $query = $query->andWhere('p.price <= :maxprice')
                           ->setParameter('maxprice', $maxprice);
        }

        # traitement avec min surface
        if($minsurface = $search->getMinSurface())
        {
            $query = $query->andWhere('p.surface >= :minsurface')
                           ->setParameter('minsurface', $minsurface);
        }

        # Si le count est superieur a zero c.a.d on a des options
        if($search->getOptions()->count() > 0)
        {
            $k = 0;

            # pour chacune de ces options
            foreach($search->getOptions() as $option)
            {
                $k++;
                # j'ajoute a ma requette, parametre :option soit un membre de p.options
                # Doctrine MEMBER OF
                $query = $query->andWhere(":option$k MEMBER OF p.options")
                               ->setParameter("option$k", $option);
            }
        }

        # Return Query
        return $query->getQuery();
    }


    /**
     * Get 4 latest results
     * @return Property[]
    */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
                    ->setMaxResults(4)
                    ->getQuery()
                    ->getResult();
    }

    /**
     * Return all visible registrated
     * @return QueryBuilder
    */
    private function findVisibleQuery(): QueryBuilder
    {
       return $this->createQueryBuilder('p')
                   ->where('p.sold = false');
    }


    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}
