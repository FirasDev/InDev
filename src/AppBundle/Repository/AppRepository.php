<?php

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Experience;

class AppRepository extends EntityRepository
{

    public function findExperienceByUserId($curr_user_id){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select e from AppBundle:Experience e where e.idUser = :userid")->setParameter("userid",$curr_user_id);
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }

    public function findCommentbyExperienceId($curr_exp_id){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select com.idCommExp from AppBundle:CommExp com where com.idExp = :idexp")->setParameter("idexp",$curr_exp_id);
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
}

    public function findExperienceBySeason($season){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select e from AppBundle:Experience e where e.season = :se")->setParameter("se",$season);
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }

    public function findExperiencesByPays($pays){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select e from AppBundle:Experience e, AppBundle:Pays p where e.idPays = p.id and p.name = :country")->setParameter("country",$pays);
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }

    public function findMyFollow($user,$exp){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select f from AppBundle:FollowedExp f, AppBundle:User u, AppBundle:Experience e where (f.idUser = :uid and f.idExp = :fexp) GROUP BY f.idExp")->setParameters(array('uid'=>$user,'fexp'=>$exp));
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }

    public function findMyFollows($user){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select e from AppBundle:FollowedExp f JOIN AppBundle:User u WITH f.idUser = u.id JOIN
        AppBundle:Experience e WITH e.idExperience = f.idExp WHERE f.idUser = :uid")->setParameters(array('uid'=>$user));
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }

    public function returnFollows($idf){
        $em = $this->getEntityManager();
        $query = $em->createQuery("select IDENTITY (f.idExp) from AppBundle:FollowedExp f 
        where f.idFollow = :idf")->setParameter('idf',$idf);
        if(count($query->getArrayResult()) > 0) return $query->getResult();
        return null;
    }

}