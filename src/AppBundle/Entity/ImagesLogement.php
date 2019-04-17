<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ImagesLogement
 *
 * @ORM\Table(name="images_logement")
 * @ORM\Entity
 */
class ImagesLogement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_image", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idImage;

    /**
     * @var string
     *
     * @ORM\Column(name="url_image", type="string", length=255, nullable=false)
     */
    private $urlImage;

    /**
     * @var \Logement
     *
     * @ORM\ManyToOne(targetEntity="Logement")
     * @ORM\JoinColumn(name="id_logement", referencedColumnName="id", onDelete="CASCADE")
     */
    private $idLogement;







    /**
     * Get idImage
     *
     * @return integer
     */
    public function getIdImage()
    {
        return $this->idImage;
    }

    /**
     * Set urlImage
     *
     * @param string $urlImage
     *
     * @return ImagesLogement
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;

        return $this;
    }

    /**
     * Get urlImage
     *
     * @return string
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * Set idLogement
     *
     * @param \AppBundle\Entity\Logement $idLogement
     *
     * @return ImagesLogement
     */
    public function setIdLogement(\AppBundle\Entity\Logement $idLogement = null)
    {
        $this->idLogement = $idLogement;

        return $this;
    }

    /**
     * Get idLogement
     *
     * @return \AppBundle\Entity\Logement
     */
    public function getIdLogement()
    {
        return $this->idLogement;
    }
}
