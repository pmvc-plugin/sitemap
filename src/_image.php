<?php

namespace PMVC\PlugIn\sitemap;

use PMVC\HashMap;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\CreateImage';

class CreateImage
{
    function __invoke($url, $root)
    {
        return new Image($url, $root);
    }
}

// https://support.google.com/webmasters/answer/178636 
class Image extends Base 
{
    public function __construct($url, $root)
    {
        parent::__construct($root);
        $this['@name'] = 'image:image';
        $this['@children'] = new Base($root);
        $this['@children']['image:loc'] = $url;
        $root->setProps(
            ['xmlns:image'=> IMAGE_SITEMAP_XML]
        );
    }

    /**
     * Long 
     */
    public function setCaption($text)
    {
        $this['@children']['image:caption'] = $text;
    }

    /**
     * Short 
     */
    public function setTitle($text)
    {
        $this['@children']['image:caption'] = $text;
    }
    
    /**
     * Sample
     * <image:geo_location>Limerick, Ireland</image:geo_location>
     */
    public function setGeoLocation($address)
    {
        $this['@children']['image:geo_location'] = $address;
    }

    /**
     * A URL to the license of the image.
     */
     public function setLicense($url)
     {
        $this['@children']['image:license'] = $url;
     }
}
