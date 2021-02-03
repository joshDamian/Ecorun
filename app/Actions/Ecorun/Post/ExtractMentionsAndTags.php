<?php

namespace App\Actions\Ecorun\Post;

use App\Parsers\HashTagParser;
use App\Parsers\MentionParser;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;

class ExtractMentionsAndTags
{
    protected string $content;

    public function __construct(string $content) {
        $this->content = $content;
    }

    public function act() {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addInlineParser(new HashTagParser());
        $environment->addInlineParser(new MentionParser());
        $parser = new DocParser($environment);
        $htmlRender = new HtmlRenderer($environment);
        $text = $parser->parse($this->content);
        return $htmlRender->renderBlock($text);
    }
}