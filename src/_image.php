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

    public function setCaption($text)
    {
        $this['@children']['image:caption'] = $text;
    }
}
