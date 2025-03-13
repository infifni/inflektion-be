<?php

namespace Tests\Unit;

use App\Utils\HtmlParser;
use PHPUnit\Framework\TestCase;

class HtmlParserTest extends TestCase
{
    public function test_basic_html_parsing()
    {
        $html = '<html><body><h1>My First Heading</h1><p>My first paragraph.</p></body></html>';
        $parser = new HtmlParser;
        $result = $parser->getRawText($html);
        $expected = 'My First Heading My first paragraph.';
        $this->assertEquals($expected, $result);
    }

    public function test_html_with_styles_and_scripts()
    {
        $html = '<html><head><style>body {font-size: 12px;}</style><script>alert("Hello");</script></head><body><h1>Heading</h1><p>Paragraph.</p></body></html>';
        $parser = new HtmlParser;
        $result = $parser->getRawText($html);
        $expected = 'Heading Paragraph.';
        $this->assertEquals($expected, $result);
    }

    public function test_html_with_entities()
    {
        $html = '<html><body><p>Some&nbsp;text&nbsp;with&nbsp;entities.</p></body></html>';
        $parser = new HtmlParser;
        $result = $parser->getRawText($html);
        $expected = 'Some text with entities.';
        $this->assertEquals($expected, $result);
    }

    public function test_html_with_comments()
    {
        $html = '<html><body><!-- This is a comment --><p>Visible text.</p></body></html>';
        $parser = new HtmlParser;
        $result = $parser->getRawText($html);
        $expected = 'Visible text.';
        $this->assertEquals($expected, $result);
    }

    public function test_html_with_block_elements()
    {
        $html = '<html><body><div>Block element 1</div><div>Block element 2</div></body></html>';
        $parser = new HtmlParser;
        $result = $parser->getRawText($html);
        $expected = 'Block element 1 Block element 2';
        $this->assertEquals($expected, $result);
    }
}
