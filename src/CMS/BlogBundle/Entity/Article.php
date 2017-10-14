<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="metadescription", type="string", length=255, nullable=true)
     */
    private $metadescription;

     /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;
    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
    private $datepublication;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecreation", type="datetime")
     */
    private $datecreation;

    /**
     * @var string
     *
     *
     * @ORM\ManyToOne(targetEntity="CMS\BlogBundle\Entity\Image")
     * @ORM\JoinColumn(nullable=true)
     */
    private $thumb;

     /**
     * @ORM\ManyToOne(targetEntity="CMS\BlogBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
    */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="CMS\BlogBundle\Entity\Reply", mappedBy="article")
     *
    */
    private $replies;

    /**
     * @ORM\ManyToOne(targetEntity="CMS\BlogBundle\Entity\User")
     *
    */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Article
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
     * Set metadescription
     *
     * @param string $metadescription
     *
     * @return Article
     */
    public function setMetadescription($metadescription)
    {
        $this->metadescription = $metadescription;

        return $this;
    }

    /**
     * Get metadescription
     *
     * @return string
     */
    public function getMetadescription()
    {
        return $this->metadescription;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set datepublication
     *
     * @param \DateTime $datepublication
     *
     * @return Article
     */
    public function setDatepublication($datepublication)
    {
        $this->datepublication = $datepublication;

        return $this;
    }

    /**
     * Get datepublication
     *
     * @return \DateTime
     */
    public function getDatepublication()
    {
        return $this->datepublication;
    }

    /**
     * Set datecreation
     *
     * @param \DateTime $datecreation
     *
     * @return Article
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return \DateTime
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set thumb
     *
     * @param string $thumb
     *
     * @return Article
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * Get thumb
     *
     * @return string
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set category
     *
     * @param \CMS\BlogBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\CMS\BlogBundle\Entity\Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CMS\BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug()
    {
        $this->slug = str_replace(' ', '_' , $this->title);

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->replies = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add reply
     *
     * @param \CMS\BlogBundle\Entity\Reply $reply
     *
     * @return Article
     */
    public function addReply(\CMS\BlogBundle\Entity\Reply $reply)
    {
        $this->replies[] = $reply;

        return $this;
    }

    /**
     * Remove reply
     *
     * @param \CMS\BlogBundle\Entity\Reply $reply
     */
    public function removeReply(\CMS\BlogBundle\Entity\Reply $reply)
    {
        $this->replies->removeElement($reply);
    }

    /**
     * Get replies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReplies()
    {
        return $this->replies;
    }

    /**
     * Set user
     *
     * @param \CMS\BlogBundle\Entity\User $user
     *
     * @return Article
     */
    public function setUser(\CMS\BlogBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \CMS\BlogBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
