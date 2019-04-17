<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AlbumExperience
 *
 * @ORM\Table(name="album_experience")
 * @ORM\Entity
 */
class AlbumExperience
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_album_experience", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAlbumExperience;

    /**
     * @var string
     *
     * @ORM\Column(name="image_url", type="text", length=65535, nullable=false)
     */
    private $imageUrl;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_experience", type="integer", nullable=false)
     */
    private $idExperience;

    /**
     * @return int
     */
    public function getIdAlbumExperience()
    {
        return $this->idAlbumExperience;
    }

    /**
     * @param int $idAlbumExperience
     */
    public function setIdAlbumExperience($idAlbumExperience)
    {
        $this->idAlbumExperience = $idAlbumExperience;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @return int
     */
    public function getIdExperience()
    {
        return $this->idExperience;
    }

    /**
     * @param int $idExperience
     */
    public function setIdExperience($idExperience)
    {
        $this->idExperience = $idExperience;
    }



}

