<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluation
 *
 * @ORM\Table(name="evaluation")
 * @ORM\Entity
 */
class Evaluation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_ev", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEv;

    /**
     * @var integer
     *
     * @ORM\Column(name="id-eq", type="integer", nullable=true)
     */
    private $idEq;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="favori", type="string", length=255, nullable=true)
     */
    private $favori;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ev", type="datetime", nullable=false)
     */
    private $dateEv = 'CURRENT_TIMESTAMP';

    /**
     * @return int
     */
    public function getIdEv()
    {
        return $this->idEv;
    }

    /**
     * @param int $idEv
     */
    public function setIdEv($idEv)
    {
        $this->idEv = $idEv;
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
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return string
     */
    public function getFavori()
    {
        return $this->favori;
    }

    /**
     * @param string $favori
     */
    public function setFavori($favori)
    {
        $this->favori = $favori;
    }

    /**
     * @return \DateTime
     */
    public function getDateEv()
    {
        return $this->dateEv;
    }

    /**
     * @param \DateTime $dateEv
     */
    public function setDateEv($dateEv)
    {
        $this->dateEv = $dateEv;
    }



}

