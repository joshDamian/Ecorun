<?php

namespace App\Parsers;

use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\InlineParserContext;

class LinkParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ['https://', 'www'];
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
        $link = $cursor->match('/^[A-Za-z0-9_-]{1,2083}(?!\w)/');
        if (empty($link)) {
            $cursor->restoreState($previousSave);
            return false;
        }
        $inlineContext->getContainer()->appendChild(new Link($link, $link));
        return true;
    }
}
