<?php

namespace Adiq\LiberoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Action
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="out_date", type="datetime")
     */
    private $outDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_date", type="datetime")
     */
    private $dueDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="in_date", type="datetime", nullable=true)
     */
    private $inDate = null;

    /**
     * @ORM\ManyToOne(targetEntity="Book")
     * @ORM\JoinColumn(name="book_id", referencedColumnName="id")
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity="Reader")
     * @ORM\JoinColumn(name="reader_id", referencedColumnName="id")
     */
    private $reader;


    public function __construct()
    {
        $this->outDate = new \DateTime();
        $this->dueDate = new \DateTime();
        $this->dueDate->modify('+ 7 days');
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set outDate
     *
     * @param \DateTime $outDate
     * @return Action
     */
    public function setOutDate($outDate)
    {
        $this->outDate = $outDate;

        return $this;
    }

    /**
     * Get outDate
     *
     * @return \DateTime 
     */
    public function getOutDate()
    {
        return $this->outDate;
    }

    /**
     * Set dueDate
     *
     * @param \DateTime $dueDate
     * @return Action
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * Get dueDate
     *
     * @return \DateTime 
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * Set inDate
     *
     * @param \DateTime $inDate
     * @return Action
     */
    public function setInDate($inDate)
    {
        $this->inDate = $inDate;

        return $this;
    }

    /**
     * Get inDate
     *
     * @return \DateTime 
     */
    public function getInDate()
    {
        return $this->inDate;
    }

    /**
     * Set book
     *
     * @param \Adiq\LiberoBundle\Entity\Book $book
     * @return Action
     */
    public function setBook(\Adiq\LiberoBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \Adiq\LiberoBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set reader
     *
     * @param \Adiq\LiberoBundle\Entity\Reader $reader
     * @return Action
     */
    public function setReader(\Adiq\LiberoBundle\Entity\Reader $reader = null)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * Get reader
     *
     * @return \Adiq\LiberoBundle\Entity\Reader 
     */
    public function getReader()
    {
        return $this->reader;
    }
}
