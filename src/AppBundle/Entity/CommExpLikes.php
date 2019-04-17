<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommExpLikes
 *
 * @ORM\Table(name="comm_exp_likes", indexes={@ORM\Index(name="id_comm_x3", columns={"id_comment"}), @ORM\Index(name="id_user_x3", columns={"id_user"})})
 * @ORM\Entity
 */
class CommExpLikes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_likes", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLikes;

    /**
     * @var \CommExp
     *
     * @ORM\ManyToOne(targetEntity="CommExp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comment", referencedColumnName="id_comm_exp")
     * })
     */
    private $idComment;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;


}

