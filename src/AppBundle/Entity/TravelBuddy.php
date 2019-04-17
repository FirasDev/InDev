<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * TravelBuddy
 * @Vich\Uploadable
 * @ORM\Table(name="travel_buddy", indexes={@ORM\Index(name="fk_id_user3", columns={"id_user"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TravelBuddyRepository")
 */
class TravelBuddy
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_travel_buddy", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTravelBuddy;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=100, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="destination", type="string", length=50, nullable=false)
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
     * @ORM\Column(name ="image",type="string", length=255)
     * @var string
     */
    private $image;


    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="TravelGroup", mappedBy="idTravelBuddy")
     */
    private $idTravelGroup;

    /**
     * Constructor
     */
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



    public function __construct()
    {
        $this->idTravelGroup = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return int
     */
    public function getIdTravelBuddy()
    {
        return $this->idTravelBuddy;
    }

    /**
     * @param int $idTravelBuddy
     */
    public function setIdTravelBuddy($idTravelBuddy)
    {
        $this->idTravelBuddy = $idTravelBuddy;
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
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
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


    /**
     * @return \User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdTravelGroup()
    {
        return $this->idTravelGroup;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idTravelGroup
     */
    public function setIdTravelGroup($idTravelGroup)
    {
        $this->idTravelGroup = $idTravelGroup;
    }



    /**
     * Add idTravelGroup
     *
     * @param \AppBundle\Entity\TravelGroup $idTravelGroup
     *
     * @return TravelBuddy
     */
    public function addIdTravelGroup(\AppBundle\Entity\TravelGroup $idTravelGroup)
    {
        $this->idTravelGroup[] = $idTravelGroup;

        return $this;
    }

    /**
     * Remove idTravelGroup
     *
     * @param \AppBundle\Entity\TravelGroup $idTravelGroup
     */
    public function removeIdTravelGroup(\AppBundle\Entity\TravelGroup $idTravelGroup)
    {
        $this->idTravelGroup->removeElement($idTravelGroup);
    }
}
