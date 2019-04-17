<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FollowedExp
 *
 * @ORM\Table(name="followedexp", indexes={@ORM\Index(name="id_user_x2", columns={"id_user"}), @ORM\Index(name="id_exp_x2", columns={"id_exp"})})
 * @ORM\Entity
 */
class FollowedExp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_follow", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFollow;

    /**
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_exp", referencedColumnName="id_experience", nullable=true, onDelete="SET NULL")
     * })
     */
    private $idExp;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     */
    private $idUser;

    /**
     * @return int
     */
    public function getIdFollow()
    {
        return $this->idFollow;
    }

    /**
     * @param int $idFollow
     */
    public function setIdFollow(int $idFollow)
    {
        $this->idFollow = $idFollow;
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
    public function setIdExp( $idExp)
    {
        $this->idExp = $idExp;
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

