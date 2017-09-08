<?php

namespace CMS\BlogBundle\Entity;

use CMS\BlogBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reply
 *
 * @ORM\Table(name="reply")
 * @ORM\Entity(repositoryClass="CMS\BlogBundle\Repository\ReplyRepository")
 */
class Reply
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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", length=255)
     */
    private $ip;

    /**
     * @var string
     *
     * @ORM\Column(name="reply", type="text")
     */
    private $reply;

    /**
     * @var string
     *
     * @ORM\Column(name="date", type="string", length=255)
     */
    private $date;

    /**
     * @var bool
     *
     * @ORM\Column(name="mode", type="boolean")
     */
    private $mode;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="User")
     */
    private $author;

     /**
     * @ORM\ManyToOne(targetEntity="CMS\BlogBundle\Entity\Article", inversedBy="replies")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     * 
    */
    private $article;


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
     * Set email
     *
     * @param string $email
     *
     * @return Reply
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Reply
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set reply
     *
     * @param string $reply
     *
     * @return Reply
     */
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get reply
     *
     * @return string
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Reply
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set mode
     *
     * @param boolean $mode
     *
     * @return Reply
     */
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * Get mode
     *
     * @return bool
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return Reply
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set article
     *
     * @param \CMS\BlogBundle\Entity\Article $article
     *
     * @return Reply
     */
    public function setArticle(\CMS\BlogBundle\Entity\Article $article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return \CMS\BlogBundle\Entity\Article
     */
    public function getArticle()
    {
        return $this->article;
    }
}
