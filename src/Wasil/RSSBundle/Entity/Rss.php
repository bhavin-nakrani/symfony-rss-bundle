<?php

namespace Wasil\RSSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rss
 */
class Rss
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $link;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $author;

    /**
     * @var \DateTime
     */
    private $pubDate;

    /**
     * @var integer
     */
    private $feed_id;

    /**
     * @var integer
     */
    private $read;

    /**
     * @var Feed
     */
    private $feed;


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
     * Set title
     *
     * @param string $title
     * @return Rss
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
     * Set link
     *
     * @param string $link
     * @return Rss
     */
    public function setLink($link)
    {
        $this->link = $link;
    
        return $this;
    }

    /**
     * Get link
     *
     * @return string 
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Rss
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
     * Set author
     *
     * @param string $author
     * @return Rss
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
     * Set pubDate
     *
     * @param \DateTime $pubDate
     * @return Rss
     */
    public function setPubDate($pubDate)
    {
        $this->pubDate = $pubDate;
    
        return $this;
    }

    /**
     * Get pubDate
     *
     * @return \DateTime 
     */
    public function getPubDate()
    {
        return $this->pubDate;
    }

    /**
     * Set feed_id
     *
     * @param integer $feedId
     * @return Rss
     */
    public function setFeedId($feedId)
    {
        $this->feed_id = $feedId;
    
        return $this;
    }

    /**
     * Get feed_id
     *
     * @return integer 
     */
    public function getFeedId()
    {
        return $this->feed_id;
    }

    /**
     * Set read
     *
     * @param integer $read
     * @return Rss
     */
    public function setRead($read)
    {
        $this->read = $read;
    
        return $this;
    }

    /**
     * Get read
     *
     * @return integer 
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * Set feed
     *
     * @param Feed|null $feed
     * @return Rss
     */
    public function setFeed(Feed $feed = null)
    {
        $this->feed = $feed;
    
        return $this;
    }

    /**
     * Get feed
     *
     * @return Feed
     */
    public function getFeed()
    {
        return $this->feed;
    }
}
