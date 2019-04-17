<?php

namespace ExperienceBundle\Controller;

use AppBundle\Entity\UserRatingExp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Userratingexp controller.
 *
 * @Route("userratingexp")
 */
class UserRatingExpController extends Controller
{
    /**
     * Lists all userRatingExp entities.
     *
     * @Route("/", name="userratingexp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userRatingExps = $em->getRepository('AppBundle:UserRatingExp')->findAll();

        return $this->render('userratingexp/index.html.twig', array(
            'userRatingExps' => $userRatingExps,
        ));
    }

    /**
     * Creates a new userRatingExp entity.
     *
     * @Route("/new", name="userratingexp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $userRatingExp = new Userratingexp();
        $form = $this->createForm('AppBundle\Form\UserRatingExpType', $userRatingExp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userRatingExp);
            $em->flush();

            return $this->redirectToRoute('userratingexp_show', array('idUserRatingExp' => $userRatingExp->getIduserratingexp()));
        }

        return $this->render('userratingexp/new.html.twig', array(
            'userRatingExp' => $userRatingExp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a userRatingExp entity.
     *
     * @Route("/{idUserRatingExp}", name="userratingexp_show")
     * @Method("GET")
     */
    public function showAction(UserRatingExp $userRatingExp)
    {
        $deleteForm = $this->createDeleteForm($userRatingExp);

        return $this->render('userratingexp/show.html.twig', array(
            'userRatingExp' => $userRatingExp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userRatingExp entity.
     *
     * @Route("/{idUserRatingExp}/edit", name="userratingexp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserRatingExp $userRatingExp)
    {
        $deleteForm = $this->createDeleteForm($userRatingExp);
        $editForm = $this->createForm('AppBundle\Form\UserRatingExpType', $userRatingExp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('userratingexp_edit', array('idUserRatingExp' => $userRatingExp->getIduserratingexp()));
        }

        return $this->render('userratingexp/edit.html.twig', array(
            'userRatingExp' => $userRatingExp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userRatingExp entity.
     *
     * @Route("/{idUserRatingExp}", name="userratingexp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, UserRatingExp $userRatingExp)
    {
        $form = $this->createDeleteForm($userRatingExp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userRatingExp);
            $em->flush();
        }

        return $this->redirectToRoute('userratingexp_index');
    }

    /**
     * Creates a form to delete a userRatingExp entity.
     *
     * @param UserRatingExp $userRatingExp The userRatingExp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserRatingExp $userRatingExp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('userratingexp_delete', array('idUserRatingExp' => $userRatingExp->getIduserratingexp())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
