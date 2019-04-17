<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommExp
 *
 * @ORM\Table(name="comm_exp", indexes={@ORM\Index(name="FK_F9E17FB8981ABA41", columns={"id_experience"}), @ORM\Index(name="FK_F9E17FB86B3CA4B", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AppRepository")
 */
class CommExp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_comm_exp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommExp;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=false)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="commentDate", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $commentDate;

    /**
     * @var \DateTime|null
     * @ORM\Version
     * @ORM\Column(name="derniereModification", type="datetime", nullable=true, unique=false)
     */
    private $dernieremodification;

    /**
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp", referencedColumnName="id_experience",onDelete="CASCADE")
     * })
     */
    private $idExp;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * @return int
     */
    public function getIdCommExp()
    {
        return $this->idCommExp;
    }

    /**
     * @param int $idCommExp
     */
    public function setIdCommExp($idCommExp)
    {
        $this->idCommExp = $idCommExp;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return Experience
     */
    public function getIdExp()
    {
        return $this->idExp;
    }

    /**
     * @param Experience $idExp
     */
    public function setIdExp($idExp)
    {
        $this->idExp = $idExp;
    }


    /**
     * @return \DateTime
     */
    public function getCommentDate()
    {
        return $this->commentDate;
    }

    /**
     * @param \DateTime $commentDate
     */
    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }

    /**
     * @return \DateTime|null
     */
    public function getDernieremodification()
    {
        return $this->dernieremodification;
    }

    /**
     * @param \DateTime|null $dernieremodification
     */
    public function setDernieremodification($dernieremodification)
    {
        $this->dernieremodification = $dernieremodification;
    }

    /**
     * @return User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }




}

