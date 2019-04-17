<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amis
 *
 * @ORM\Table(name="amis")
 * @ORM\Entity
 */
class Amis
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_a", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idA;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_ue", type="integer", nullable=false)
     */
    private $idUe;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_ur", type="integer", nullable=false)
     */
    private $idUr;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat_a", type="integer", nullable=false)
     */
    private $etatA = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_a", type="datetime", nullable=false)
     */
    private $dateA = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getIdA()
    {
        return $this->idA;
    }

    /**
     * @param int $idA
     */
    public function setIdA($idA)
    {
        $this->idA = $idA;
    }

    /**
     * @return int
     */
    public function getIdUe()
    {
        return $this->idUe;
    }

    /**
     * @param int $idUe
     */
    public function setIdUe($idUe)
    {
        $this->idUe = $idUe;
    }

    /**
     * @return int
     */
    public function getIdUr()
    {
        return $this->idUr;
    }

    /**
     * @param int $idUr
     */
    public function setIdUr($idUr)
    {
        $this->idUr = $idUr;
    }

    /**
     * @return int
     */
    public function getEtatA()
    {
        return $this->etatA;
    }

    /**
     * @param int $etatA
     */
    public function setEtatA($etatA)
    {
        $this->etatA = $etatA;
    }

    /**
     * @return \DateTime
     */
    public function getDateA()
    {
        return $this->dateA;
    }

    /**
     * @param \DateTime $dateA
     */
    public function setDateA($dateA)
    {
        $this->dateA = $dateA;
    }



}

