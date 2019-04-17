<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Grade
 *
 * @ORM\Table(name="grade")
 * @ORM\Entity
 */
class Grade
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_g", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idG;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_ug", type="integer", nullable=false)
     */
    private $idUg;

    /**
     * @var string
     *
     * @ORM\Column(name="grade", type="string", length=100, nullable=false)
     */
    private $grade = 'new member';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_g", type="datetime", nullable=false)
     */
    private $dateG = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getIdG()
    {
        return $this->idG;
    }

    /**
     * @param int $idG
     */
    public function setIdG($idG)
    {
        $this->idG = $idG;
    }

    /**
     * @return int
     */
    public function getIdUg()
    {
        return $this->idUg;
    }

    /**
     * @param int $idUg
     */
    public function setIdUg($idUg)
    {
        $this->idUg = $idUg;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return \DateTime
     */
    public function getDateG()
    {
        return $this->dateG;
    }

    /**
     * @param \DateTime $dateG
     */
    public function setDateG($dateG)
    {
        $this->dateG = $dateG;
    }



}

