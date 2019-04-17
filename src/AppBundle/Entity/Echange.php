<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Echange
 *
 * @ORM\Table(name="echange")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EchangeRepository")
 */
class Echange
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="demande", type="string", length=255)
     */
    private $demande;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255, nullable = true)
     */
    private $reponse;


    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id1", referencedColumnName="id")
     */
    private $idUser1;


    /**
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id2", referencedColumnName="id")
     */
    private $idUser2;


    /**
     * @ORM\ManyToOne(targetEntity="Equipement")
     * @ORM\JoinColumn(name="equipement_id1", referencedColumnName="id_eq")
     */
    private $equipement1;



    /**
     * @ORM\ManyToOne(targetEntity="Equipement")
     * @ORM\JoinColumn(name="equipement_id1", referencedColumnName="id_eq")
     */
    private $equipement2;





    public function __toString()
    {
        return '';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set demande
     *
     * @param string $demande
     *
     * @return Echange
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return string
     */
    public function getDemande()
    {
        return $this->demande;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return Echange
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;

        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set idUser1
     *
     * @param \AppBundle\Entity\User $idUser1
     *
     * @return Echange
     */
    public function setIdUser1(\AppBundle\Entity\User $idUser1 = null)
    {
        $this->idUser1 = $idUser1;

        return $this;
    }

    /**
     * Get idUser1
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdUser1()
    {
        return $this->idUser1;
    }

    /**
     * Set idUser2
     *
     * @param \AppBundle\Entity\User $idUser2
     *
     * @return Echange
     */
    public function setIdUser2(\AppBundle\Entity\User $idUser2 = null)
    {
        $this->idUser2 = $idUser2;

        return $this;
    }

    /**
     * Get idUser2
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdUser2()
    {
        return $this->idUser2;
    }

    /**
     * Set equipement1
     *
     * @param \AppBundle\Entity\Equipement $equipement1
     *
     * @return Echange
     */
    public function setEquipement1(\AppBundle\Entity\Equipement $equipement1 = null)
    {
        $this->equipement1 = $equipement1;

        return $this;
    }

    /**
     * Get equipement1
     *
     * @return \AppBundle\Entity\Equipement
     */
    public function getEquipement1()
    {
        return $this->equipement1;
    }

    /**
     * Set equipement2
     *
     * @param \AppBundle\Entity\Equipement $equipement2
     *
     * @return Echange
     */
    public function setEquipement2(\AppBundle\Entity\Equipement $equipement2 = null)
    {
        $this->equipement2 = $equipement2;

        return $this;
    }

    /**
     * Get equipement2
     *
     * @return \AppBundle\Entity\Equipement
     */
    public function getEquipement2()
    {
        return $this->equipement2;
    }
}
