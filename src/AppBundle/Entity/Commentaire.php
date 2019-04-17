<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire", indexes={@ORM\Index(name="fk_id_user", columns={"id_utilisateur"})})
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_commentaire", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommentaire;

    /**
     *@ORM\ManyToOne (targetEntity="AppBundle\Entity\Blog", inversedBy="commentaire")
     *@ORM\JoinColumn(name="id_blog", referencedColumnName="id_blog")
     */
    private $idBlog;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commentaire", type="datetime", nullable=false)
     */
    private $dateCommentaire ;

    /**
     * @var string
     *
     * @ORM\Column(name="texte_commentaire", type="text", length=65535, nullable=false)
     */
    private $texteCommentaire;

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
    public function getIdCommentaire()
    {
        return $this->idCommentaire;
    }

    /**
     * @param int $idCommentaire
     */
    public function setIdCommentaire($idCommentaire)
    {
        $this->idCommentaire = $idCommentaire;
    }

    /**
     * @return \DateTime
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }

    /**
     * @param \DateTime $dateCommentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;
    }

    /**
     * @return string
     */
    public function getTexteCommentaire()
    {
        return $this->texteCommentaire;
    }

    /**
     * @param string $texteCommentaire
     */
    public function setTexteCommentaire($texteCommentaire)
    {
        $this->texteCommentaire = $texteCommentaire;
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


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCommentaire = new \DateTime();
    }







    /**
     * Set idBlog
     *
     * @param \AppBundle\Entity\Blog $idBlog
     *
     * @return Commentaire
     */
    public function setIdBlog(\AppBundle\Entity\Blog $idBlog = null)
    {
        $this->idBlog = $idBlog;

        return $this;
    }

    /**
     * Get idBlog
     *
     * @return \AppBundle\Entity\Blog
     */
    public function getIdBlog()
    {
        return $this->idBlog;
    }
}
