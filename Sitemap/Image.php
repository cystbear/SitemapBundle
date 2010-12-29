<?php

namespace Bundle\SitemapBundle\Sitemap;

/**
 * Image
 *
 * @package OpenSky SitemapBundle
 * @version $Id$
 * @author Bulat Shakirzyanov <bulat@theopenskyproject.com>
 * @author Oleg Zinchenko <olegz@default-value.com>
 * @copyright (c) 2010 OpenSky Project Inc
 * @license http://www.gnu.org/licenses/agpl.txt GNU Affero General Public License
 */

/**
 * @EmbeddedDocument
 */
class Image
{
    /**
     * @var string
     */
    public $loc;
    /**
     * @var string
     */
    public $caption;
    /**
     * @var string
     */
    public $geolocation;
    /**
     * @var string
     */
    public $title;
    /**
     * @var string
     */
    public $license;

    /**
     * @param string $loc
     */
    public function __construct($loc)
    {
        $this->loc = $loc;
    }

    /**
     * @return string
     */
    public function getLoc()
    {
        return $this->loc;
    }

    /**
     * @param string $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }
    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }
    /**
     * @param string $geolocation
     */
    public function setGeolocation($geolocation)
    {
        $this->geolocation = $geolocation;
    }
    /**
     * @return string
     */
    public function getGeolocation()
    {
        return $this->geolocation;
    }
    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * @param string $license
     */
    public function setLicense($license)
    {
        $this->license = $license;
    }
    /**
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }
}