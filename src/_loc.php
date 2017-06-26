<?php

namespace PMVC\PlugIn\sitemap;

use PMVC\HashMap;

${_INIT_CONFIG}[_CLASS] = __NAMESPACE__.'\CreateLoc';

class CreateLoc
{
    function __invoke($url, $root)
    {
        return new Loc($url, $root);
    }
}

class Loc extends Base 
{
    public function __construct($url, $root)
    {
        parent::__construct($root);
        $this['@name'] = 'loc';
        $this['@children'] = $url;
    }
}
