<?php

namespace ChanceZeus\BranchApi\Link;

use Carbon\Carbon;

/**
 * Class Link
 * @package ChanceZeus\BranchApi\Link
 *
 * @property string[] $tags
 * @property string $tag
 * @property string $channel
 * @property string $feature
 * @property string $stage
 * @property string $alias
 * @property int $duration
 * @property TypeEnum $type
 * @mixin LinkData
 */
class Link
{
    /** @var array */
    private $tags = [];

    /** @var string */
    private $channel;

    /** @var string */
    private $feature;

    /** @var string */
    private $stage;

    /** @var string */
    private $alias;

    /** @var int */
    private $duration;

    /** @var TypeEnum */
    private $type;

    /** @var LinkData */
    private $linkData;

    /**
     * Link constructor.
     */
    public function __construct()
    {
        $this->linkData = new LinkData;
    }

    /**
     * Parse the array representation back into a Link object
     * @param array $data
     * @return Link
     */
    public static function parse(array $data): Link
    {
        $link = new Link;

        array_walk_recursive($data, function ($value, $key) use ($link) {
            if ($key === '~id') {
                return;
            }

            if ($key == '$og_type') {
                $value = OgTypeEnum::instance($value);
            } else if ($key == '$twitter_card') {
                $value = TwitterCardEnum::instance($value);
            } else if ($key == 'type') {
                $value = TypeEnum::instance($value);
            } else if ($key == '$exp_date') {
                $value = Carbon::parse(preg_replace('#Z$', '+0000', $value));
            } else if ($key == '$custom_meta_tags') {
                $value = json_decode($value, true);
            }

            if (strpos($key, '$') === 0) {
                $key = substr($key, 1);
            }

            $link->{$key} = $value;
        });

        return $link;
    }

    /**
     * @param array $tags
     * @return Link
     */
    public function setTags(array $tags = []): Link
    {
        $this->tags = [];
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }

        return $this;
    }

    /**
     * @param string $tag
     * @return Link
     */
    public function addTag(string $tag): Link
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @param string|null $channel
     * @return Link
     */
    public function setChannel(string $channel = null): Link
    {
        $this->channel = $channel;
        return $this;
    }

    /**
     * @param string|null $feature
     * @return Link
     */
    public function setFeature(string $feature = null): Link
    {
        $this->feature = $feature;
        return $this;
    }

    /**
     * @param string|null $stage
     * @return Link
     */
    public function setStage(string $stage = null): Link
    {
        $this->stage = $stage;
        return $this;
    }

    /**
     * @param string|null $alias
     * @return Link
     */
    public function setAlias(string $alias = null): Link
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param int|null $duration
     * @return Link
     */
    public function setDuration(int $duration = null): Link
    {
        $this->duration = $duration;
        return $this;
    }

    /**
     * Builds the link
     *
     * @return array
     */
    public function build()
    {
        return [
            'tags' => $this->tags,
            'channel' => $this->channel,
            'feature' => $this->feature,
            'stage' => $this->stage,
            'alias' => $this->alias,
            'duration' => $this->duration,
            'type' => $this->type ? $this->type->getValue() : null,
            'data' => $this->linkData->build(),
        ];
    }

    /**
     * Call the property setters
     *
     * @param $name string
     * @param $value mixed
     * @return void
     */
    public function __set($name, $value)
    {
        $methodName = studly_case($name);

        if (method_exists($this, "set{$methodName}")) {
            $methodName = "set{$methodName}";
            $this->{$methodName}($value);
        } else if (method_exists($this, "add{$methodName}")) {
            $methodName = "add{$methodName}";
            $this->{$methodName}($value);
        } else {
            $this->linkData->{$name} = $value;
        }
    }

    /**
     * Return the property value
     *
     * @param $name string
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this, $name) && $name != 'linkData') {
            return $this->{$name};
        }

        return $this->linkData->{$name};
    }

    /**
     * Pass through any unhandled method calls to the link data object
     *
     * @param string $name
     * @param array $arguments
     * @return Link
     */
    public function __call($name, $arguments): Link
    {
        call_user_func_array([$this->linkData, $name], $arguments);
        return $this;
    }
}
