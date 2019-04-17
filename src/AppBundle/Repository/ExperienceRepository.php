<?php

namespace ExperienceBundle\Repository;


use Doctrine\ORM\EntityRepository;
use UsersBundle\Entity\User;

class ExperienceRepository extends EntityRepository
{

    public function findExperienceByUserId($id){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select e from AppBundle:Experience e where e.idUser = :ei")->setParameter("ei",$id);
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }
}