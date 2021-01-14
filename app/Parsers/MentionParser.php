<?php

namespace App\Parsers;

use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;
use App\Models\Profile;

class MentionParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ['@'];
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
        $mention = $cursor->match('/^[A-Za-z0-9_-]{1,30}(?!\w)/');
        if (empty($mention)) {
            $cursor->restoreState($previousSave);
            return false;
        }
        $profile = Profile::firstWhere('tag', $mention);
        if (!$profile) {
            $cursor->restoreState($previousSave);
            return false;
        }
        app('mentionqueue')->addMention($profile->id);
        $inlineContext->getContainer()->appendChild(new Link("/@{$mention}", '@' . $mention));
        return true;
    }
}
