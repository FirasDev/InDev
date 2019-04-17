<?php
/**
 * Created by PhpStorm.
 * User: Firas
 * Date: 4/9/2019
 * Time: 2:05 PM
 */

namespace ExperienceBundle\Controller;

use AppBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;


class NotificationController extends Controller
{

    function AllNotificationJsonAction(Request $request){
        $output = [];
        $plein_text = $request->get('plein_text');
        $repository = $this->getDoctrine()->getRepository('AppBundle:Notification');
        $results=$repository->createQueryBuilder('a')
            ->where("a.idUser = '$plein_text'")
            ->getQuery()->getArrayResult();

        $count = $repository->createQueryBuilder('v')
            ->where("v.status = '0'")
            ->andWhere("v.idUser ='$plein_text'")
            ->select('count(v.id)')
            ->getQuery()
            ->getSingleScalarResult();

        if($results!= null || !empty($results)){
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                $header='<a class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">Vous avez '.$count.' notifications
                            </p>
                        </a>
                        <div class="dropdown-divider"></div>';
                array_push($output , $header);
            }

            foreach ($results as $notif){
                if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                    $o='<a class="list-group-item dropdown-item" href="javascript:void(0)" role="menuitem">
                                        <div class="media">
                                            <div class="pr-10">
                                                <i class="icon md-receipt bg-red-600 white icon-circle" aria-hidden="true"></i>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading">'.$notif["subject"].'</h6>
                                                <p class="font-weight-light small-text">
                                                        '.$notif["text"].'
                                                </p>
                                                <time class="media-meta" datetime="2017-06-12T20:50:48+08:00">'.$notif["dateNotification"].'</time>
                                            </div>
                                        </div>
                                    </a>';
                }
                else{

                    $o = '<li> <a href="#">
                    <strong>'.$notif["subject"].'</strong><br/>
                    <small><em>'.$notif["text"].'</em></small></a></li>';
                }

                array_push($output , $o);
            }
        }
        else{
            if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
                $output = '<a class="dropdown-item">
                            <p class="mb-0 font-weight-normal float-left">Pas de notification
                            </p>
                        </a>';
            }else{
                $output = '<li> <a href="#">
                    <strong>Pas de notification</strong>
                    </a></li>';
            }
        }

        $data = array(
            'notification'   => $output,
            'unseen_notification' => $count
        );
        return new JsonResponse($data);
    }

    function UpdateNotificationJsonAction(Request $request){

        $notifInf = $this->getDoctrine()->getRepository(Notification::class)->findAll();
        foreach ($notifInf as $notif){
            $notif->setStatus(1);
            $em = $this->getDoctrine()->getManager();
            $em->persist($notif);
            $em->flush();
        }
        return new JsonResponse("update");
    }


}