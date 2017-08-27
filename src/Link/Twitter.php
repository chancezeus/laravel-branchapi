<?php

namespace ChanceZeus\BranchApi\Link;

/**
 * Class Twitter
 * @package ChanceZeus\BranchApi\Link
 *
 * @method Twitter setTwitterCard(TwitterCardEnum $twitterCard = null)
 * @method Twitter setTwitterTitle(string $title = null)
 * @method Twitter setTwitterDescription(string $description = null)
 * @method Twitter setTwitterImageUrl(string $imageUrl = null)
 * @method Twitter setTwitterSite(string $site = null)
 * @method Twitter setTwitterAppCountry(string $appCountry = null)
 * @method Twitter setTwitterPlayer(string $player = null)
 * @method Twitter setTwitterPlayerWidth(int $playerWidth = null)
 * @method Twitter setTwitterPlayerHeight(int $playerHeight = null)
 * @property TwitterCardEnum $twitterCard
 * @property string $twitterTitle
 * @property string $twitterDescription
 * @property string $twitterImageUrl
 * @property string $twitterSite
 * @property string $twitterAppCountry
 * @property string $twitterPlayer
 * @property int $twitterPlayerWidth
 * @property int $twitterPlayerHeight
 */
class Twitter
{
    /** @var TwitterCardEnum */
    private $card;

    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $imageUrl;

    /** @var string */
    private $site;

    /** @var string */
    private $appCountry;

    /** @var string */
    private $player;

    /** @var int */
    private $playerWidth;

    /** @var int */
    private $playerHeight;

    /**
     * @param TwitterCardEnum|null $card
     * @return Twitter
     */
    public function setCard(TwitterCardEnum $card = null): Twitter
    {
        $this->card = $card;
        return $this;
    }

    /**
     * @param string|null $title
     * @return Twitter
     */
    public function setTitle(string $title = null): Twitter
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string|null $description
     * @return Twitter
     */
    public function setDescription(string $description = null): Twitter
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param string|null $imageUrl
     * @return Twitter
     */
    public function setImageUrl(string $imageUrl = null): Twitter
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }

    /**
     * @param string|null $site
     * @return Twitter
     */
    public function setSite(string $site = null): Twitter
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @param string|null $appCountry
     * @return Twitter
     */
    public function setAppCountry(string $appCountry = null): Twitter
    {
        $this->appCountry = $appCountry;
        return $this;
    }

    /**
     * @param string|null $player
     * @param int|null $width
     * @param int|null $height
     * @return Twitter
     */
    public function setPlayer(string $player = null, int $width = null, int $height = null): Twitter
    {
        $this->player = $player;
        $this->playerWidth = $width;
        $this->playerHeight = $height;
        return $this;
    }

    /**
     * @param int|null $playerWidth
     * @return Twitter
     */
    public function setPlayerWidth(int $playerWidth = null): Twitter
    {
        $this->playerWidth = $playerWidth;
        return $this;
    }

    /**
     * @param int|null $playerHeight
     * @return Twitter
     */
    public function setPlayerHeight(int $playerHeight = null): Twitter
    {
        $this->playerHeight = $playerHeight;
        return $this;
    }

    /**
     * Build the Twitter link data
     *
     * @return array
     */
    public function build()
    {
        return [
            '$twitter_card' => $this->card,
            '$twitter_title' => $this->title,
            '$twitter_description' => $this->description,
            '$twitter_image_url' => $this->imageUrl,
            '$twitter_site' => $this->site,
            '$twitter_app_country' => $this->appCountry,
            '$twitter_player' => $this->player,
            '$twitter_player_width' => $this->playerWidth,
            '$twitter_player_height' => $this->playerHeight,
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
        if (strpos(strtolower($methodName), 'twitter') === 0) {
            $methodName = substr($methodName, 7);
        }

        if (method_exists($this, "set{$methodName}")) {
            $methodName = "set{$methodName}";
            $this->{$methodName}($value);
        } else {
            throw new \InvalidArgumentException("Property {$name} does not exist");
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
        $propertyName = studly_case($name);
        if (strpos(strtolower($propertyName), 'twitter') === 0) {
            $propertyName = substr($propertyName, 7);
        }

        $propertyName = lcfirst($propertyName);
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        throw new \InvalidArgumentException("Property {$name} does not exist");
    }

    /**
     * Call the set* instead of setTwitter*
     *
     * @param string $name string
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $methodName = $name;
        if (strpos($methodName, 'setTwitter')) {
            $methodName = str_replace('setTwitter', 'set', $methodName);
        }

        if (method_exists($this, $methodName)) {
            return call_user_func_array([$this, $methodName], $arguments);
        }

        throw new \InvalidArgumentException("Method {$name} does not exist");
    }
}
