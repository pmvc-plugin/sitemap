<?php

namespace PMVC\PlugIn\sitemap;

use PMVC\HashMap;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\CreateUrl';

class CreateUrl
{
    function __invoke($url, $root)
    {
        return new Url($url, $root);
    }
}

// https://www.sitemaps.org/protocol.html
class Url extends Base 
{
    public function __construct($url, $root)
    {
        parent::__construct($root);
        $this['@name'] = 'url';
        $this['@children'] = new Base($root);
        $this['@children'][] = $this->
            caller->
            loc($url, $root);
    }

    public function setChangefreq($freq)
    {
        $allFreq = [
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never'
        ];
        if (!in_array($freq, $allFreq)) {
            return !trigger_error(print_r($allFreq, true). 'does not contain frequency ['.$freq.']');
        }
        $this['@children']['changefreq'] = $freq; 
    }

    public function setPriority($num)
    {
        if ($num > 1 or $num < 0) {
            return !trigger_error('Valid values range from 0.0 to 1.0.'.$num);
        }
        $this['@children']['priority'] = $num; 
    }

    public function addImage($url)
    {
        $image = \PMVC\plug('sitemap')->
            image($url, $this->root);
        $this['@children'][] = $image;
        return $image;
    }
}
