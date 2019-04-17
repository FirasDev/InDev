<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Questions
 *
 * @ORM\Table(name="questions")
 * @ORM\Entity(repositoryClass="GroupBundle\Repository\forumRepository")
 */
class Questions
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idQuestion;

    /**
     *
     * @ORM\ManyToOne (targetEntity="categorie")
     * @ORM\JoinColumn (name="categorie",referencedColumnName="id", onDelete="CASCADE")
     *
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var int
     *
     * @ORM\ManyToOne (targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     */
    private $idUtilisateur;



    /**
     * @var string
     *
     * @ORM\Column(name="texte_question", type="text", length=65535, nullable=false)
     */
    private $texteQuestion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout_question", type="datetime", nullable=false)
     */
    private $dateAjoutQuestion;

    /**
     * @return int
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * @param int $idQuestion
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;
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
     * @return string
     */
    public function getTexteQuestion()
    {
        return $this->texteQuestion;
    }

    /**
     * @param string $texteQuestion
     */
    public function setTexteQuestion($texteQuestion)
    {
        $this->texteQuestion = $texteQuestion;
    }

    /**
     * @return \DateTime
     */
    public function getDateAjoutQuestion()
    {
        return $this->dateAjoutQuestion;
    }

    /**
     * @param \DateTime $dateAjoutQuestion
     */
    public function setDateAjoutQuestion($dateAjoutQuestion)
    {
        $this->dateAjoutQuestion = $dateAjoutQuestion;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateAjoutQuestion =  new \DateTime();
    }


    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

}
