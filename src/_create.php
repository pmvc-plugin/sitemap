<?php

namespace PMVC\PlugIn\sitemap;

use PMVC\HashMap;

const BASE_SITEMAP_XML = 'http://www.sitemaps.org/schemas/sitemap/0.9';
const IMAGE_SITEMAP_XML = 'http://www.google.com/schemas/sitemap-image/1.1';
const VIDEO_SITEMAP_XML = 'http://www.google.com/schemas/sitemap-video/1.1';

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\create';

class create
{
    public function __invoke()
    {
        return $this;
    }

    public function urlset()
    {
        return new UrlSet();
    }

    public function index()
    {
        return new Index();
    }
}

class UrlSet extends Base 
{
    private $_hasImage;
    private $_hasVideo;
    
    public function add($url)
    {
        $urlEl = $this->
            caller->
            url($url, $this);
        $this['@children'][] = $urlEl;
        return $urlEl;
    }

    public function __construct()
    {
        parent::__construct($this);
        $this['@name'] = 'urlset';
        $this['@props'] = [
            'xmlns'=> BASE_SITEMAP_XML
        ];
        $this['@children'] = new Base($this);
    }
}

class Index extends Base
{
    public function add($url)
    {
        $sitemap = $this->
            caller->
            sitemap($url, $this);
        $this['@children'][] = $sitemap;
        return $sitemap;
    }

    public function __construct()
    {
        parent::__construct($this);
        $this['@name'] = 'sitemapindex';
        $this['@props'] = [
            'xmlns'=> BASE_SITEMAP_XML
        ];
        $this['@children'] = new Base($this);
    }

}

class Base extends HashMap
{
    public $caller;
    public $root;

    public function __construct($root)
    {
        $this->caller = \PMVC\plug('sitemap');
        $this->root = $root;
    }

    public function toArray()
    {
        if (!count($this)) {
            return [];
        }
        foreach ($this as $k=>$v) {
            if (\PMVC\isArrayAccess($v)) {
                \PMVC\ref($this->{$k}, $v->toArray());
            }
            if (0!==$v && false!==$v && empty($v)) {
                unset($this[$k]);
            }
        }
        return \PMVC\get($this);
    }

    public function __tostring()
    {
        $arr = $this->toArray();
        $s = \PMVC\plug('xml')->
            array()->
            toXml($arr);
        return (string)$s;
    }

    public function setProps($k, $v=null)
    {
        \PMVC\set(
            $this['@props'],
            $k,
            $v
        );
    }
}
