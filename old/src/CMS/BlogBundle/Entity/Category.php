<?php

namespace CMS\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="CMS\BlogBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="category_parent")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\ManyToMany(targetEntity="CMS\BlogBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="category_enfant")
     */
    private $enfants;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dossier", type="boolean", nullable=true)
     */
    private $dossier;

    /**
     * @var boolean
     *
     * @ORM\Column(name="page", type="boolean", nullable=true)
     */
    private $page;

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
     * @return Category
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
     * Set description
     *
     * @param string $description
     *
     * @return Category
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
     * Set parent
     *
     * @param string $parent
     *
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set enfants
     *
     * @param string $enfants
     *
     * @return Category
     */
    public function setEnfants($enfants)
    {
        $this->enfants = $enfants;

        return $this;
    }

    /**
     * Get enfants
     *
     * @return string
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    /**
     * Set dossier
     *
     * @param boolean $dossier
     *
     * @return Category
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return boolean
     */
    public function getDossier()
    {
        return $this->dossier;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->parent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->enfants = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add parent
     *
     * @param \CMS\BlogBundle\Entity\Category $parent
     *
     * @return Category
     */
    public function addParent(\CMS\BlogBundle\Entity\Category $parent)
    {
        $this->parent[] = $parent;

        return $this;
    }

    /**
     * Remove parent
     *
     * @param \CMS\BlogBundle\Entity\Category $parent
     */
    public function removeParent(\CMS\BlogBundle\Entity\Category $parent)
    {
        $this->parent->removeElement($parent);
    }

    /**
     * Add enfant
     *
     * @param \CMS\BlogBundle\Entity\Category $enfant
     *
     * @return Category
     */
    public function addEnfant(\CMS\BlogBundle\Entity\Category $enfant)
    {
        $this->enfants[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \CMS\BlogBundle\Entity\Category $enfant
     */
    public function removeEnfant(\CMS\BlogBundle\Entity\Category $enfant)
    {
        $this->enfants->removeElement($enfant);
    }

    /**
     * Set page
     *
     * @param boolean $page
     *
     * @return Category
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return boolean
     */
    public function getPage()
    {
        return $this->page;
    }
}
