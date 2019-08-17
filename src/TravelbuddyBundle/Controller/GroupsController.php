<?php

namespace TravelbuddyBundle\Controller;


use Proxies\__CG__\AppBundle\Entity\TravelBuddy;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\TravelGroup ;
use AppBundle\Entity ;
use Symfony\Component\HttpFoundation\Request;
use TravelbuddyBundle\Form\TravelGroupType;
use AppBundle\Repository ;
use Symfony\Component\HttpFoundation\JsonResponse ;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer ;
use Symfony\Component\Serializer\Serializer ;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


class GroupsController extends Controller {





    public function listAction()
    {

        $groups = $this->getDoctrine()
            ->getRepository(TravelGroup::class)->findAll();
        dump ($groups) ;
        return $this->render('@Travelbuddy/Groups/list.html.twig',
            array('groups'=> $groups));


    }

    public function mylistAction()
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            $user = $this->container->get('security.token_storage')->getToken()->getUser() ;


       $Buddy = $this->getDoctrine()
             ->getRepository(Entity\TravelBuddy::class)
              ->getBuddyByIdCurrentUser($user) ;

       $groups = $Buddy->getIdTravelGroup() ;


       $mygroup = $this->getDoctrine()
           ->getRepository(TravelGroup::class)
           ->findByIdOwner($user) ;

       dump(($mygroup)) ;

