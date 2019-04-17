<?php
/**
 * Created by PhpStorm.
 * User: solta
 * Date: 31/03/2019
 * Time: 01:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BlogRepository extends EntityRepository
{


    public function search($data, $page = 0, $max = NULL, $getResult = true)
    {
        $qb = $this->_em->createQueryBuilder();
        $query = isset($data['query']) && $data['query']?$data['query']:null;
        $user = isset($data['user']) && $data['user']?$data['user']:null;

        $qb
            ->select('e')
            ->from('AppBundle:Blog', 'e')
        ;
        if($user){
            $qb->where('e.idUtilisateur = :user')
                ->setParameter('user', $user);
        }
        if ($query){
            $qb
                ->andWhere('e.titreBlog like :query')

                ->setParameter('query', "%".$query."%")
            ;

        }
        $qb->orderBy('e.dateAjoutBlog', 'DESC');

        if ($max) {
            $preparedQuery = $qb->getQuery()
                ->setMaxResults($max)
                ->setFirstResult($page * $max)
            ;
        } else {
            $preparedQuery = $qb->getQuery();
        }

        return $getResult?$preparedQuery->getResult():$preparedQuery;
    }
}