<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Logement
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LogementRepository")
 * @ORM\Table(name="logement", indexes={@ORM\Index(name="logement_fk", columns={"id_cite"})})
 */
class Logement
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
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=100, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="prix", type="integer", nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="URL", type="string", length=500, nullable=true)
     */
    private $url;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isapproved", type="boolean", nullable=true)
     */
    private $isapproved = '0';

    /**
     * @var boolean
     *
     * @ORM\Column(name="isdisponible", type="boolean", nullable=false)
     */
    private $isdisponible = '1';

    /**
     * @var \Cite
     *
     * @ORM\ManyToOne(targetEntity="Cite")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_cite", referencedColumnName="id_cite",onDelete="CASCADE")
     * })
     */
    private $idCite;



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
     * Set titre
     *
     * @param string $titre
     *
     * @return Logement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Logement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Logement
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Logement
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return integer
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Logement
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set isapproved
     *
     * @param boolean $isapproved
     *
     * @return Logement
     */
    public function setIsapproved($isapproved)
    {
        $this->isapproved = $isapproved;

        return $this;
    }

    /**
     * Get isapproved
     *
     * @return boolean
     */
    public function getIsapproved()
    {
        return $this->isapproved;
    }

    /**
     * Set isdisponible
     *
     * @param boolean $isdisponible
     *
     * @return Logement
     */
    public function setIsdisponible($isdisponible)
    {
        $this->isdisponible = $isdisponible;

        return $this;
    }

    /**
     * Get isdisponible
     *
     * @return boolean
     */
    public function getIsdisponible()
    {
        return $this->isdisponible;
    }

    /**
     * Set idCite
     *
     * @param \AppBundle\Entity\Cite $idCite
     *
     * @return Logement
     */
    public function setIdCite(\AppBundle\Entity\Cite $idCite = null)
    {
        $this->idCite = $idCite;

        return $this;
    }

    /**
     * Get idCite
     *
     * @return \AppBundle\Entity\Cite
     */
    public function getIdCite()
    {
        return $this->idCite;
    }
}
