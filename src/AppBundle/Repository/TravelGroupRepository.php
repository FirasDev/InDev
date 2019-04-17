<?php

namespace AppBundle\Repository ;
use AppBundle\AppBundle;
use AppBundle\Entity\TravelGroup;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\TravelBuddy ;
class TravelGroupRepository extends EntityRepository
{

    public function getGroupByIdTravelBuddy($id){


        $query=$this
            ->getEntityManager()->createQuery("select  t  from AppBundle:TravelGroup t   WHERE t.idTravelGroup = '$id'") ;
        $members = $query->getOneOrNullResult() ;
        return $members ;
    }

    public function getGroupByDestination($dest){

     $dest1 = strtolower($dest) ;
        $query=$this
            ->getEntityManager()->createQuery("select  t  from AppBundle:TravelGroup t   WHERE Locate(t.destination,'$dest1')> 0") ;
        $destinations = $query->getResult() ;
        return $destinations ;
    }


 public function getRecommendedGroup($nationalty) {



          $query=$this
              ->getEntityManager()->createQuery("select  p.phonecode  from AppBundle:Pays p   WHERE p.name ='$nationalty'") ;
          $numCode = $query->getScalarResult();
          $numCode1 = array_map('current', $numCode); //getting it into array to retrive it later//

          $code =0;

     foreach($numCode1 as $item) {
         $code = $code + $item ;
     }


          $query1=$this
              ->getEntityManager()->createQuery("select p.name from AppBundle:Pays p WHERE abs(p.phonecode -'$code')< 10") ;
          $countryList  = $query1->getResult() ;

          dump($countryList) ;


          $query3=$this
         ->getEntityManager()->createQuery("select t from AppBundle:TravelGroup t WHERE t.destination in (select p.name from AppBundle:Pays p WHERE abs(p.phonecode -'$code')< 5000)") ;

          $groups = $query3->getResult() ;

          dump($groups) ;

          return $groups ;


 }





}