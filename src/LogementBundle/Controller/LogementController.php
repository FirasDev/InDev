<?php

namespace LogementBundle\Controller;

use AppBundle\Entity\Cite;
use AppBundle\Entity\ImagesLogement;
use AppBundle\Entity\Unwantedwords;
use AppBundle\Repository\LogementRepository;
use AppBundle\Entity\Logement;
use AppBundle\Entity\LogementDetails;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\ReservationLogement;
use DateTime;
use Lunetics\LocaleBundle\Event\FilterLocaleSwitchEvent;
use Lunetics\LocaleBundle\LocaleBundleEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class LogementController extends Controller
{

    public function addLogementAction(Request $request)
    {

        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        $test2 = true;
        $massage="";



        if ($auth_checker->isGranted('ROLE_USER')) {
            $entitymanager = $this->getDoctrine()->getManager();
            $token = $this->container->get('security.token_storage')->getToken()->getUser();
            $description = $request->get('description');

            $titre = $request->get('titre');
            $prix = $request->get('prix');
            $cite = $request->get('cities');
            $user = $token->getId();
            $url = $request->get('url');
            $clim = $request->get('climatisation');
            $restauration = $request->get('restauration');
            $animaux = $request->get('animaux');
            $internet = $request->get('internet');
            $parking = $request->get('parking');
            $words = explode(" ", $description);
            $spaces=array();
            $others=array();

            $unwanted = $entitymanager->getRepository(Unwantedwords::class)->findAll();
            foreach($words as $word)
            {
                if($word==' ')
                {
                    array_push($spaces,$word);
                }
                else
                {
                    array_push($others,$word);
                }
            }
            for($i=0;$i<count($others);$i++)
            {
                for($j=0;$j<count($unwanted);$j++)
                {
                    if ($others[$i]==$unwanted[$j]->getWord())
                    {
                        $test2=false;
                    }
                }

            }

            if ($request->isMethod('POST')) {
                if ($test2 == true) {


                    $logdetails = new LogementDetails();
                    $logement = new Logement();

                    if ($clim == true) {
                        $logdetails->setClimatisation(true);
                    }
                    if ($restauration == true) {
                        $logdetails->setRestauration(true);
                    }
                    if ($animaux == true) {
                        $logdetails->setAnimaux(true);
                    }
                    if ($internet == true) {
                        $logdetails->setInternet(true);
                    }
                    if ($parking == true) {
                        $logdetails->setParking(true);
                    }


                    $city = $entitymanager->getRepository(Cite::class)->find($cite);

                    $logement->setTitre($titre);
                    $logement->setDescription($description);
                    $logement->setPrix($prix);
                    $logement->setIdCite($city);
                    $logement->setIdUser($user);

                    if (isset($_FILES["fileselect"]['name']))
                        if ($_FILES["fileselect"]['name'] != "") {
                            move_uploaded_file($_FILES['fileselect']['tmp_name'], __DIR__ . '/../../../web/images/' . $_FILES["fileselect"]['name']);
                            $logement->setUrl($_FILES["fileselect"]['name']);
                        }


                    if (isset($_FILES["upload"]['name'])) {
                        $total = count($_FILES['upload']['name']);
                        for ($i = 0; $i < $total; $i++) {
                            $images = new ImagesLogement();
                            if ($_FILES["upload"]['name'][$i] != "") {
                                move_uploaded_file($_FILES['upload']['tmp_name'][$i], __DIR__ . '/../../../web/images/' . $_FILES["upload"]['name'][$i]);
                                $images->setUrlImage($_FILES["upload"]['name'][$i]);
                                $images->setIdLogement($logement);

                            }
                            $entitymanager->persist($images);
                        }
                    }


                    $logdetails->setIdLogement($logement);
                    $entitymanager->persist($logdetails);
                    $entitymanager->persist($logement);
                    $entitymanager->flush();


                } else {
                    $massage = "the description has bad words";
                }
            }
            $cites = $entitymanager->getRepository(Cite::class)->findAll();

            return $this->render('LogementBundle:Logement:add_logement.html.twig', array(
                'cite' => $cites,'msg'=>$massage
            ));
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }

    public function showLogementAction()
    {

        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($auth_checker->isGranted('ROLE_USER')) {
            $session = new Session();

            $entitymanager = $this->getDoctrine()->getManager();
            $logements = $entitymanager->getRepository(Logement::class)->findBy(array('idCite' => $session->get('destination')));


            return $this->render('LogementBundle:Logement:showall.html.twig', array(

                'logements' => $logements

            ));
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }

    public function mesLogementAction(Request $request)
    {

        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($auth_checker->isGranted('ROLE_USER')) {
            $token = $this->container->get('security.token_storage')->getToken()->getUser();
            $entitymanager = $this->getDoctrine()->getManager();
            $save = $request->get('save');
            $delete = $request->get('delete');

            if (isset($save)) {
                $logement = $entitymanager->getRepository(Logement::class)->find($save);
                $logement->setTitre($request->get('t' . $save));
                $logement->setPrix($request->get('p' . $save));
                $logement->setDescription($request->get('d' . $save));

                $entitymanager->flush();
            }
            if (isset($delete)) {
                $logement = $entitymanager->getRepository(Logement::class)->find($delete);

                $entitymanager->remove($logement);
                $entitymanager->flush();

            }

            $logements = $entitymanager->getRepository(Logement::class)->findBy(array('idUser' => $token->getId()));


            return $this->render('LogementBundle:Logement:mes_logements.html.twig', array(

                'logs' => $logements

            ));
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }

    public function detailsLogementAction($id, Request $request)
    {


        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($auth_checker->isGranted('ROLE_USER')) {
            // set and get session attributes
            $wanted = new DateTime();
            $wanted2 = new DateTime();
            $session = new Session();

            if($session->get('date_start') != null ) {
                $wanted = new DateTime($session->get('date_start'));
                $wanted2 = new DateTime($session->get('date_end'));
                $test = 1;
            }
            else
            {
                $test= 0;


            }
            $token = $this->container->get('security.token_storage')->getToken()->getUser();

            $entitymanager = $this->getDoctrine()->getManager();

            $logement = $entitymanager->getRepository(Logement::class)->find($id);

            $logdetails = $entitymanager->getRepository(LogementDetails::class)->findOneBy(array('idLogement' => $id));
            $images = $entitymanager->getRepository(ImagesLogement::class)->findBy(array('idLogement' => $logement->getId()));
            $city = $logement->getIdCite();

            if ($request->isMethod("POST")) {
                $date_start = new DateTime($session->get('date_start'));
                $date_end = new DateTime($session->get('date_end'));

                \Stripe\Stripe::setApiKey("sk_test_flb9vUYyiwC85Wx2ONpANeYf");
                $amount = $request->get('dataAmount');
                $idlog = $request->get('idlog');
                //dump($amount);
                // Token is created using Checkout or Elements!
                // Get the payment token ID submitted by the form:
                $charge = \Stripe\Charge::create([
                    'amount' => $amount,
                    'currency' => 'usd',
                    'description' => 'Example charge',
                    'source' => 'tok_visa',
                ]);

                dump($status = $charge->getLastResponse());

                $reservation = new ReservationLogement();
                $reservation->setIdUser($token->getId());
                $reservation->setIdLogement($idlog);
                $reservation->setDateArrive($date_start);
                $reservation->setDateDepart($date_end);
                $logement->setIsdisponible(false);
                $entitymanager->persist($reservation);
                $entitymanager->flush();
                return $this->redirectToRoute('success');


            }

            $res = $entitymanager->getRepository(ReservationLogement::class)->findBy(array('idLogement' => $id));
           // dump($res);
            $current = null;
            if (!empty($res)) {
                $current = $res[count($res) - 1]->getDateDepart();
            }
            $diff = date_diff($wanted, $wanted2);
///////////////// date debut et fin ::
            $total = $logement->getPrix() * $diff->d * 100;

            return $this->render('LogementBundle:Logement:details_logement.html.twig', array(

                'log' => $logement,'testdate'=>$test, 'details' => $logdetails, 'city' => $city, 'datestart' => $wanted,'datedepart'=>$wanted2, 'current' => $current, 'images' => $images, 'total' => $total
            ));
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }

    public function successAction()
    {

        $token = $this->container->get('security.token_storage')->getToken()->getUser();
        $mailer= $this->get('mailer');
///////// nexmo sms
        $basic  = new \Nexmo\Client\Credentials\Basic('2984de11', 'S0Oi9iK03G05wmSD');
        $client = new \Nexmo\Client($basic);

        $message = $client->message()->send([
            'to' => '21699244073',
            'from' => 'AMITICIA',
            'text' => 'Merci pour votre reservation'
        ]);


        ////////////////  mailing

        $msg = (new \Swift_Message('AMITICA '))
            ->setFrom('No-Reply@amiticia.tn')
            ->setTo('driss.abderrahmen@esprit.tn')
            ->setBody('Merci pour votre reservation');

        $mailer->send($msg);


        return $this->render('@Logement\Logement\success.html.twig', array(


        ));

    }

    public function showReservationAction(Request $request)
    {

        $auth_checker = $this->get('security.authorization_checker');
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($auth_checker->isGranted('ROLE_USER')) {
            $token = $this->container->get('security.token_storage')->getToken()->getUser();
            $user = $token->getId();

            if ($request->isMethod('POST')) {

                $id = $request->get('idres');
                //the manager is the responsible for saving objects, deleting and updating object

                $em = $this->getDoctrine()->getManager();

                $reserv = $em->getRepository(ReservationLogement::class)->findOneBy(array('idLogement' => $id, 'idUser' => $user));


                //the remove() method notifies Doctrine that you'd like to remove the given object from the database
                $em->remove($reserv);

                //The flush() method execute the DELETE query.

                $em->flush();
            }

            $token = $this->container->get('security.token_storage')->getToken()->getUser();
            $entitymanager = $this->getDoctrine()->getManager();
            $reserv = $entitymanager->getRepository(Logement::class)->findreservation($token->getId());
            return $this->render('@Logement\Logement\reservations.html.twig', array(

                'logs' => $reserv

            ));
        }
        else
        {
            return $this->redirectToRoute('homepage');
        }
    }

    public function showallAction()
    {
        $session = new Session();
        $entitymanager = $this->getDoctrine()->getManager();

        $logements = $entitymanager->getRepository(Logement::class)->findAll();

        return $this->render('LogementBundle:Logement:showall.html.twig', array(

            'logements'=>$logements

        ));

    }

}
