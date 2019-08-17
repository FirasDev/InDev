<?php

namespace AppBundle\Repository ;
use AppBundle\AppBundle;
use AppBundle\Entity\TravelGroup;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\TravelBuddy ;
class TravelBuddyRepository extends EntityRepository
{


    public function getBuddyByIdCurrentUser(User $user) {
        $id = $user->getID();
        $query=$this
            ->getEntityManager()->createQuery("select  t  from AppBundle:TravelBuddy t WHERE t.idUser = '$id'") ;


        $query->setMaxResults(1);

        $buddy =$query->getOneOrNullResult() ;

        return  $buddy  ;

    }


    public function getFiras() {
        $query=$this
            ->getEntityManager()->createQuery("select  t  from AppBundle:TravelBuddy t WHERE t.idUser = 16 ") ;


        $query->setMaxResults(1);

        $buddy =$query->getOneOrNullResult() ;

        return  $buddy  ;

    }









}