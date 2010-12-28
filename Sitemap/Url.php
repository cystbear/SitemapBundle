<?php

namespace Bundle\SitemapBundle\Sitemap;

use Bundle\SitemapBundle\Exception;
use Bundle\SitemapBundle\Sitemap\Image;

/**
 * Url
 *
 * @package OpenSky SitemapBundle
 * @version $Id$
 * @author Bulat Shakirzyanov <bulat@theopenskyproject.com>
 * @copyright (c) 2010 OpenSky Project Inc
 * @license http://www.gnu.org/licenses/agpl.txt GNU Affero General Public License
 */
class Url
{
    const DEFAULT_IMAGE_CLASS = 'Bundle\SitemapBundle\Sitemap\Image';

    const PATTERN = '~^
      (http|https)://                         # protocol
      (
        ([a-z0-9-]+\.)+[a-z]{2,6}             # a domain name
          |                                   #  or
        \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
      )
      (:[0-9]+)?                              # a port (optional)
      (/?|/\S+)                               # a /, nothing or a / with something
    $~ix';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY = 'yearly';
    const LASTMOD_FORMAT = 'Y-m-d';

    /**
     * @var string
     */
    protected $imageClass;
    /**
     * @var array
     */
    protected $images = array();

    /**
     * @var string
     */
    protected $loc;
    /**
     *
     * @var string
     */
    protected $lastmod;
    /**
     *
     * @var string
     */
    protected $changefreq;
    /**
     * @var float
     */
    protected $priority;

    /**
     * @param string $loc
     * @throws \InvalidArgumentException
     */
    public function __construct($loc)
    {
        if (!preg_match(self::PATTERN, $loc)) {
            throw new Exception\InvalidArgumentException($loc . ' is not valid url location');
        }
        $this->loc = $loc;
        $this->imageClass = self::DEFAULT_IMAGE_CLASS;
        $this->images = array();
    }

    /**
     * @param array $images
     */
    public function addImages(array $images)
    {
        $this->imagesClear();
        foreach($images as $image) {
            $this->addImage($image['loc'], $image['info']);
        }

        return count($this->getImages());
    }

    public function imagesClear()
    {
        $this->images = array();
    }

    /**
     * @param string $loc
     * @param array $info
     */
    public function addImage($loc, array $info)
    {
        $image = $this->initializeImage($loc, $info);
        $this->storeImage($image);
    }

    /**
     * @param Image $image
     */
    public function storeImage(Image $image)
    {
        $this->images[] = $image;
    }

    // TODO: move me at right position in class
    // method scope order convention is next: public => protected => private
    // regarding http://docs.symfony-reloaded.org/contributing/code/standards.html#structure last point

    /**
     * @param string $loc
     * @param array $info
     */
    protected function initializeImage($loc, array $info)
    {
        $imageClass = $this->getImageClass();
        $image = new $imageClass($loc);
        foreach (array('caption', 'geolocation', 'title', 'license') as $property) {
            if (isset($info[$property])) {
                $image->{'set' . \ucfirst($property)}($info[$property]);
            }
        }

        return $image;
    }

    /**
     * @return string
     */
    public function getImageClass()
    {
        return $this->imageClass;
    }
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @return string
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * @param string|\DateTime $lastmod
     */
    public function setLastmod($lastmod)
    {
        if ($lastmod instanceof \DateTime) {
            $lastmod = $lastmod->getTimestamp();
        }
        $this->lastmod = date(self::LASTMOD_FORMAT, $lastmod);
    }

    /**
     * @return string
     */
    public function getLastmod()
    {
        if ($this->lastmod instanceof \DateTime) {
            $this->lastmod = $this->lastmod->format(self::LASTMOD_FORMAT);
        }
        return $this->lastmod;
    }

    /**
     * @param string $changefreq
     */
    public function setChangefreq($changefreq)
    {
        if (!in_array($changefreq, array(self::DAILY, self::MONTHLY, self::WEEKLY, self::YEARLY))) {
            throw new Exception\InvalidArgumentException('Change frequency ' . $changefreq . ' is invalid');
        }
        $this->changefreq = $changefreq;
    }

    /**
     * @return string
     */
    public function getChangefreq()
    {
        return $this->changefreq;
    }

    /**
     * @param float $priority
     */
    public function setPriority($priority)
    {
        if ($priority <= 0 || $priority > 1) {
            throw new Exception\InvalidArgumentException('Priority must be in between 0 and 1, ' . $priority . ' given');
        }
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return number_format($this->priority, 1);
    }
}