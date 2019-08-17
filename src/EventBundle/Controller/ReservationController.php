<?php

namespace EventBundle\Controller;

use AppBundle\Entity\Evenement;
use AppBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ReservationController extends Controller
{
    public function validationAction()
    {

        $date = new \DateTime();
        $token = $this->container->get('security.token_storage')->getToken()->getUser();
        $mailer= $this->get('mailer');

        $basic  = new \Nexmo\Client\Credentials\Basic('2984de11', 'S0Oi9iK03G05wmSD');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '21699244073',
            'from' => 'AMITICIA',
            'text' => 'Merci pour votre reservation'
        ]);

        $msg = (new \Swift_Message('AMITICA '))
            ->setFrom('No-Reply@amiticia.tn')
            ->setTo('amine.hamdi@esprit.tn')
            ->setBody('Merci pour votre reservation');

        $mailer->send($msg);

        $reservations = $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        $session = new Session();

        ////////////// qr code
        $options = array(
            'code'   => 'string to encode',
            'type'   => 'qrcode',
            'format' => 'html',
        );

        $barcode =
            $this->get('skies_barcode.generator')->generate($options);



        return $this->render('EventBundle:Reservation:validation.html.twig', array(

            $barcode,'nom'=>$session->get('eventnom'),'number'=>count($reservations)

        ));
    }

    ////////// mes reservations
    public function historyAction(Request $request)
    {
        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($auth_checker->isGranted('ROLE_USER')) {


        $token = $this->container->get('security.token_storage')->getToken()->getUser();
        $user = $token->getId();
        $entitymanager = $this->getDoctrine()->getManager();
        $reserv = $entitymanager->getRepository(Reservation::class)->findBy(array('idUser' => $user));
dump($reserv);
        if ($request->isMethod('POST')) {
            $btn = $request->get('idres');
            $result = $entitymanager->getRepository(Reservation::class)->find($btn);
            $ev = $entitymanager->getRepository(Evenement::class)->find($result->getIdEvent());
            $ev->setNbrPlace($ev->getNbrPlace() + $result->getNbrPlace());
            //the remove() method notifies Doctrine that you'd like to remove the given object from the database
            $entitymanager->remove($result);

            //The flush() method execute the DELETE query.
            $entitymanager->flush();
        }
        return $this->render('EventBundle:Reservation:reservation_event.html.twig', array(

            'reservations' => $reserv
        ));
    }
    else
        {
            return $this->redirectToRoute('homepage');
                    }
    }

}
