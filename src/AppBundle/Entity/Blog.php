<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Blog
 *
 * @ORM\Entity(repositoryClass="AppBundle\Entity\BlogRepository")
 * @ORM\Table(name="blog", indexes={@ORM\Index(name="fk_id_user", columns={"id_utilisateur"})})
 * @Vich\Uploadable
 */
class Blog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_blog", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBlog;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_blog", type="string", length=100, nullable=false)
     */
    private $titreBlog;

    /**
     * @var string
     *
     * @ORM\Column(name="article_blog", type="string", length=1000, nullable=false)
     */
    private $articleBlog;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_blog", type="string", length=255, nullable=false)
     */
    private $etatBlog;

    /**
     * @var string
     *
     * @ORM\Column(name="image_blog", type="string", length=100, nullable=false)
     */
    private $imageBlog;


    /**
     * @Assert\Image(
     *     maxSize="5M",
     *     mimeTypesMessage = "Veuillez uploader un fichier de type Image"
     * )
     * @Vich\UploadableField(mapping="blog_image", fileNameProperty="imageBlog")
     */
    private $afficheFile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout_blog", type="datetime", nullable=true)
     */
    private $dateAjoutBlog;

    /**
     * @var integer
     *
     * @ORM\Column(name="nombre_vu_blog", type="integer", nullable=true)
     */
    private $nombreVuBlog;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    /**
     * @return int
     */
    public function getIdBlog()
    {
        return $this->idBlog;
    }

    /**
     * @param int $idBlog
     */
    public function setIdBlog($idBlog)
    {
        $this->idBlog = $idBlog;
    }

    /**
     * @return string
     */
    public function getTitreBlog()
    {
        return $this->titreBlog;
    }

    /**
     * @param string $titreBlog
     */
    public function setTitreBlog($titreBlog)
    {
        $this->titreBlog = $titreBlog;
    }

    /**
     * @return string
     */
    public function getArticleBlog()
    {
        return $this->articleBlog;
    }

    /**
     * @param string $articleBlog
     */
    public function setArticleBlog($articleBlog)
    {
        $this->articleBlog = $articleBlog;
    }

    /**
     * @return string
     */
    public function getImageBlog()
    {
        return $this->imageBlog;
    }

    /**
     * @param string $imageBlog
     */
    public function setImageBlog($imageBlog)
    {
        $this->imageBlog = $imageBlog;
    }

    /**
     * @return \DateTime
     */
    public function getDateAjoutBlog()
    {
        return $this->dateAjoutBlog;
    }

    /**
     * @param \DateTime $dateAjoutBlog
     */
    public function setDateAjoutBlog($dateAjoutBlog)
    {
        $this->dateAjoutBlog = $dateAjoutBlog;
    }

    /**
     * @return int
     */
    public function getNombreVuBlog()
    {
        return $this->nombreVuBlog;
    }

    /**
     * @param int $nombreVuBlog
     */
    public function setNombreVuBlog($nombreVuBlog)
    {
        $this->nombreVuBlog = $nombreVuBlog;
    }

    /**
     * Get idUtilisateur
     *
     * @return int
     */
    public function getIdUtilisateur()
    {
        return $this->idUtilisateur;
    }

    /**
     * @param integer $idUtilisateur
     */
    public function setIdUtilisateur($idUtilisateur)
    {
        $this->idUtilisateur = $idUtilisateur;
    }


    public function getAfficheFile()
    {
        return $this->afficheFile;
    }

    public function setAfficheFile(File $affiche = null)
    {
        $this->afficheFile = $affiche;

        if ($affiche) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            try {
                $this->updatedAt = new \DateTimeImmutable();
            } catch (\Exception $e) {
            }
        }

    }





    /**
     * @ORM\OneToMany (targetEntity="Commentaire", mappedBy="idBlog")
     */
    private $commentaires;


    /**
     * Add commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     *
     * @return Blog
     */
    public function addCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;

        return $this;
    }


    /**
     * Remove commentaire
     *
     * @param \AppBundle\Entity\Commentaire $commentaire
     */
    public function removeCommentaire(\AppBundle\Entity\Commentaire $commentaire)
    {
        $this->commentaires->removeElement($commentaire);
    }

    /**
     * Get commentaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateAjoutBlog =  new \DateTime();
    }


    /**
     * Set etatBlog
     *
     * @param string $etatBlog
     *
     * @return Blog
     */
    public function setEtatBlog($etatBlog)
    {
        $this->etatBlog = $etatBlog;

        return $this;
    }

    /**
     * Get etatBlog
     *
     * @return string
     */
    public function getEtatBlog()
    {
        return $this->etatBlog;
    }
}
