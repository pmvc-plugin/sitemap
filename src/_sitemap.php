<?php

namespace PMVC\PlugIn\sitemap;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\CreateSitemap';

class CreateSitemap
{
    function __invoke($url, $root)
    {
        return new SitemapEl($url, $root);
    }
}

class SitemapEl extends Base 
{
    public function __construct($url, $root)
    {
        parent::__construct($root);
        $this['@name'] = 'sitemap';
        $this['@children'] = new Base($root);
        $this['@children'][] = $this->
            caller->
            loc($url, $root);
    }
}
