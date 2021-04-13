<?php

namespace App\Actions\Ecorun\TextContent;

use App\Parsers\HashTagParser;
use App\Parsers\LinkParser;
use App\Parsers\MentionParser;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\HtmlRenderer;

class ParseText
{
    protected string $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function act()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addInlineParser(new HashTagParser());
        $environment->addInlineParser(new MentionParser());
        $parser = new DocParser($environment);
        $htmlRender = new HtmlRenderer($environment);
        $text = $parser->parse($this->content);
        return $htmlRender->renderBlock($text);
    }
}
