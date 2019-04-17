<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\ExpressionLanguage\Tests\Node\Obj;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * TravelGroup
 * @Vich\Uploadable
 * @ORM\Table(name="travel_group")
 * @ORM\Entity

 * @ORM\Entity(repositoryClass="AppBundle\Repository\TravelGroupRepository")
 */
class TravelGroup
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_travel_group", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTravelGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=33, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=30, nullable=false)
     */
    private $destination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="plan", type="string", length=100, nullable=false)
     */
    private $plan;


    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TravelBuddy", inversedBy="idTravelGroup")
     * @ORM\JoinTable(name="group_members",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_travel_group", referencedColumnName="id_travel_group")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_travel_buddy", referencedColumnName="id_travel_buddy")
     *   }
     * )
     */
    private $idTravelBuddy;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_owener", referencedColumnName="id")
     * })
     */
    private $idOwner;



    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;



    /**
     * @Vich\UploadableField(mapping="travelgroup", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idTravelBuddy = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdTravelGroup()
    {
        return $this->idTravelGroup;
    }

    /**
     * @param int $idTravelGroup
     */
    public function setIdTravelGroup($idTravelGroup)
    {
        $this->idTravelGroup = $idTravelGroup;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param \DateTime $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param \DateTime $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return string
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @param string $plan
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdTravelBuddy()
    {
        return $this->idTravelBuddy;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idTravelBuddy
     */
    public function setIdTravelBuddy($idTravelBuddy)
    {
        $this->idTravelBuddy = $idTravelBuddy;
    }


    //i added this method so i can add an element to the TravelBuddy Collection//
    public function addTravelBuddy(TravelBuddy $t){
        $this->idTravelBuddy->add($t);

    }

    //i added this method to test if hes alerdy on the group or not//
    public function containsTravelBuddy(TravelBuddy $t){
        return $this->idTravelBuddy->contains($t) ;
    }

    /**
     * Add idTravelBuddy
     *
     * @param \AppBundle\Entity\TravelBuddy $idTravelBuddy
     *
     * @return TravelGroup
     */
    public function addIdTravelBuddy(\AppBundle\Entity\TravelBuddy $idTravelBuddy)
    {
        $this->idTravelBuddy[] = $idTravelBuddy;

        return $this;
    }

    /**
     * Remove idTravelBuddy
     *
     * @param \AppBundle\Entity\TravelBuddy $idTravelBuddy
     */
    public function removeIdTravelBuddy(\AppBundle\Entity\TravelBuddy $idTravelBuddy)
    {
        $this->idTravelBuddy->removeElement($idTravelBuddy);
    }





    /**
     * Set idOwner
     *
     * @param \AppBundle\Entity\User $idOwner
     *
     * @return TravelGroup
     */
    public function setIdOwner(\AppBundle\Entity\User $idOwner = null)
    {
        $this->idOwner = $idOwner;

        return $this;
    }

    /**
     * Get idOwner
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdOwner()
    {
        return $this->idOwner;
    }
}
