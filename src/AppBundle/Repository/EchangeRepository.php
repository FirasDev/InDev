<?php

namespace AppBundle\Repository;


use AppBundle\Entity\Equipement;
use AppBundle\Entity\User;

class EchangeRepository extends \Doctrine\ORM\EntityRepository
{

    public function findMesDemandes($id)
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('e')
            ->innerJoin(Equipement::class,'eq','WITH','e.equipement1 = eq')
            ->innerJoin(User::class, 'u','WITH', 'eq.idUser = u')
            ->where('u.id = :id')
            ->setParameter(':id',$id)
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }

    public function findDemandesRecues($id)
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('e')
            ->innerJoin(Equipement::class,'eq','WITH','e.equipement1 = eq')
            ->innerJoin(User::class, 'u','WITH', 'eq.idUser = u')
            ->where('u.id = :id')
            ->setParameter(':id',$id)
            ->getQuery();

        return $qb->execute();

        // to get just one result:
        // $product = $qb->setMaxResults(1)->getOneOrNullResult();
    }
}
