<?php

namespace App\Actions\Ecorun\TextContent;

use App\Parsers\HashTagParser;
use App\Parsers\LinkParser;
use App\Parsers\MentionParser;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\HtmlRenderer;
use League\CommonMark\Inline\Parser\AutolinkParser;

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
        $environment->addExtension(new ExternalLinkExtension());
        $environment->mergeConfig([
            'external_link' => [
                'internal_hosts' => env('APP_URL'),
                'open_in_new_window' => true,
                'html_class' => '',
                'nofollow' => '',
                'noopener' => 'external',
                'noreferrer' => 'external',
            ],
        ]);
        $environment->addExtension(new AutolinkExtension());
        $environment->addInlineParser(new HashTagParser());
        $environment->addInlineParser(new MentionParser());
        $parser = new DocParser($environment);
        $htmlRender = new HtmlRenderer($environment);
        $text = $parser->parse($this->content);
        return $htmlRender->renderBlock($text);
    }
}
