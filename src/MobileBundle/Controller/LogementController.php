<?php

namespace MobileBundle\Controller;

use AppBundle\Entity\Cite;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Logement;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use AppBundle\Entity\ReservationLogement;
use Symfony\Component\Validator\Constraints\Date;


class LogementController extends Controller
{

    public function addLogementAction(Request $request)
    {

            $entitymanager = $this->getDoctrine()->getManager();
            $description = $request->get('description');
            $titre = $request->get('titre');
            $prix = $request->get('prix');
            $user = $request->get('idUser');
            $cite = $request->get('idcite');

          //  $url = $request->get('url');

                    $logement = new Logement();
           //         $cite=new Cite();
        $city = $entitymanager->getRepository(Cite::class)->find($cite);
                    $logement->setTitre($titre);
                    $logement->setDescription($description);
                    $logement->setPrix($prix);
                    $logement->setIdUser(16);
                 //  $logement->setUrl($url);
                   $logement->setIdCite($city);
                    $logement->setIsdisponible(true);
                    $entitymanager->persist($logement);
                    $entitymanager->flush();



        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($logement);
        return new JsonResponse($formatted);
                }

                public function showAction()
                {
                    $cities = $this->getDoctrine()->getRepository(Cite::class)->findAll();

                    $serializer = new Serializer([new ObjectNormalizer()]);
                    $formatted = $serializer->normalize($cities);
                    return new JsonResponse($formatted);


                }

    public function showlogAction(Request $request)
    {

        $token =$request->get('idUser');
        //$city =$request->get('idCite');
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Logement')->findLogByID($token);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }
    public function showallAction(Request $request)
    {

        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Logement')->findalllog();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }


    public function deleteAction(Request $request)
    {
        $token = $request->get('id');
        $em=$this->getDoctrine()->getManager();
        $log=$this->getDoctrine()->getRepository(Logement::class)->find($token);
        $em->remove($log);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($log);
        return new JsonResponse($formatted);
    }

   public function  reservlogAction (Request $request)
   {


       $entitymanager = $this->getDoctrine()->getManager();

           $token =$request->get('idUser');
           $idlog = $request->get('idlog');
           $date_arrive = $request->get('date_arrive');
           $date_depart = $request->get('date_depart');

           $datea = new DateTime($date_arrive);
           $datef = new DateTime($date_depart);

               $reservation = new ReservationLogement();
               $logement = $entitymanager->getRepository(Logement::class)->find($idlog);
               $reservation->setIdUser($token);
               $reservation->setIdLogement($idlog);
               $reservation->setDateArrive($datea);
               $reservation->setDateDepart($datef);
               $logement->setIsdisponible(false);
               $entitymanager->persist($reservation);
               $entitymanager->flush();


       $serializer = new Serializer([new ObjectNormalizer()]);
       $formatted = $serializer->normalize($reservation);
       return new JsonResponse($formatted);
   }

   public function deleteReservationAction (Request $request)
   {

               $token =$request->get('idUser');

               $idlog=$request->get('idLog');

           //    $idreserv =$request->get('reference'); hethyy lfazeeeet yfase5 2 reservation itha ken famma lnafs logement

               $em = $this->getDoctrine()->getManager();

               $reserv = $em->getRepository(ReservationLogement::class)->findOneBy(array('idLogement' => $idlog, 'idUser' => $token));

               $em->remove($reserv);
               $em->flush();

                $entitymanager = $this->getDoctrine()->getManager();
                $logement = $entitymanager->getRepository(Logement::class)->find($idlog);
                $logement->setIsdisponible(true);
                $entitymanager->persist($logement);
                $entitymanager->flush();

       $serializer = new Serializer([new ObjectNormalizer()]);
       $formatted = $serializer->normalize($reserv);
       return new JsonResponse($formatted);
   }

    public function showallreservAction(Request $request)
    {

        $token =$request->get('idUser');
        //$city =$request->get('idCite');
        $entitymanager = $this->getDoctrine()->getManager();
        $events = $entitymanager->getRepository('AppBundle:Logement')->findReslog($token);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($events);
        return new JsonResponse($formatted);

    }


}
