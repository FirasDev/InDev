<?php

namespace MobileBundle\Controller;


use AppBundle\Entity\Evenement;
use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use AppBundle\Entity\Reservation;


class eventController extends Controller
{
    public function CreatEventAction(Request $request)
    {
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


        if (isset($_FILES["jobPic"]['name']))
            if ($_FILES["jobPic"]['name'] != "") {
                move_uploaded_file($_FILES['jobPic']['tmp_name'], __DIR__ . '/../../../web/images/' . $_FILES["jobPic"]['name']);
                $event->setUrl($_FILES["jobPic"]['name']);
            }

 
        $entitymanger->persist($event);
        $entitymanger->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);

    }


    public function showEventAction(Request $request)
    {
        $token = $request->get('idUser');
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findEventByID($token);
        //$events = $entitymanager->getRepository(Evenement::class)->findBy(array('idUser' =>$token));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);


    }

    public function showEventByCityAction(Request $request)
    {
        $token = $request->get('city');
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findEventByCity($token);
        //$events = $entitymanager->getRepository(Evenement::class)->findBy(array('idUser' =>$token));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);


    }
    public function showAllEventsAction()
    {

        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findAllEvents();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }



    public function showAllCityAction()
    {

        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findAllCity();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }
    public function showRecommendedAction()
    {

        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findRecommended();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }

    public function showOtherEventAction(Request $request)
    {
        $token = $request->get('idUser');
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findOtherEventByID($token);
        //$events = $entitymanager->getRepository(Evenement::class)->findBy(array('idUser' =>$token));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);


    }

    public function deleteAction(Request $request)
    {
        $token = $request->get('idEvent');


        $em = $this->getDoctrine()->getManager();


        $event = $this->getDoctrine()->getRepository(Evenement::class)->find($token);

        $em->remove($event);


        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($event);
        return new JsonResponse($formatted);
    }

    ////////////////////////////////////////// Reservation ////////////////////////////////////

    public function reserverEventAction(Request $request)
    {
        $id = $request->get('idEvent');
        $token = $request->get('idUser');
        $entitymanager = $this->getDoctrine()->getManager();
        $event = $entitymanager->getRepository(Evenement::class)->find($id);


        $mailer = $this->get('mailer');

        /* $basic  = new \Nexmo\Client\Credentials\Basic('74cf9174', '03qvU6mGnFXmIuQB');
         $client = new \Nexmo\Client($basic);

         $message = $client->message()->send([
             'to' => '21653411569',
             'from' => 'AMITICIA',
             'text' => 'Merci pour votre reservation'
         ]);*/

        $msg = (new \Swift_Message('AMITICA '))
            ->setFrom('No-Reply@amiticia.tn')
            ->setTo('amine.hamdi@esprit.tn')
            ->setBody('Merci pour votre reservation');

        $mailer->send($msg);


        $date = new \DateTime();

        $reservation = new Reservation();
        $event->setNbrPlace($event->getNbrPlace() - $request->get('nbplaces'));
        $reservation->setIdUser($token);
        $reservation->setIdEvent($id);
        $reservation->setFrais($event->getFrais());
        $reservation->setNbrPlace($request->get('nbplaces'));
        $reservation->setDate($date);
        $entitymanager->persist($reservation);
        $entitymanager->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reservation);
        return new JsonResponse($formatted);

    }


    public function showReservationAction(Request $request)
    {

        $token = $request->get('idUser');
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Evenement')->findReservationByID($token);
        //$events = $entitymanager->getRepository(Evenement::class)->findBy(array('idUser' =>$token));
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }

    public function cancelReservationAction(Request $request)
    {

            $user = $request->get('idUser');
            $entitymanager = $this->getDoctrine()->getManager();
            $reserv = $entitymanager->getRepository(Reservation::class)->findBy(array('idUser' => $user));


                $ev = $entitymanager->getRepository(Evenement::class)->find($reserv[0]->getIdEvent());
                $ev->setNbrPlace($ev->getNbrPlace() + $reserv[0]->getNbrPlace());
                //the remove() method notifies Doctrine that you'd like to remove the given object from the database
                $entitymanager->remove($reserv[0]);

                //The flush() method execute the DELETE query.
                $entitymanager->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($reserv);
        return new JsonResponse($formatted);


    }

}