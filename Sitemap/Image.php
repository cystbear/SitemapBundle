<?php

namespace Bundle\SitemapBundle\Sitemap;

use Bundle\SitemapBundle\Exception;

/**
 * Image
 *
 * @package OpenSky SitemapBundle
 * @version $Id$
 * @author Bulat Shakirzyanov <bulat@theopenskyproject.com>
 * @copyright (c) 2010 OpenSky Project Inc
 * @license http://www.gnu.org/licenses/agpl.txt GNU Affero General Public License
 */

/**
 * @EmbeddedDocument
 */
class Image
{
    const URL_PATTERN = '~^
      (http|https)://                         # protocol
      (
        ([a-z0-9-]+\.)+[a-z]{2,6}             # a domain name
          |                                   # or
        \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
      )
      (:[0-9]+)?                              # a port (optional)
      (/?|/\S+)                               # a /, nothing or a / with something
    $~ix';

    /**
     * @var string
     */
    protected $loc;
    /**
     *
     * @var string
     */
    protected $caption;
    /**
     *
     * @var string
     */
    protected $geolocation;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var string
     */
    protected $license;

    /**
     * @param string $loc
     * @throws \InvalidArgumentException
     */
    public function __construct($loc)
    {
        if (!preg_match(self::URL_PATTERN, $loc)) {
            throw new Exception\InvalidArgumentException($loc . ' is not valid url location');
        }
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