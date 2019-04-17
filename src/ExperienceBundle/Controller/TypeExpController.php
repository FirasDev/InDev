<?php

namespace ExperienceBundle\Controller;

use AppBundle\Entity\TypeExp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typeexp controller.
 *
 * @Route("typeexp")
 */
class TypeExpController extends Controller
{
    /**
     * Lists all typeExp entities.
     *
     * @Route("/", name="typeexp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $typeExps = $em->getRepository('AppBundle:TypeExp')->findAll();

        return $this->render('typeexp/index.html.twig', array(
            'typeExps' => $typeExps,
        ));
    }

    /**
     * Creates a new typeExp entity.
     *
     * @Route("/new", name="typeexp_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typeExp = new Typeexp();
        $form = $this->createForm('AppBundle\Form\TypeExpType', $typeExp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeExp);
            $em->flush();

            return $this->redirectToRoute('typeexp_show', array('idType' => $typeExp->getIdtype()));
        }

        return $this->render('typeexp/new.html.twig', array(
            'typeExp' => $typeExp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typeExp entity.
     *
     * @Route("/{idType}", name="typeexp_show")
     * @Method("GET")
     */
    public function showAction(TypeExp $typeExp)
    {
        $deleteForm = $this->createDeleteForm($typeExp);

        return $this->render('typeexp/show.html.twig', array(
            'typeExp' => $typeExp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typeExp entity.
     *
     * @Route("/{idType}/edit", name="typeexp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TypeExp $typeExp)
    {
        $deleteForm = $this->createDeleteForm($typeExp);
        $editForm = $this->createForm('AppBundle\Form\TypeExpType', $typeExp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('typeexp_edit', array('idType' => $typeExp->getIdtype()));
        }

        return $this->render('typeexp/edit.html.twig', array(
            'typeExp' => $typeExp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typeExp entity.
     *
     * @Route("/{idType}", name="typeexp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TypeExp $typeExp)
    {
        $form = $this->createDeleteForm($typeExp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeExp);
            $em->flush();
        }

        return $this->redirectToRoute('typeexp_index');
    }

    /**
     * Creates a form to delete a typeExp entity.
     *
     * @param TypeExp $typeExp The typeExp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TypeExp $typeExp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('typeexp_delete', array('idType' => $typeExp->getIdtype())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
