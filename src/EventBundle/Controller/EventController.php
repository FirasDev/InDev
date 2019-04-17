<?php

namespace EventBundle\Controller;


use AppBundle\Entity\Evenement;
use AppBundle\Entity\Notification;
use AppBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class EventController extends Controller
{

    public function CreatEventAction(Request $request)
    {
        $token = $this->container->get('security.token_storage')->getToken()->getUser();
        if($request->isMethod('POST')) {
            $entitymanger = $this->getDoctrine()->getManager();

            $event = new Evenement();
            $event->setNom($request->get('title'));
            $event->setLieu($request->get('city'));
            $event->setDateDebut($request->get('startdate'));
            $event->setDateFin($request->get('enddate'));
            $event->setFrais($request->get('price'));
            $event->setDescription($request->get('description'));
            $event->setType($request->get('category'));
            $event->setNbrPlace($request->get('seats'));

            if(isset($_FILES["fileselect"]['name']))
                if($_FILES["fileselect"]['name'] != ""){
                    move_uploaded_file($_FILES['fileselect']['tmp_name'],__DIR__.'/../../../web/images/'.$_FILES["fileselect"]['name']);
                    $event->setUrl($_FILES["fileselect"]['name']);
                }            $event->setIdUser($token);



                $notif = new Notification();
                $notif->setMessage("A new event has been added");
                $notif->setSender($token->getID());
                $notif->setReceiver(1);
                $entitymanger->persist($notif);

            $entitymanger->persist($event);
            $entitymanger->flush();


            return $this->redirectToRoute('showEvent');
        }

        return $this->redirectToRoute('showEvent');

    }




    public function showEventAction()
    {
        $auth_checker = $this->get('security.authorization_checker');
        if ($auth_checker->isGranted('ROLE_USER')) {
            // Everyone else goes to the `home` route
            $token = $this->container->get('security.token_storage')->getToken()->getUser();

            $entitymanager = $this->getDoctrine()->getManager();
            $events = $entitymanager->getRepository(Evenement::class)->findBy(array('idUser' => $token));

            return $this->render('EventBundle:Event:show_events.html.twig', array(

                'events' => $events ));



        }
        else {
            return $this->redirectToRoute('homepage');

        }
    }
    public function detailsEventAction($id,Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($auth_checker->isGranted('ROLE_USER')) {
            // Everyone else goes to the `home` route

        $token = $this->container->get('security.token_storage')->getToken()->getUser();
        $entitymanager = $this->getDoctrine()->getManager();

        $edit = $request->get('save');
        $remove = $request->get('remove');
        $event = $entitymanager->getRepository(Evenement::class)->find($id);


        if(isset($edit))
        {

        $event->setNom($request->get('title'));
        $event->setLieu($request->get('city'));
        $event->setDateDebut($request->get('startdate'));
        $event->setDateFin($request->get('enddate'));
        $event->setFrais($request->get('price'));
        $event->setDescription($request->get('description'));
        $event->setType($request->get('category'));
        $event->setNbrPlace($request->get('seats'));
            if(isset($_FILES["fileselect"]['name']))
                if($_FILES["fileselect"]['name'] != ""){
                    move_uploaded_file($_FILES['fileselect']['tmp_name'],__DIR__.'/../../../web/images/'.$_FILES["fileselect"]['name']);
                    $event->setUrl($_FILES["fileselect"]['name']);
                }
        $event->setIdUser($token);

        $entitymanager->flush();
            }
        if (isset($remove))
        {

            $entitymanager->remove($event);
            $entitymanager->flush();

            return $this->redirectToRoute('showEvent');
        }
        return $this->render('EventBundle:Event:details_events.html.twig', array(

                'event'=>$event
        ));
        }
        else {
            return $this->redirectToRoute('homepage');

        }
    }

    public function galleryEventAction()
    {
       // $token = $this->container->get('security.token_storage')->getToken()->getUser();
        $entitymanager = $this->getDoctrine()->getManager();
        $event = $entitymanager->getRepository(Evenement::class)->findAll();

        return $this->render('EventBundle:Event:gallery_events.html.twig', array(
            'event'=>$event

        ));

    }

    public function detailsgalleryEventAction($id,Request $request)
    {
        $token = $this->container->get('security.token_storage')->getToken()->getUser();
        $entitymanager = $this->getDoctrine()->getManager();
        $event = $entitymanager->getRepository(Evenement::class)->find($id);


            $rate = $request->get('rating');

            if (isset($rate))
            {

                $event->setRate(round(($event->getRate()+$rate)/2));
                $entitymanager->flush();
            }


        if ($request->isMethod("POST")) {
 ////////////stripe
            \Stripe\Stripe::setApiKey("sk_test_flb9vUYyiwC85Wx2ONpANeYf");
            $amount = $request->get('dataAmount');
            // Token is created using Checkout or Elements!
            // Get the payment token ID submitted by the form:
            $charge = \Stripe\Charge::create([
                'amount' => $amount*$request->get('nbplaces'),
                'currency' => 'usd',
                'description' => 'Example charge',
                'source' => 'tok_visa',
            ]);

            dump($status = $charge->getLastResponse());


            $reservation = new Reservation();
            $event->setNbrPlace($event->getNbrPlace()-$request->get('nbplaces'));
            $reservation->setIdUser($token->getId());
            $reservation->setIdEvent($id);
            $reservation->setFrais($event->getFrais());
            $reservation->setNbrPlace($request->get('nbplaces'));
            $reservation->setDate($date);
            $entitymanager->persist($reservation);
            $entitymanager->flush();

            $session = new Session();

            $session->set('eventid',$event->getIdEvent());
            $session->set('eventnom',$event->getNom());


            return $this->redirectToRoute('validation');

        }

        $date = new \DateTime();
        return $this->render('EventBundle:Event:details_gallery_events.html.twig', array(
            'event'=>$event,'d'=>$date

        ));

    }
	


}
