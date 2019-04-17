<?php

namespace TravelbuddyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TravelGroup ;

class DefaultController extends Controller
{

    public function indexAction()
    {

        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){

            $user = $this->container->get('security.token_storage')->getToken()->getUser() ;
            $nationaly = $user->getNationalite() ;

            $groups=$this->getDoctrine()
                ->getRepository(TravelGroup::class)
                ->getRecommendedGroup($nationaly);
            dump($groups) ;
        }



        return $this->render('@Travelbuddy/Default/index.html.twig',array('groups' => $groups  ));
    }
}
