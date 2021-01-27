<?php

namespace App\Actions\Ecorun\Post;

use App\Models\Post;
use App\Parsers\HashTagParser;
use App\Parsers\MentionParser;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;

class ExtractMentionsAndTags
{
    protected Post $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    public function act() {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addInlineParser(new HashTagParser());
        $environment->addInlineParser(new MentionParser());
        $parser = new DocParser($environment);
        $htmlRender = new HtmlRenderer($environment);
        $text = $parser->parse($this->post->content);
        return $htmlRender->renderBlock($text);
    }
}