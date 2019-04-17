<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LogementDetails
 *
 * @ORM\Table(name="logement_details")
 * @ORM\Entity
 */
class LogementDetails
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Logement
     *
     * @ORM\OneToOne(targetEntity="Logement")
     *   @ORM\JoinColumn(name="id_logement", referencedColumnName="id",onDelete="CASCADE")
     */
    private $idLogement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Climatisation", type="boolean", nullable=false)
     */
    private $climatisation = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="Parking", type="boolean", nullable=false)
     */
    private $parking = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="Internet", type="boolean", nullable=false)
     */
    private $internet = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="Animaux", type="boolean", nullable=false)
     */
    private $animaux = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="Restauration", type="boolean", nullable=false)
     */
    private $restauration = '0';



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set climatisation
     *
     * @param boolean $climatisation
     *
     * @return LogementDetails
     */
    public function setClimatisation($climatisation)
    {
        $this->climatisation = $climatisation;

        return $this;
    }

    /**
     * Get climatisation
     *
     * @return boolean
     */
    public function getClimatisation()
    {
        return $this->climatisation;
    }

    /**
     * Set parking
     *
     * @param boolean $parking
     *
     * @return LogementDetails
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return boolean
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set internet
     *
     * @param boolean $internet
     *
     * @return LogementDetails
     */
    public function setInternet($internet)
    {
        $this->internet = $internet;

        return $this;
    }

    /**
     * Get internet
     *
     * @return boolean
     */
    public function getInternet()
    {
        return $this->internet;
    }

    /**
     * Set animaux
     *
     * @param boolean $animaux
     *
     * @return LogementDetails
     */
    public function setAnimaux($animaux)
    {
        $this->animaux = $animaux;

        return $this;
    }

    /**
     * Get animaux
     *
     * @return boolean
     */
    public function getAnimaux()
    {
        return $this->animaux;
    }

    /**
     * Set restauration
     *
     * @param boolean $restauration
     *
     * @return LogementDetails
     */
    public function setRestauration($restauration)
    {
        $this->restauration = $restauration;

        return $this;
    }

    /**
     * Get restauration
     *
     * @return boolean
     */
    public function getRestauration()
    {
        return $this->restauration;
    }

    /**
     * Set idLogement
     *
     * @param \AppBundle\Entity\Logement $idLogement
     *
     * @return LogementDetails
     */
    public function setIdLogement(\AppBundle\Entity\Logement $idLogement = null)
    {
        $this->idLogement = $idLogement;

        return $this;
    }

    /**
     * Get idLogement
     *
     * @return \AppBundle\Entity\Logement
     */
    public function getIdLogement()
    {
        return $this->idLogement;
    }
}
