<?php

namespace ExperienceBundle\Controller;

use AppBundle\Entity\AlbumExperience;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Albumexperience controller.
 *
 * @Route("albumexperience")
 */
class AlbumExperienceController extends Controller
{
    /**
     * Lists all albumExperience entities.
     *
     * @Route("/", name="albumexperience_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $albumExperiences = $em->getRepository('AppBundle:AlbumExperience')->findAll();

        return $this->render('albumexperience/index.html.twig', array(
            'albumExperiences' => $albumExperiences,
        ));
    }

    /**
     * Creates a new albumExperience entity.
     *
     * @Route("/new", name="albumexperience_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $albumExperience = new Albumexperience();
        $form = $this->createForm('AppBundle\Form\AlbumExperienceType', $albumExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($albumExperience);
            $em->flush();

            return $this->redirectToRoute('albumexperience_show', array('idAlbumExperience' => $albumExperience->getIdalbumexperience()));
        }

        return $this->render('albumexperience/new.html.twig', array(
            'albumExperience' => $albumExperience,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a albumExperience entity.
     *
     * @Route("/{idAlbumExperience}", name="albumexperience_show")
     * @Method("GET")
     */
    public function showAction(AlbumExperience $albumExperience)
    {
        $deleteForm = $this->createDeleteForm($albumExperience);

        return $this->render('albumexperience/show.html.twig', array(
            'albumExperience' => $albumExperience,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing albumExperience entity.
     *
     * @Route("/{idAlbumExperience}/edit", name="albumexperience_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AlbumExperience $albumExperience)
    {
        $deleteForm = $this->createDeleteForm($albumExperience);
        $editForm = $this->createForm('AppBundle\Form\AlbumExperienceType', $albumExperience);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('albumexperience_edit', array('idAlbumExperience' => $albumExperience->getIdalbumexperience()));
        }

        return $this->render('albumexperience/edit.html.twig', array(
            'albumExperience' => $albumExperience,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a albumExperience entity.
     *
     * @Route("/{idAlbumExperience}", name="albumexperience_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AlbumExperience $albumExperience)
    {
        $form = $this->createDeleteForm($albumExperience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($albumExperience);
            $em->flush();
        }

        return $this->redirectToRoute('albumexperience_index');
    }

    /**
     * Creates a form to delete a albumExperience entity.
     *
     * @param AlbumExperience $albumExperience The albumExperience entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AlbumExperience $albumExperience)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('albumexperience_delete', array('idAlbumExperience' => $albumExperience->getIdalbumexperience())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
