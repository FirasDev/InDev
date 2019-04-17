<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Panier
 *
 * @ORM\Table(name="panier")
 * @ORM\Entity
 */
class Panier
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_pa", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPa;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_eq", type="integer", nullable=false)
     */
    private $idEq;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantite_pa", type="integer", nullable=false)
     */
    private $quantitePa;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=255, nullable=false)
     */
    private $etat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_pa", type="datetime", nullable=false)
     */
    private $datePa = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getIdPa()
    {
        return $this->idPa;
    }

    /**
     * @param int $idPa
     */
    public function setIdPa($idPa)
    {
        $this->idPa = $idPa;
    }

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param int $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getIdEq()
    {
        return $this->idEq;
    }

    /**
     * @param int $idEq
     */
    public function setIdEq($idEq)
    {
        $this->idEq = $idEq;
    }

    /**
     * @return int
     */
    public function getQuantitePa()
    {
        return $this->quantitePa;
    }

    /**
     * @param int $quantitePa
     */
    public function setQuantitePa($quantitePa)
    {
        $this->quantitePa = $quantitePa;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    /**
     * @return \DateTime
     */
    public function getDatePa()
    {
        return $this->datePa;
    }

    /**
     * @param \DateTime $datePa
     */
    public function setDatePa($datePa)
    {
        $this->datePa = $datePa;
    }



}

