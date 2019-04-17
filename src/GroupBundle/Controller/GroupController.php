<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Reponse;
use AppBundle\Entity\Questions;
use AppBundle\Entity\User;
use GroupBundle\Form\reponseType;
use GroupBundle\Form\questionType;


class GroupController extends Controller
{
    public function listAction($id)
    {
        $user = $this->getUser();
        $forum = $this->getDoctrine()
            ->getRepository('AppBundle:Questions')
            ->findCategorieParameter($id);
        $cat = $this->getDoctrine()
            ->getRepository('AppBundle:categorie')
            ->findNomParameter($id);
        return $this->render('@Group/list.html.twig', array('forum' => $forum , 'categorie'=> $cat , 'user' => $user));
    }

    public function ajouterAction(Request $request)
    {

        $user = $this->getUser();
        $question = new Questions();
        $cat = $this->getDoctrine()
            ->getRepository('AppBundle:categorie')
            ->findAll();
        $lim = $this->getDoctrine()
            ->getRepository('AppBundle:Questions')
            ->findBy(array(),array('idQuestion'=>'DESC'),8);
        $form = $this->createForm(questionType::class, $question);
        $form->handleRequest($request);



            if ($form->isSubmitted()) {
                $question->setIdUtilisateur($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($question);
                $em->flush();
                return $this->redirectToRoute('group_homepage');
            }
            return $this->render('@Group/group.html.twig',
                array("form" => $form->createView(),
                    'categorie' => $cat,
                    'lim'=> $lim));

    }


    public function modifiertestAction(Request $request, $id, Questions $fo)
    {



        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($fo->getUser()== $user) {
            $forum = $this->getDoctrine()->getRepository(Questions::class)
                ->find($id);

            $form = $this->createForm(questionType::class, $forum);
            $form->handleRequest($request);


            if ($user !== null) {
                //$forum->setDate(new \DateTime());
                if ($form->isSubmitted()) {
                    $forum->setIdUtilisateur($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    return $this->redirectToRoute('forums_listpage', array('id' => $forum->getCategorie()->getId()));
                }

                return $this->render('@Group/testmod.html.twig',
                    array("form" => $form->createView()));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('forums_listpage', array('id' => $fo->getCategorie()->getId()));


    }

    public function supprimerArAction($id, Questions $fo)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($fo->getUser()== $user) {
            $em = $this->getDoctrine()->getManager();
            $forum = $em->getRepository("AppBundle:Questions")->find($id);
            $em->remove($forum);
            $em->flush();
            return $this->redirectToRoute('forums_listpage',array('id'=>$forum->getCategorie()->getId()));
        }
        return $this->redirectToRoute('forums_listpage',array('id'=>$fo->getCategorie()->getId()));
    }

}
