<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 4/7/2019
 * Time: 1:10 AM
 */

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:User')->find($id);

        if (!$entity)
        {
            throw $this->createNotFoundException("Ce utilisateur n'existe pas !");
        }



        return $this->render('AppBundle:default:profile.html.twig', array(
            'entity' => $entity,
        ));
    }

    //get all users
    public function indexAdminAction() {
        //access user manager services

        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        return $this->render('AppBundle:default:index_back.html.twig', array('users' =>   $users));
    }



}