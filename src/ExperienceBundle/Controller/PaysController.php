<?php

namespace ExperienceBundle\Controller;

use AppBundle\Entity\Pays;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Dwr\OpenWeatherBundle\Utility\Converter;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Pay controller.
 *
 * @Route("pays")
 */
class PaysController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $pays = $em->getRepository('AppBundle:Pays')->findAll();

        if($request->isXmlHttpRequest()){
            $pays = $em->getRepository("AppBundle:Pays")->findOneBy(array('name' => $request->get("namepays")));

            return $this->redirectToRoute('pays_meteo', ['name' => $pays]);

        }
        return $this->render('ExperienceBundle:pays:index.html.twig', array(
            'pays' => $pays,
        ));
    }


    public function PaysMeteoAction($name)
    {


        $em = $this->getDoctrine()->getManager();
        $pays = $em->getRepository("AppBundle:Pays")->findOneBy(array('name' => $name));
        $openWeather = $this->get('dwr_open_weather');
        $weather = $openWeather->setType('Weather')->getByCityName($pays->getCapital());


        return $this->render('ExperienceBundle:pays:country_weather.html.twig', array(
            'weather' => $weather,
            'pays' => $pays,
        ));
    }

    public function PaysMeteoStatsAction($name)
    {

        $em = $this->getDoctrine()->getManager();
        $pays = $em->getRepository("AppBundle:Pays")->findOneBy(array('name' => $name));
        $openWeather = $this->get('dwr_open_weather');

        $city1 = $pays->getCapital();
        $forecastCity1 = $openWeather->setType('Forecast')->getByCityName($pays->getCapital());
        $forecastCity1Labels = json_encode(array_map(function ($value) {
            return Converter::intToDate($value['dt'], 'd-m-Y H:i');
        }, $forecastCity1->lists()));
        $forecastCity1Temps = json_encode(array_map(function ($value) {
            return Converter::kelvinToCelsius($value['main']['temp']);
        }, $forecastCity1->lists()));

        return $this->render('ExperienceBundle:pays:statistics.html.twig', array(
            'city1' => $city1,
            'forecastCity1' => $forecastCity1,
            'forecastCity1Temps' => $forecastCity1Temps,
            'forecastCity1Labels' => $forecastCity1Labels,
            'pays' => $pays,
        ));
    }

    /**
     * Creates a new pay entity.
     *
     * @Route("/new", name="pays_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pay = new Pay();
        $form = $this->createForm('AppBundle\Form\PaysType', $pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pay);
            $em->flush();

            return $this->redirectToRoute('pays_show', array('id' => $pay->getId()));
        }

        return $this->render('pays/new.html.twig', array(
            'pay' => $pay,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pay entity.
     *
     * @Route("/{id}", name="pays_show")
     * @Method("GET")
     */
    public function showAction(Pays $pay)
    {
        $deleteForm = $this->createDeleteForm($pay);

        return $this->render('pays/show.html.twig', array(
            'pay' => $pay,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pay entity.
     *
     * @Route("/{id}/edit", name="pays_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pays $pay)
    {
        $deleteForm = $this->createDeleteForm($pay);
        $editForm = $this->createForm('AppBundle\Form\PaysType', $pay);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pays_edit', array('id' => $pay->getId()));
        }

        return $this->render('pays/edit.html.twig', array(
            'pay' => $pay,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pay entity.
     *
     * @Route("/{id}", name="pays_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pays $pay)
    {
        $form = $this->createDeleteForm($pay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pay);
            $em->flush();
        }

        return $this->redirectToRoute('pays_index');
    }

    /**
     * Creates a form to delete a pay entity.
     *
     * @param Pays $pay The pay entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pays $pay)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pays_delete', array('id' => $pay->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
