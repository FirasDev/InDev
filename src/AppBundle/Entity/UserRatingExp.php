<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRatingExp
 *
 * @ORM\Table(name="user_rating_exp")
 * @ORM\Entity
 */
class UserRatingExp
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user_rating_exp", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUserRatingExp;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     */
    private $idUser;

    /**
     * @return int
     */
    public function getIdUserRatingExp()
    {
        return $this->idUserRatingExp;
    }

    /**
     * @param int $idUserRatingExp
     */
    public function setIdUserRatingExp($idUserRatingExp)
    {
        $this->idUserRatingExp = $idUserRatingExp;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
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



}

