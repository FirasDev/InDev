<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favoris
 *
 * @ORM\Table(name="favoris")
 * @ORM\Entity
 */
class Favoris
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_f", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idF;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_uf", type="integer", nullable=false)
     */
    private $idUf;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_fav", type="integer", nullable=false)
     */
    private $idFav;

    /**
     * @var string
     *
     * @ORM\Column(name="type_f", type="string", length=255, nullable=false)
     */
    private $typeF;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_f", type="datetime", nullable=false)
     */
    private $dateF = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getIdF()
    {
        return $this->idF;
    }

    /**
     * @param int $idF
     */
    public function setIdF($idF)
    {
        $this->idF = $idF;
    }

    /**
     * @return int
     */
    public function getIdUf()
    {
        return $this->idUf;
    }

    /**
     * @param int $idUf
     */
    public function setIdUf($idUf)
    {
        $this->idUf = $idUf;
    }

    /**
     * @return int
     */
    public function getIdFav()
    {
        return $this->idFav;
    }

    /**
     * @param int $idFav
     */
    public function setIdFav($idFav)
    {
        $this->idFav = $idFav;
    }

    /**
     * @return string
     */
    public function getTypeF()
    {
        return $this->typeF;
    }

    /**
     * @param string $typeF
     */
    public function setTypeF($typeF)
    {
        $this->typeF = $typeF;
    }

    /**
     * @return \DateTime
     */
    public function getDateF()
    {
        return $this->dateF;
    }

    /**
     * @param \DateTime $dateF
     */
    public function setDateF($dateF)
    {
        $this->dateF = $dateF;
    }



}

