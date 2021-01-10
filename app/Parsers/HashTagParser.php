<?php

namespace App\Parsers;

use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

class HashTagParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ['#'];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $previousChar = $cursor->peek(-1);
        if ($previousChar !== null && $previousChar !== ' ' && $previousChar !== PHP_EOL) {
            return false;
        }
        $previousSave = $cursor->saveState();
        $cursor->advance();
        $tag = $cursor->match('/^[A-Za-z0-9_-]{1,100}(?!\w)/');
        if (empty($tag)) {
            $cursor->restoreState($previousSave);
            return false;
        }
        app('tagqueue')->addTag($tag);
        $tagUrl = route('search', ['data' => $tag, 'data-set' => 'tags']);
        $inlineContext->getContainer()->appendChild(new Link($tagUrl, '#' . $tag));
        return true;
    }
}