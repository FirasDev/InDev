<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="id_question", columns={"id_question"})})
 * @ORM\Entity(repositoryClass="GroupBundle\Repository\commentRepository")
 */
class Reponse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_reponse_question", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReponseQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="texte_reponse", type="text", length=65535, nullable=false)
     */
    private $texteReponse;


    /**
     * @var int
     *
     * @ORM\ManyToOne (targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     */
    private $idUtilisateur;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_ajout_reponse", type="datetime", nullable=false)
     */
        private $dateAjoutReponse;

    /**
     * @var integer
     *
     * @ORM\Column(name="validation", type="integer", nullable=false)
     */
    private $validation;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Questions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_question", referencedColumnName="id_question")
     * })
     */
    private $idQuestion;

    /**
     * @return int
     */
    public function getIdReponseQuestion()
    {
        return $this->idReponseQuestion;
    }

    /**
     * @param int $idReponseQuestion
     */
    public function setIdReponseQuestion($idReponseQuestion)
    {
        $this->idReponseQuestion = $idReponseQuestion;
    }

    /**
     * @return string
     */
    public function getTexteReponse()
    {
        return $this->texteReponse;
    }

    /**
     * @param string $texteReponse
     */
    public function setTexteReponse($texteReponse)
    {
        $this->texteReponse = $texteReponse;
    }

    /**
     * @return \DateTime
     */
    public function getDateAjoutReponse()
    {
        return $this->dateAjoutReponse;
    }

    /**
     * @param \DateTime $dateAjoutReponse
     */
    public function setDateAjoutReponse($dateAjoutReponse)
    {
        $this->dateAjoutReponse = $dateAjoutReponse;
    }

    /**
     * @return int
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * @param int $validation
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    }

    /**
     * @return int
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * @param integer $idQuestion
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
     * Constructor
     */
    public function __construct()
    {
        $this->dateAjoutReponse =  new \DateTime();
    }


}
