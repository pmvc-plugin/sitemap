<?php
namespace PMVC\PlugIn\sitemap;

use PHPUnit_Framework_TestCase;

class SitemapTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'sitemap';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testCreateIndex()
    {
        $p = \PMVC\plug($this->_plug);
        $index = $p->create()->index();
        $index->add('https://xxx/sitemap.xml');
        $expected = '<?xml version="1.0" encoding="utf-8"?>'."\n".'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><sitemap><loc>https://xxx/sitemap.xml</loc></sitemap></sitemapindex>'."\n";
        $this->assertEquals($expected, $index->__tostring());
    }

    function testCreateUrlSet()
    {
        $p = \PMVC\plug($this->_plug);
        $urlset = $p->create()->urlset();
        $url = $urlset->add('http://xxx');
        $url->setChangefreq('always');
        $url->setPriority(1);
        $expected = '<?xml version="1.0" encoding="utf-8"?>'."\n".
        '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"><url><loc>http://xxx</loc><changefreq>always</changefreq><priority>1</priority></url></urlset>'."\n";
        $this->assertEquals($expected, $urlset->__tostring());
    }

    function testCreateUrlSetWithImage()
    {
        $p = \PMVC\plug($this->_plug);
        $urlset = $p->create()->urlset();
        $url = $urlset->add('http://xxx');
        $img = $url->addImage('http://xxx/x.jpg');
        $expected = '<?xml version="1.0" encoding="utf-8"?>'."\n".
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"><url><loc>http://xxx</loc><image:image><image:loc>http://xxx/x.jpg</image:loc></image:image></url></urlset>'.
            "\n";
        $this->assertEquals($expected, $urlset->__tostring());
    }
}