            return $this->render('@Travelbuddy/Groups/mylist.html.twig',
                array('groups' => $groups,
                    'mygroups' => $mygroup

                ));

        }

        else{
            return $this->redirectToRoute('fos_user_security_login') ;
        }

    }

    public function ajoutAction(Request $request)
    {     //to get CurrentUserID
        $user = $this->container->get('security.token_storage')->getToken()->getUser() ;
     ;
        //etape1.a créer un objet vide
        $group = new TravelGroup();
        //mettre le id dans l'obj
        //1.b.preparation du form
        $form = $this->createForm(TravelGroupType::class,$group);
        //2.1.Recup form
        $form = $form->handleRequest($request);
        //2.b.form validation
        if ($form->isValid()) {
            $group->setIdOwner($user) ;
            //getting the current travelBuddy by current user//
            $buddy=$this->getDoctrine()
                ->getRepository(Entity\TravelBuddy::class)
                ->getBuddyByIdCurrentUser($user);

            $group->addTravelBuddy($buddy);
            /** @var UploadedFile $file */
            $file = $group->getImageFile();
            $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

            $group->setImage($fileName);

            //3.a.prepration d'entity manager
            $em = $this->getDoctrine()->getManager();
            //3.b.persist l'objet dans l'orm
            $em->persist($group);
            //3.c.sauv ds BD
            $em->flush();
            //3.d.redit
            return $this->redirectToRoute('travelbuddy_CongratzGroup');

        }
        //1.c envoi d form
        return $this->render('@Travelbuddy/Groups/ajout.html.twig',
            array('form' => $form->createView()));

    }


    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    public function joinGroupAction($id)
    {
        //bolean variable if hes memebre//
        $ok = false ;

        //to get CurrentUserID
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //entity manager
        $em = $this->getDoctrine()->getManager();
        //recu de l'objet avec $id
        $group = $this->getDoctrine()
            ->getRepository(TravelGroup::class)
            ->find($id);


        //getting the current travelBuddy by current user//
        $buddy = $this->getDoctrine()
            ->getRepository(Entity\TravelBuddy::class)
            ->getBuddyByIdCurrentUser($user);

        if ($group->containsTravelBuddy($buddy)) {
        // return $this->alerdyMemberAction(); //
               $ok = false ;
        }
        else {
            $group->addTravelBuddy($buddy);
            //update dans la dataBase
            $em->flush();
            $title = $group->getTitle() ;

            $this->addFlash(
                'success',
                'Vous avez rejoint le groupe :',$title
            );
            return $this->redirectToRoute('travelbuddy_DetailGroup',  ['id' => $id]);
        }

    }





    public function detaillAction($id)
    {
        $ok = 'false' ;
        //here getting the group selected//
       $group = $this->getDoctrine()
            ->getRepository(TravelGroup::class)
            ->findByidTravelGroup($id);


    // here calling the method in repo that return one or null object..
        $group1 = $this->getDoctrine()
           ->getRepository(Entity\TravelGroup::class)
            ->getGroupByIdTravelBuddy($id);

// here using  get to get all members from that object //
        $members = $group1->getIdTravelBuddy() ;


//time to pass a bolean variable to show the join and quiter and escpace groupe boutom //
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            $buddy = $this->getDoctrine()
                ->getRepository(Entity\TravelBuddy::class)
                ->getBuddyByIdCurrentUser($user);
            if ($group1->containsTravelBuddy($buddy)) {

                $ok = 'true';
            }
        }
           dump($ok) ;
        return $this->render('@Travelbuddy/Groups/detaill.html.twig',
            array('groups'=> $group,
                'members'=> $members,
                 'ok' => $ok)
        ) ;
    }


    public function chatAction()
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){

        return $this->render('FOSMessageBundle/views/message.html.twig'); }

    else{
        return $this->redirectToRoute('fos_user_security_login') ;
    }
    }

    public function alerdyMemberAction(){
        return $this->render('@Travelbuddy/Groups/alerdyMember.html.twig');
    }

    public function rechercheAction(Request $request ){
        $destination=$request->get("destination");
        if(isset($destination)){
            $groups=$this->getDoctrine()
                ->getRepository(TravelGroup::class)
                ->getGroupByDestination($destination);
            return $this->render('@Travelbuddy/Groups/list.html.twig',
                array('groups'=> $groups)) ;

        }
        else if($destination =''){
        $groups = $this->getDoctrine()
            ->getRepository(TravelGroup::class)->findAll();
        return $this->render('@Travelbuddy/Groups/list.html.twig',
            array('groups'=> $groups)) ;}

    }


    public function statsAction()
    {

        $groups = $this->getDoctrine()
            ->getRepository(TravelGroup::class)->findAll();
        return $this->render('@Travelbuddy/Groups/stats.html.twig',
            array('groups' => $groups));



    }


   public function congratzAction()
   {

       return $this->render('@Travelbuddy/Groups/congratz.html.twig') ;
   }


   public function leaveAction($id){

       //to get CurrentUserID
       $user = $this->container->get('security.token_storage')->getToken()->getUser();

       $em = $this->getDoctrine()->getManager();

       $buddy=$this->getDoctrine()
           ->getRepository(Entity\TravelBuddy::class)
           ->getBuddyByIdCurrentUser($user) ;

      $group = $this->getDoctrine()
           ->getRepository(TravelGroup::class)->find($id) ;

    $group->removeIdTravelBuddy($buddy) ;

       $em->flush();
        $this->get('session')->getFlashBag()->add(
           'notice',
           'Vous avez quitter groupe'
       );

       return $this->redirectToRoute('travelbuddy_GroupsList');

       // i need add get all group members then test if hes there and send boolean to the view //
   }

    public function chatRoomAction()
    {

        return $this->render('@Travelbuddy/Groups/chatroom.html.twig') ;

    }


    public function espaceAction($id){
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {

            $group = $this->getDoctrine()
                ->getRepository(TravelGroup::class)
                ->findByIdTravelGroup($id);

            // here calling the method in repo that return one or null object..//
            $group1 = $this->getDoctrine()
                ->getRepository(Entity\TravelGroup::class)
                ->getGroupByIdTravelBuddy($id);

// here using  get to get all members from that object //
          // $members = $group1->getIdTravelBuddy() ;


//time to pass a bolean variable to show the join and quiter and escpace groupe boutom //


            return $this->render('@Travelbuddy/Groups/espace.html.twig',
                array('groups'=> $group,

                )
            ) ;

        }

    }


    public function updateAction(Request $request,$id){
        //etape1.a recupriation de l'objet avec $id
        $em=$this->getDoctrine()->getManager() ;
        //recu de l'objet avec $id
        $group=$this->getDoctrine()
            ->getRepository(TravelGroup::class)
            ->find($id);
        //1.b.preparation du form
        $form=$this->createForm(TravelGroupType::class,$group) ;
        //2.1.Recup form
        $form=$form->handleRequest($request) ;
        //2.b.form validation
        if($form->isValid()){
            //3.a.prepration d'entity manager
            $em=$this->getDoctrine()->getManager();
            //3.c.sauv ds BD
            $em->flush();
            //3.d.redit
            return $this->redirectToRoute('travelbuddy_MyGroupsList') ;

        }
        //1.c envoi d form
        return $this->render('@Travelbuddy/Groups/update.html.twig' ,
            array('form'=>$form->createView())) ;



    }

    public function deleteAction($id) {
        //entity manager
        $em=$this->getDoctrine()->getManager() ;
        //recu de l'objet avec $id
        $group=$this->getDoctrine()
            ->getRepository(TravelGroup::class)
            ->find($id);
        //delete object from ORM
        $em->remove($group);
        //delete from the data base
        $em->flush();

        return $this->redirectToRoute('travelbuddy_MyGroupsList') ;
    }


    public function adminAction(Request $request)
    {


        $groups=$this->getDoctrine()
            ->getRepository(TravelGroup::class)->findAll();



        return $this->render('@Travelbuddy/Groups/admin.html.twig',
            array('groups'=>$groups)) ;




    }


    public function updateAdminAction(Request $request,$id){
        //etape1.a recupriation de l'objet avec $id
        $em=$this->getDoctrine()->getManager() ;
        //recu de l'objet avec $id
        $group=$this->getDoctrine()
            ->getRepository(TravelGroup::class)
            ->find($id);
        //1.b.preparation du form
        $form=$this->createForm(TravelGroupType::class,$group) ;
        //2.1.Recup form
        $form=$form->handleRequest($request) ;
        //2.b.form validation
        if($form->isValid()){
            //3.a.prepration d'entity manager
            $em=$this->getDoctrine()->getManager();
            //3.c.sauv ds BD
            $em->flush();
            //3.d.redit
            return $this->redirectToRoute('travelbuddy_AdminGroup') ;

        }
        //1.c envoi d form
        return $this->render('@Travelbuddy/Groups/updateAdmin.html.twig' ,
            array('form'=>$form->createView())) ;



    }


    public function deleteAdminAction($id) {
        //entity manager
        $em=$this->getDoctrine()->getManager() ;
        //recu de l'objet avec $id
        $group=$this->getDoctrine()
            ->getRepository(TravelGroup::class)
            ->find($id);
        //delete object from ORM
        $em->remove($group);
        //delete from the data base
        $em->flush();

        return $this->redirectToRoute('travelbuddy_AdminGroup') ;
    }


    public function amitoAction() {

        return $this->render('@Travelbuddy/Amito/Amito.html.twig' ) ;


    }


    public function jsonlistAction()
    {


        $em = $this->getDoctrine()->getManager();
        $groups = $this->getDoctrine()->getManager()
            ->getRepository(TravelGroup::class)->JsonTest();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonEncoder = $serializer->normalize($groups);
        return new JsonResponse($jsonEncoder);

    }




    public function rechercheJsonAction($destination)
    {
        //créer une instance de notre entity  manager
        $groups = $this->getDoctrine()->getManager()
            ->getRepository(TravelGroup::class)->getGroupByDestinationJson($destination);
        $serializer = new Serializer([new ObjectNormalizer()]) ;
        dump($groups);
        $formatted = $serializer->normalize($groups);


        return new JsonResponse($formatted) ;
    }


    public function deleteGroupJson(Request $request){
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $group=$em->getRepository(TravelGroup::class)->find($id);
        $em->remove($group);
        $em->flush();
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function($object){
            return $object->getId();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($group);
        return new JsonResponse($formatted);
    }



    public function detailGroupjSONAction(Request $request)
    {
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $group=$em->getRepository(TravelGroup::class)->find($id);
        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $normalizer->setCircularReferenceHandler(function($object){
            return $object->getId();
        });
        $serializer = new Serializer([$normalizer], [$encoder]);
        $formatted = $serializer->normalize($group);
        return new JsonResponse($formatted);
    }


    public function jsonAddAction(Request $request)
    {
        $group = new TravelGroup();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Entity\User::class)->find(16);
        $group->setIdOwner($user);
        $group->setTitle($request->get('title'));
        $group->setDestination($request->get('destination'));
        $group->setPlan($request->get('plan'));
        $group->setDateDebut(new \DateTime('now'));
        $group->setImage('yop.png');
        $em->persist($group);
        $em->flush();
        return new JsonResponse();

    }


    public function ImagesAction(Request $request)
    {
        $publicResourcesFolderPath = $this->get('kernel')->getRootDir() . '/../web/assets/images/Buddy/';
        $image = $request->query->get("img");
        // This should return the file located in /mySymfonyProject/web/public-resources/TextFile.txt
        // to being viewed in the Browser
        return new BinaryFileResponse($publicResourcesFolderPath.$image);
    }


    public function deleteMobileAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->get("idT");
        $group = $em->getRepository(TravelGroup::class)->find($id);
        $em->remove($group);
        $em->flush();
        return new JsonResponse();
    }

}
