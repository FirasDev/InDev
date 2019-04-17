<?php
/**
 * Created by PhpStorm.
 * User: jha
 * Date: 09/04/2019
 * Time: 10:25
 */

namespace AppBundle\Repository;


class EquipementRepository extends \Doctrine\ORM\EntityRepository
{
    public function recherche($critere)
    {
        // automatically knows to select Products
        // the "p" is an alias you'll use in the rest of the query
        $qb = $this->createQueryBuilder('p');
        $qb
            ->orWhere(
            $qb->expr()->like('p.reference',':critere')
            )
            ->orWhere(
            $qb->expr()->like('p.libelle',':critere')
            )
            ->orWhere(
            $qb->expr()->like('p.description',':critere')
            )
            ->orWhere(
            $qb->expr()->like('p.prix',':critere')
            )
        ->setParameter('critere', '%'.$critere.'%')

        ;

        return $qb->getQuery()->execute();
    }



}