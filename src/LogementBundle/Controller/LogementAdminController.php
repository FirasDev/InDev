<?php

namespace LogementBundle\Controller;

use AppBundle\Entity\Cite;
use AppBundle\Entity\Logement;
use AppBundle\Entity\LogementDetails;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LogementAdminController extends Controller
{
    public function showLogementAction(Request $request)
    {

        $entitymanager = $this->getDoctrine()->getManager();

        $approuve = $request->get('approuve');
        $desapprouve = $request->get('desapprouve');
        $logements = $entitymanager->getRepository(Logement::class)->findAll();
        if (isset($approuve))
        {

            $logement = $entitymanager->getRepository(Logement::class)->find($approuve);
            $logement->setIsapproved(true);
            $entitymanager->flush();
        }
        if(isset($desapprouve))
        {
            $logement = $entitymanager->getRepository(Logement::class)->find($desapprouve);
            $logdetails = $entitymanager->getRepository(LogementDetails::class)->findOneBy(array('idLogement' => $desapprouve));
            $entitymanager->remove($logdetails);
            $entitymanager->remove($logement);
            $entitymanager->flush();

        }

        return $this->render('LogementBundle:LogementAdmin:show_logement.html.twig', array(
            'logements'=>$logements
            // ...
        ));
    }

    public  function addCiteAction(Request $request)
    {
                $entitymanager = $this->getDoctrine()->getManager();

                $add = $request->get('addcite');
                $delete = $request->get('delete');

                if (isset($add))
                {
                  $cite = new Cite();
                  $cite->setNomCite($request->get('cite'));
                  $entitymanager->persist($cite);
                  $entitymanager->flush();

                }
                if(isset($delete))
                {
            $city = $entitymanager->getRepository(Cite::class)->find($delete);
                    $entitymanager->remove($city);
                    $entitymanager->flush();
                }

                $cities = $entitymanager->getRepository(Cite::class)->findAll();
        return $this->render('LogementBundle:LogementAdmin:cite.html.twig', array( 'cities'=>$cities

        ));

    }

}
