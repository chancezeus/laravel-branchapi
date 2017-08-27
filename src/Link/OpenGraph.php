<?php
/**
 * Created by IntelliJ IDEA.
 * User: mark
 * Date: 25-8-17
 * Time: 23:15
 */

namespace ChanceZeus\BranchApi\Link;

/**
 * Class OpenGraph
 * @package ChanceZeus\BranchApi\Link
 * 
 * @method OpenGraph setOgTitle(string $title = null)
 * @method OpenGraph setOgDescription(string $description = null)
 * @method OpenGraph setOgImageUrl(string $imageUrl = null, int $imageWidth = null, int $imageHeight = null)
 * @method OpenGraph setOgImageWidth(int $imageWidth = null)
 * @method OpenGraph setOgImageHeight(int $imageHeight = null)
 * @method OpenGraph setOgVideo(string $video = null)
 * @method OpenGraph setOgType(OgTypeEnum $type = null)
 * @method OpenGraph setOgRedirect(string $redirect = null)
 * @method OpenGraph setOgAppId(string $appId = null)
 * @property string $ogTitle
 * @property string $ogDescription
 * @property string $ogImageUrl
 * @property int $ogImageWidth
 * @property int $ogImageHeight
 * @property string $ogVideo
 * @property OgTypeEnum $ogType
 * @property string $ogRedirect
 * @property string $ogAppId
 */
class OpenGraph
{
    /** @var string */
    private $title;

    /** @var string */
    private $description;

    /** @var string */
    private $imageUrl;

    /** @var int */
    private $imageWidth;

    /** @var int */
    private $imageHeight;

    /** @var string */
    private $video;

    /** @var string */
    private $url;

    /** @var OgTypeEnum */
    private $type;

    /** @var string */
    private $redirect;

    /** @var string */
    private $appId;

    /**
     * @param string|null $title
     * @return OpenGraph
     */
    public function setTitle(string $title = null): OpenGraph
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string|null $description
     * @return OpenGraph
     */
    public function setDescription(string $description = null): OpenGraph
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string|null $imageUrl
     * @param int|null $imageWidth
     * @param int|null $imageHeight
     * @return OpenGraph
     */
    public function setImageUrl(string $imageUrl = null, int $imageWidth = null, int $imageHeight = null): OpenGraph
    {
        $this->imageUrl = $imageUrl;
        $this->imageWidth = $imageWidth;
        $this->imageHeight = $imageHeight;

        return $this;
    }

    /**
     * @param int|null $imageWidth
     * @return OpenGraph
     */
    public function setImageWidth(int $imageWidth = null): OpenGraph
    {
        $this->imageWidth = $imageWidth;

        return $this;
    }

    /**
     * @param int|null $imageHeight
     * @return OpenGraph
     */
    public function setImageHeight(int $imageHeight = null): OpenGraph
    {
        $this->imageHeight = $imageHeight;

        return $this;
    }

    /**
     * @param string|null $video
     * @return OpenGraph
     */
    public function setVideo(string $video = null): OpenGraph
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @param string|null $url
     * @return OpenGraph
     */
    public function setUrl(string $url = null): OpenGraph
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @param OgTypeEnum|null $type
     * @return OpenGraph
     */
    public function setType(OgTypeEnum $type = null): OpenGraph
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param string|null $redirect
     * @return OpenGraph
     */
    public function setRedirect(string $redirect = null): OpenGraph
    {
        $this->redirect = $redirect;

        return $this;
    }

    /**
     * @param string|null $appId
     * @return OpenGraph
     */
    public function setAppId(string $appId = null): OpenGraph
    {
        $this->appId = $appId;

        return $this;
    }


    /**
     * Build the og link data
     *
     * @return array
     */
    public function build()
    {
        return [
            '$og_title' => $this->title,
            '$og_description' => $this->description,
            '$og_image_url' => $this->imageUrl,
            '$og_image_width' => $this->imageWidth,
            '$og_image_height' => $this->imageHeight,
            '$og_video' => $this->video,
            '$og_url' => $this->url,
            '$og_type' => $this->type,
            '$og_redirect' => $this->redirect,
            '$og_app_id' => $this->appId,
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
        if (strpos(strtolower($methodName), 'og') === 0) {
            $methodName = substr($methodName, 2);
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
        if (strpos(strtolower($propertyName), 'og') === 0) {
            $propertyName = $propertyName($name, 2);
        }

        $propertyName = lcfirst($propertyName);
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        throw new \InvalidArgumentException("Property {$name} does not exist");
    }

    /**
     * Call the set* instead of setOg*
     *
     * @param string $name string
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $methodName = $name;
        if (strpos($methodName, 'setOg')) {
            $methodName = str_replace('setOg', 'set', $methodName);
        }

        if (method_exists($this, $methodName)) {
            return call_user_func_array([$this, $methodName], $arguments);
        }

        throw new \InvalidArgumentException("Method {$name} does not exist");
    }
}
