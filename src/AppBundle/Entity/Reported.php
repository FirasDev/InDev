<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reported
 *
 * @ORM\Table(name="reported", indexes={@ORM\Index(name="id_comm_1", columns={"comment_id"}), @ORM\Index(name="id_reporter_1", columns={"reporter_id"})})
 * @ORM\Entity
 */
class Reported
{
    /**
     * @var integer
     *
     * @ORM\Column(name="signal_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $signalId;

    /**
     * @var CommExp
     *
     * @ORM\ManyToOne(targetEntity="CommExp")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comment_id", referencedColumnName="id_comm_exp", nullable=true, onDelete="SET NULL")
     * })
     */
    private $comment;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="reporter_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * })
     */
    private $reporter;

    /**
     * @var Experience
     *
     * @ORM\ManyToOne(targetEntity="Experience")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="experience_id", referencedColumnName="id_experience", nullable=true, onDelete="SET NULL")
     * })
     */
    private $experienceId;

    /**
     * @var \DateTime|null
     * @ORM\Version
     * @ORM\Column(name="reportDate", type="datetime", nullable=true, unique=false)
     */
    private $reportDate;

    /**
     * @return int
     */
    public function getSignalId()
    {
        return $this->signalId;
    }

    /**
     * @param int $signalId
     */
    public function setSignalId($signalId)
    {
        $this->signalId = $signalId;
    }

    /**
     * @return CommExp
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param CommExp $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     */
    public function setReporter($reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * @return Experience
     */
    public function getExperienceId()
    {
        return $this->experienceId;
    }

    /**
     * @param Experience $experienceId
     */
    public function setExperienceId($experienceId)
    {
        $this->experienceId = $experienceId;
    }

    /**
     * @return \DateTime|null
     */
    public function getReportDate()
    {
        return $this->reportDate;
    }

    /**
     * @param \DateTime|null $reportDate
     */
    public function setReportDate($reportDate)
    {
        $this->reportDate = $reportDate;
    }




}

