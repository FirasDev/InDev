<?php

namespace BlogBundle\Controller;

use AppBundle\Entity\Blog;
use AppBundle\Entity\Commentaire;
use BlogBundle\Form\CommentaireForm;
use BlogBundle\Form\ajouterBlogForm;
use BlogBundle\Form\modifierBlog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\BlogRepository;

class BlogController extends Controller
{



    public function accueilBlogAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $blogs = $em->getRepository("AppBundle:Blog")->findAll();

        // pour récuperer l'email d'utilisateur connecté
        //$users = $em->getRepository("UserBundle:User")->findBy(array('id' => $user), array());

        return $this->render('@Blog/BlogViews/accueilBlog.html.twig', ['blogs' => $blogs]);
    }

    public function ajouterBlogAction(Request $request)
    {


        //recuperer l'utilisateur connecté

        $user = $this->getUser();
        $blog = new Blog();
        $form = $this->createForm(ajouterBlogForm::class, $blog);
        $form->handleRequest($request);
        if ($user !== null) {
            if ($form->isValid()) {
                $blog->setEtatBlog("non resolu");
                $blog->setIdUtilisateur($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($blog);
                $em->flush();
                return $this->redirectToRoute('accueil_blog_root');
            }
            return $this->render('@Blog/BlogViews/ajouterBlog.html.twig', ['form_ajouter' => $form->createView()]);
        }else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }


    public function modifierBlogAction(Request $request)
    {


        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('AppBundle:Blog')->find($id);
        $form = $this->createForm(modifierBlog::class, $blog);
        $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($blog);
                $em->flush();

                return $this->redirectToRoute('accueil_blog_root');
            }

        return $this->render('@Blog/BlogViews/modifierBlog.html.twig', [ 'form_modifier' => $form->createView()]);
    }

    public function supprimerBlogAction(Request $request)
    {

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('AppBundle:Blog')->find($id);

            $em->remove($blog);
            $em->flush();

        return $this->redirectToRoute('accueil_blog_root');
    }

    public function validerBlogAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('AppBundle:Blog')->find($id);
        $blog->setEtatBlog("Resolu");
            $em->persist($blog);
            $em->flush();

            return $this->redirectToRoute('mesBlog_root');
        }


    public function mesBlogDataAction(Request $request)
    {

        $length = $request->get('length');
        $length = $length && ($length != -1) ? $length : 0;

        $start = $request->get('start');
        $start = $length ? ($start && ($start != -1) ? $start : 0) / $length : 0;

        $search = $request->get('search');

        $user = $this->getUser();
        $filters = [
            'query' => @$search['value'],
            'user' => @$user,
        ];

        $blogs = $this->getDoctrine()->getRepository('AppBundle:Blog')->search(
            $filters, $start, $length
        );

        $output = array(
            'data' => array(),
            'recordsFiltered' => count($this->getDoctrine()->getRepository('AppBundle:Blog')->search($filters, 0, false)),
            'recordsTotal' => count($this->getDoctrine()->getRepository('AppBundle:Blog')->search(array(), 0, false))
        );

        foreach ($blogs as $blog) {

            $output['data'][] = [
                'titreBlog' => $blog->getTitreBlog(),
                'etatBlog' => $blog->getEtatBlog(),
                'Affiche' => '<img class="resize" src="../Blog/image/affiches/' . $blog->getImageBlog() . '"/>',
               'Action' =>
            " <a href=" . $this->generateUrl('modifier_blog_root', ['id' => $blog->getIdBlog()]) . " target=\"_blank\"><img src=\"https://img.icons8.com/ios-glyphs/20/000000/services.png\"> </a>
             <a href=" . $this->generateUrl('supprimer_blog_root', ['id' => $blog->getIdBlog()]) . "><img src=\"https://img.icons8.com/material/26/000000/trash.png\"></a>
              <a href=" . $this->generateUrl('valider_blog_root', ['id' => $blog->getIdBlog()]) . "><img src=\"https://img.icons8.com/color/26/000000/approval.png\"> </a>"
            ];

        }
        return new Response(json_encode($output), 200, ['Content-Type' => 'application/json']);
    }

    public function mesBlogAction()
    {
        $user = $this->getUser();
        if ($user !== null) {
            return $this->render('@Blog/BlogViews/mesBlog.html.twig', []);
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    public function voirBlogAction(Request $request)
    {
        $user = $this->getUser();
        $id = $request->get('id');




        $commentaire = new Commentaire();
        $formCom = $this->createForm(CommentaireForm::class, $commentaire);
        $formCom->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('AppBundle:Blog')->find($id);
        $blog->setNombreVuBlog($blog->getNombreVuBlog()+1);
        $em->flush();

            // Partie commentaires
            if ($formCom->isValid() && $request->request->has($formCom->getName())) {

                $commentaire->setIdBlog($blog);
                $commentaire->setIdUtilisateur($user);

                $blog->addCommentaire($commentaire);
                $em->persist($commentaire);
                $em->flush();

                // pour refrechir
                unset($commentaire);
                unset($formCom);
                $commentaire = new Commentaire();
                $formCom = $this->createForm(CommentaireForm::class, $commentaire);



            }


        return $this->render('@Blog/BlogViews/voirBlog.html.twig',
            ['blog' => $blog , 'formCom' => $formCom->createView()]);


    }


    public function pdfAction(Request $request)
    {
        $user = $this->getUser();
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('AppBundle:Blog')->find($id);
        $snappy = $this->get('knp_snappy.pdf');

        $html = "<h1 style=\"background-color:powderblue;\" align='center'> Blog : " . $blog->getTitreBlog() .
            "  </h1> <h1> Bonjour Monsieur  : " . $user . " </h1>  <p> ce Blog est ajoute le : </p> <p> Article : " . $blog->getArticleBlog() . " </p>";
        $filename = 'pdf ' . $blog->getTitreBlog();

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.pdf"'
            )
        );
    }


}
