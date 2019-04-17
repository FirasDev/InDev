<?php

namespace GroupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Reponse;
use AppBundle\Entity\Questions;
use GroupBundle\Form\ReponseType;

class commentaireController extends Controller
{
    public function ajoutercomAction(Request $request, $id, Questions $fr)
    {
      //  $this->get('views_counter.views_counter')->count($fr);
        $user = $this->getUser();
        $reponse = new reponse();
        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
        $forum = $this->getDoctrine()->getRepository('AppBundle:Questions')
            ->findforumParameter($id);
        $comm = $this->getDoctrine()
            ->getRepository('AppBundle:Reponse')
            ->findcommParameter($id);
        if ($user !== null) {


            if ($form->isValid()) {
                $reponse->setIdUtilisateur($user);

                $em = $this->getDoctrine()->getManager();
                $question = $em->getRepository("AppBundle:Questions")->find($id);
                $reponse->setIdQuestion($question);


                $em->persist($reponse);
                $em->flush();
                return $this->redirectToRoute('group_homepage');
            }
            return $this->render('@Group/comment.html.twig',
                array("form" => $form->createView(),
                    'forum' => $forum,
                    'comment' => $comm,
                    'user'=> $user));
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function modifiercommAction(Request $request, $id, Reponse $com)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($com->getIdUtilisateur()== $user) {
            $comment = $this->getDoctrine()->getRepository(Reponse::class)
                ->find($id);
            $form = $this->createForm(ReponseType::class, $comment);
            $form->handleRequest($request);
            if ($user !== null) {
                if ($form->isSubmitted()) {
                    $comment->setIdUtilisateur($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->flush();
                    return $this->redirectToRoute('group_homepage');
                }

                return $this->render('@Group/testmodcomm.html.twig',
                    array("form" => $form->createView()));
            } else {
                return $this->redirectToRoute('fos_user_security_login');
            }
        }
        return $this->redirectToRoute('forums_commentpage', array('id' => $com->getForum()));


    }
    public function supprimercommAction($id, Reponse $com)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        if ($com->getIdUtilisateur()== $user) {
            $em = $this->getDoctrine()->getManager();
            $comment = $em->getRepository("AppBundle:Reponse")->find($id);
            $em->remove($comment);
            $em->flush();
            return $this->redirectToRoute('group_homepage');
        }
        return $this->redirectToRoute('group_homepage');
    }
}
