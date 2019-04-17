<?php

namespace EquipementBundle\Controller;


use AppBundle\Entity\Commentaire;
use AppBundle\Entity\Echange;
use AppBundle\Entity\Equipement;
use AppBundle\Entity\Rating;
use AppBundle\Repository\EchangeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Knp\Snappy\Pdf;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Symfony\Component\HttpFoundation\Response;


class EquipementController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }





    public function shopAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if(isset($_GET['critere']))
            $equipements = $em->getRepository('AppBundle:Equipement')->recherche($_GET['critere']);
        else
            $equipements = $em->getRepository('AppBundle:Equipement')->findAll();

        $equipement = new Equipement();
        $form = $this->createForm('AppBundle\Form\EquipementType', $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $equipement->setIdUser($user);

            $equipement->uploadPicture();
            $em->persist($equipement);
            $em->flush();
            return $this->redirectToRoute('shop');

        }

        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $echange = new Echange();
        $id = 1;
        if($user != 'anon.')
            $id = $user->getId();
        $form_echange = $this->createForm('AppBundle\Form\EchangeType', $echange,array('current_user'=>$id));
        $form_echange->handleRequest($request);
        if ($form_echange->isSubmitted() && $form_echange->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();


            $message = (new \Swift_Message('Echange'))
                ->setFrom('wordfriendship@test.com')
                ->setTo($echange->getEquipement2()->getIdUser()->getEmail())
                ->setBody(
                    'Vous avez reçu une demande d\'echange'
                )
            ;

            $this->get('mailer')->send($message);
            dump('aaaaa');


            $em->persist($echange);
            $em->flush();
            //return $this->redirectToRoute('shop');

        }


        return $this->render('EquipementBundle:Default:index.html.twig',[
            'equipement' => $equipement,
            'form' => $form->createView(),
            'form_echange' => $form_echange->createView(),
            'equipements' => $equipements,
            'titre'=>"Shop"
        ]);
    }





    public function mesEquipementsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if($user){
            if(isset($_GET['critere']))
                $equipements = $em->getRepository('AppBundle:Equipement')->recherche($_GET['critere']);
            else
            $equipements = $em->getRepository('AppBundle:Equipement')->findBy(['idUser'=>$user->getId()]);
        }

        $equipement = new Equipement();
        $form = $this->createForm('AppBundle\Form\EquipementType', $equipement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();

            $equipement->setIdUser($user);

            $equipement->uploadPicture();
            $em->persist($equipement);
            $em->flush();
            return $this->redirectToRoute('shop');

        }



        return $this->render('EquipementBundle:Default:index.html.twig',[
            'equipement' => $equipement,
            'form' => $form->createView(),
            'equipements' => $equipements,
            'titre'=>"Mes equipements"
        ]);
    }






    public function echangeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();



        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if($user != 'anon.'){
            $mesDemandes = $em->getRepository(Echange::class)->findMesDemandes($user->getId());

            $demandesRecues = $em->getRepository(Echange::class)->findDemandesRecues($user->getId());
            dump($mesDemandes);
            dump($demandesRecues);



        }




        dump($_POST);

        if(isset($_POST['echange']) && isset($_POST['reponse'] )){
            $ech=  $em->getRepository(Echange::class)->find($_POST['echange']);
            $ech->setReponse($_POST['reponse']);
            $em->flush();
        }

        /*if ($form->isSubmitted() && $form->isValid()) {
            $echange = $form['echange']->getData();
            $echange->setResponse($form['reponse']->getData());
            $em->flush();
        }*/



        return $this->render('EquipementBundle:Default:echanges.html.twig',[

            'demandes_recues' => $demandesRecues,
            'mes_demandes' => $mesDemandes,
            'titre'=>"Mes echanges",
        ]);
    }



    public function pageEquipementAction(Request $request,Equipement $equipement)
    {


        $em = $this->getDoctrine()->getManager();

        $commentaires = $em->getRepository('AppBundle:Commentaire')->findBy(['equipement'=>$equipement->getIdEq()]);


        $commentaire = new Commentaire();
        $form = $this->createForm('AppBundle\Form\CommentaireType', $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $commentaire->setIdUser($user);
            $commentaire->setEquipement($equipement);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('equipement_show', array('idEq' => $equipement->getIdeq()));
        }


        $editForm = $this->createForm('AppBundle\Form\EquipementType', $equipement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if($equipement->getFile())
                $equipement->uploadPicture();
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipement_show', array('idEq' => $equipement->getIdeq()));
        }

        $rating = new Rating();
        $ratingForm = $this->createForm('AppBundle\Form\RatingType', $rating);
        $ratingForm->handleRequest($request);

        if ($ratingForm->isSubmitted() && $ratingForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipement_show', array('idEq' => $equipement->getIdeq()));
        }


        return $this->render('EquipementBundle:Default:index2.html.twig', array(
            'equipement' => $equipement,
            'commentaires'=>$commentaires,
            'form'=>$form->createView(),
            'form_edit'=>$editForm->createView(),
            'rating'=>$ratingForm->createView(),
        ));
    }




    public function supprimerEquipementAction(Equipement $equipement)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($equipement);
        $em->flush();


        return $this->redirectToRoute('shop');
    }





    public function equipementAction()
    {
        return $this->render('EquipementBundle:Default:index2.html.twig');
    }




    public function supprimerCommentaireAction(Commentaire $commentaire)
    {
        $eq = $commentaire->getEquipement()->getIdEq();
        $em = $this->getDoctrine()->getManager();
        $em->remove($commentaire);
        $em->flush();


        return $this->redirectToRoute('equipement_show',['idEq'=>$eq]);
    }


    public function modifierCommentaireAction()
    {
        dump($_POST);
        dump($_GET);
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository(Commentaire::class)->find($_GET['id']);
        $commentaire->setTexteCommentaire($_POST['comment']);
        $em->flush();
        $eq = $commentaire->getEquipement()->getIdEq();
        return $this->redirectToRoute('equipement_show',['idEq'=>$eq]);

    }



    public function panierAction(Request $request){
        dump($_POST);
        $em = $this->getDoctrine()->getManager();
        $items = explode(',',$_POST['panier']);
        $panier = [];
        foreach ($items as $item) {
            $equipement = $em->getRepository(Equipement::class)->find($item);
            if(!isset($panier[$equipement->getLibelle()])){
                $panier[$equipement->getLibelle()][0]=0;
                $panier[$equipement->getLibelle()][1]=$equipement->getIdEq();
                $panier[$equipement->getLibelle()][2]=$equipement->getPrix();
            }
            $panier[$equipement->getLibelle()][0]++;

        }

        return new JsonResponse(json_encode($panier));
    }

    public function ratingAction(){
        $em = $this->getDoctrine()->getManager();
        $eq = $em->getRepository(Equipement::class)->find($_POST['eq']);
        $rating = new Rating();
        $rating->setEquipement($eq);
        $rating->setRate($_POST['value']);

        $em->persist($rating);
        $em->flush();
        dump($em->getRepository(Rating::class)->findAvg($eq->getIdEq()));
        return new JsonResponse(json_encode($em->getRepository(Rating::class)->findAvg($eq->getIdEq())[0][1]));
    }


    public function backAction(){
        $em = $this->getDoctrine()->getManager();
        $equipements = $em->getRepository(Equipement::class)->findAll();

        return $this->render('EquipementBundle:Default:indexBack.html.twig',[
            'equipements'=> $equipements,
        ]);
    }


    public function factureAction(){

        $em = $this->getDoctrine()->getManager();
        $items = explode(',',$_POST['panier']);
        $panier = [];
        foreach ($items as $item) {
            $equipement = $em->getRepository(Equipement::class)->find($item);
            if(!isset($panier[$equipement->getLibelle()])){
                $panier[$equipement->getLibelle()][0]=0;
                $panier[$equipement->getLibelle()][1]=$equipement->getIdEq();
                $panier[$equipement->getLibelle()][2]=$equipement->getPrix();
            }
            $panier[$equipement->getLibelle()][0]++;

        }

        foreach ($panier as $item) {
            $equipement = $em->getRepository(Equipement::class)->find($item[1]);
            $equipement->setQuantite($equipement->getQuantite() - $item[0]);
        }
        $em->flush();

        $snappy = $this->get('knp_snappy.pdf');
        dump($_POST);
        $html = $this->render('EquipementBundle:Default:facture.html.twig', [
            'e'=>$panier,
        ]);
        $filename = 'Facture';
        return new Response(
            $snappy->getOutputFromHtml($html),200,array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
            )
        );
    }

}
