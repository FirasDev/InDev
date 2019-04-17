<?php

namespace ExperienceBundle\Controller;

use AppBundle\Entity\CommExp;
use AppBundle\Entity\Reported;
use AppBundle\Entity\Notification;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commexp controller.
 *
 * @Route("commexp")
 */
class CommExpController extends Controller
{
    /**
     * Lists all commExp entities.
     *
     * @Route("/", name="commexp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commExps = $em->getRepository('AppBundle:CommExp')->findAll();

        return $this->render('@Experience/commexp/index.html.twig', array(
            'commExps' => $commExps,
        ));
    }

    /**
     * Creates a new commExp entity.
     *
     * @Route("/new", name="commexp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commExp = new Commexp();
        $form = $this->createForm('ExperienceBundle\Form\CommExpType', $commExp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commExp);
            $em->flush();

            return $this->redirectToRoute('commexp_show', array('idCommExp' => $commExp->getIdcommexp()));
        }

        return $this->render('@Experience/commexp/new.html.twig', array(
            'commExp' => $commExp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commExp entity.
     *
     * @Route("/{idCommExp}", name="commexp_show")
     * @Method("GET")
     */
    public function showAction(CommExp $commExp)
    {
        $deleteForm = $this->createDeleteForm($commExp);

        return $this->render('@Experience/commexp/show.html.twig', array(
            'commExp' => $commExp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commExp entity.
     *
     * @Route("/{idCommExp}/edit", name="commexp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CommExp $commExp)
    {
        $deleteForm = $this->createDeleteForm($commExp);
        $editForm = $this->createForm('ExperienceBundle\Form\CommExpType', $commExp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commexp_edit', array('idCommExp' => $commExp->getIdcommexp()));
        }

        return $this->render('@Experience/commexp/edit.html.twig', array(
            'commExp' => $commExp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commExp entity.
     *
     * @Route("/{commExp}", name="commexp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request,$commExp)
    {
        $com = $this->getDoctrine()->getRepository(CommExp::class)->find($commExp);
        dump($commExp);
        $form = $this->createDeleteForm($com);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($com);
            $em->flush();
        }

        return $this->redirectToRoute('commexp_index');
    }

    public function delcommAction(CommExp $commExp){

        $em = $this->getDoctrine()->getManager();
        $idexp1 = $commExp->getIdExp()->getIdExperience();
        $report = $em->getRepository('AppBundle:Reported')->findBy(array('comment' => $commExp));
        foreach ($report as $reports){
            $em->remove($reports);
        }
        $em->remove($commExp);
        $em->flush();

        return $this->redirectToRoute('experience_show', array('idExperience' => $idexp1));
    }

    public function editcommAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()){
            $idcomm = $request->get("idCommExp");
            $Mycomm = $em->getRepository('AppBundle:CommExp')->find($idcomm);
            //$oldcomment = $Mycomm->getComment();
            $comment = $request->get("comment");
            dump($Mycomm);
            dump($idcomm);
            $Mycomm->setComment($comment);
            dump($comment);
            $Mycomm->setDernieremodification(new \DateTime("now"));
            dump($Mycomm);
           $em->persist($Mycomm);
            $em->flush();

            return new JsonResponse("true");
        }

    }

    public function reportingAction(Request $request){

        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()){
            $reporter = $em->getRepository("AppBundle:User")->findOneBy(array("id" => $request->get("current_user")));
            $report = new Reported();
            $report->setReporter($user);
            $commId = $em->getRepository("AppBundle:CommExp")->findOneBy(array("idCommExp" => $request->get("idCommExp")));
            $report->setComment($commId);
            $report->setreportDate(new \DateTime("now"));
            $exp = $em->getRepository("AppBundle:Experience")->findOneBy(array("idExperience" => $request->get("id_exp")));
            $report->setExperienceId($exp);


            $u = $this->getUser();
            // send this to all admins

            $notif = new  Notification();
            $notif->setSender($u->getId());
            $notif->setMessage($u." à signalé un commentaire !");
            $notif->setReceiver(1);
            $em->persist($notif);

            dump($report);
            $em->persist($report);
            $em->flush();
            return new JsonResponse("true");
        }
    }

    public function listbackAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $CommExp = $em->getRepository('AppBundle:CommExp')->findAll();
        $notifs = $em->getRepository('AppBundle:Notification')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $CommExp, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('@Experience/commexp/comments_back.html.twig', array('pagination' => $pagination, 'notifs' => $notifs));
    }

    public function reportsbackAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $reports = $em->getRepository('AppBundle:Reported')->findAll();
        $notifs = $em->getRepository('AppBundle:Notification')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $reports, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('@Experience/commexp/reported_comments_back.html.twig', array('pagination' => $pagination, 'notifs' => $notifs));
    }

    /**
     * Creates a form to delete a commExp entity.
     *
     * @param CommExp $commExp The commExp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CommExp $commExp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commexp_delete', array('idCommExp' => $commExp->getIdcommexp())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
