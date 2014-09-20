<?php

namespace Adiq\LiberoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Book
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Book
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
     * @ORM\Column(name="year", type="date")
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Publisher")
     * @ORM\JoinColumn(name="publisher_id", referencedColumnName="id")
     **/
    protected $publisher;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $authors
     * @ORM\ManyToMany(targetEntity="Author", inversedBy="books")
     * @ORM\JoinTable(name="author_book")
     */
    protected $authors;

    /**
     * @ORM\Column(name="isRented", type="boolean")
     */
    private $isRented = false;


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
     * Set year
     *
     * @param \DateTime $year
     * @return Book
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \DateTime 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get publisher
     *
     * @return Publisher
     */
    public function getPublisher()
    {
        return $this->publisher;
    }


    /**
     * Set publisher
     *
     * @param \Adiq\LiberoBundle\Entity\Publisher $publisher
     * @return Book
     */
    public function setPublisher(\Adiq\LiberoBundle\Entity\Publisher $publisher = null)
    {
        $this->publisher = $publisher;

        return $this;
    }


    /**
     * Object __toString
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * Set isRented
     *
     * @param boolean $isRented
     * @return Book
     */
    public function setIsRented($isRented)
    {
        $this->isRented = $isRented;

        return $this;
    }

    /**
     * Get isRented
     *
     * @return boolean 
     */
    public function getIsRented()
    {
        return $this->isRented;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add authors
     *
     * @param \Adiq\LiberoBundle\Entity\Author $authors
     * @return Book
     */
    public function addAuthor(\Adiq\LiberoBundle\Entity\Author $author)
    {
        die("ada");
        $author->addBook($this);
        $this->authors[] = $authors;

        return $this;
    }

    /**
     * Remove authors
     *
     * @param \Adiq\LiberoBundle\Entity\Author $authors
     */
    public function removeAuthor(\Adiq\LiberoBundle\Entity\Author $authors)
    {
        $this->authors->removeElement($authors);
    }

    /**
     * Get authors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAuthors()
    {
        return $this->authors;
    }
}
