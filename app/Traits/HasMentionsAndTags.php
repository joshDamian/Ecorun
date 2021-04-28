<?php

namespace App\Traits;

use Spatie\Tags\HasTags;
use App\Models\Core\DataSorting\Tag;
use App\Queues\MentionQueue;
use App\Queues\TagQueue;
use App\Actions\TextContent\ParseText;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use League\CommonMark\Environment;
use Illuminate\Support\Facades\App;
use League\CommonMark\CommonMarkConverter;

trait HasMentionsAndTags
{
    use HasTags;
    public static function parseMentionsAndTags($model)
    {
        App::singleton('tagqueue', function () {
            return new TagQueue;
        });
        App::singleton('mentionqueue', function () {
            return new MentionQueue;
        });
        $model->content = htmlentities($model->content);
        $model->html = (new ParseText($model->content))->act();
        $model->mentions = app('mentionqueue')->getMentions();
    }

    protected static function syncWithTags($model)
    {
        $model->syncTags(app('tagqueue')->getTags());
    }

    public function getSafeHtmlAttribute()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $config = [
            'allow_unsafe_links' => false,
        ];
        $converter = new CommonMarkConverter($config, $environment);
        return $converter->convertToHtml($this->html);
    }

    public static function getTagClassName(): string
    {
        return Tag::class;
    }

    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('order_column');
    }
}
