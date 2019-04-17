<?php

namespace EventBundle\Controller;

use AppBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;

class EventAdminController extends Controller
{
    public function indexAction(Request $request)
    {

        $entitymanager = $this->getDoctrine()->getManager();

        $events = $entitymanager->getRepository(Evenement::class)->findAll();
        if ($request->isMethod("POST"))
        {

            $btn = $request->get('approuve');
            $event = $entitymanager->getRepository(Evenement::class)->find($btn);
            $event->setIsapproved(true);
            $entitymanager->flush();
        }

        return $this->render('EventBundle:EventAdmin:show_event.html.twig', array(
            'events'=>$events
        ));
    }

    public function StatAction()
    {


        $chart = new \CMEN\GoogleChartsBundle\GoogleCharts\Charts\Material\ColumnChart();
        $em= $this->getDoctrine();
        $event = $em->getRepository(Evenement::class)->findAll();
        dump($event);
        $chart->getData()->setArrayToDataTable([

            ['Event', 'Rate'],
            [$event[0]->getNom(), $event[0]->getRate()],
            [$event[1]->getNom(), $event[1]->getRate()],
            [$event[2]->getNom(), $event[2]->getRate()],
            [$event[3]->getNom(), $event[3]->getRate()],
            [$event[4]->getNom(), $event[4]->getRate()]

        ]);

        $chart->getOptions()->getChart()
            ->setTitle('Statistique Event')
            ->setSubtitle('les 5 premier evennements ');
        $chart->getOptions()
            ->setBars('vertical')
            ->setHeight(400)
            ->setWidth(850)
            ->setColors(['#1b9e77', '#d95f02', '#7570b3'])
            ->getVAxis()
            ->setFormat('decimal');
        return $this->render('@Event\EventAdmin\stat.html.twig', array('columnchart' => $chart));

    }
   /* public function StatAction()
    {

        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $events = $em->getRepository(Evenement::class)->findAll();
        $totalrating=count($events);





$data= array();
$stat=['event', 'rating'];
$nb=0;
array_push($data,$stat);
foreach($events as $event) {
    $stat=array();

    $count = $em->getRepository(Evenement::class)->findAll();

    array_push($stat,$event->getTitre(),);
    $nb=2;
    $stat=['test',2];
    array_push($data,$stat);

}
$pieChart->getData()->setArrayToDataTable(
    $data
);
$pieChart->getOptions()->setTitle('Pourcentages des étudiants par niveau');
$pieChart->getOptions()->setHeight(500);
$pieChart->getOptions()->setWidth(900);
$pieChart->getOptions()->getTitleTextStyle()->setBold(true);
$pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
$pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
$pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
$pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
return $this->render('@Event\EventAdmin\stat.html.twig', array('piechart' => $pieChart));
}*/
    }



