<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Cite;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Notification;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $session = new Session();
        $entitymanager = $this->getDoctrine()->getManager();
        $result = $entitymanager->getRepository(Evenement::class)->findRecommended();
        $recommends = array();
        $date = new \DateTime();
        $date2 = new \DateTime();
        $date2->modify('+1 day');
        $resul2 = $date2->format('Y-m-d');
        $resul = $date->format('Y-m-d');
        if(count($result)/3 >= 1)
        {
            array_push($recommends,$result[0]);
            array_push($recommends,$result[1]);
            array_push($recommends,$result[2]);

        }

        if ($request->isMethod('POST'))
        {
            $session->set('date_start', $request->get('date_start'));
            $session->set('date_end', $request->get('date_end'));
            $session->set('destination',$request->get('criteria'));

            dump($session);


            return $this->redirectToRoute('show_logement');
        }
        else {
            $cites = $entitymanager->getRepository(Cite::class)->findAll();
            dump($cites);
            // replace this example code with whatever you need
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR, 'cities' => $cites,'datemin'=>$resul,'datemin2'=>$resul2,'recommends'=>$recommends
            ]);
        }
    }

    /**
     * @Route("/admin", name="adminpage")
     */
    public function indexbackAction()
    {


        $entitymanager = $this->getDoctrine()->getManager();

        $notifs = $entitymanager->getRepository(Notification::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('default/indexback.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,'notifs'=>$notifs,'count'=>count($notifs)
        ]);

    }

    /**
     * @Route("/admin", name="backoffice")
     */
    public function backofficeAction(Request $request)
    {
        return $this->render('default/indexback.html.twig');
    }




}
