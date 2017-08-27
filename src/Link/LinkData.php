<?php

namespace ChanceZeus\BranchApi\Link;

/**
 * Class LinkData
 * @package ChanceZeus\BranchApi\Link
 *
 * @property bool $webOnly
 * @property int $matchDuration
 * @property bool $alwaysDeeplink
 * @property int $iosRedirectTimeout
 * @property int $androidRedirectTimeout
 * @property bool $oneTimeUse
 * @property string $customSmsText
 * @property string $marketingTitle
 * @property bool $publiclyIndexable
 * @property string[] $keywords
 * @property string $keyword
 * @property string $canonicalIdentifier
 * @property \DateTimeInterface $expDate
 * @property string $contentType
 * @property string[] $customMetaTags
 * @property string[] $customData
 * @property string $androidUrl
 * @property string $androidWechatUrl
 * @property string $iosUrl
 * @property string $iosHasAppUrl
 * @property string $iosWechatUrl
 * @property string $fireUrl
 * @property string $windowsPhoneUrl
 * @property string $blackberryUrl
 * @property string $desktopUrl
 * @property string $fallbackUrl
 * @property string $afterClickUrl
 * @property string $androidDeepview
 * @property string $iosDeepview
 * @property string $desktopDeepview
 * @property string $deeplinkPath
 * @property string $androidDeeplinkPath
 * @property string $iosDeeplinkPath
 * @mixin OpenGraph
 * @mixin Twitter
 */
class LinkData
{
    /** @var bool */
    private $webOnly;

    /** @var int */
    private $matchDuration;

    /** @var bool */
    private $alwaysDeeplink = true;

    /** @var int */
    private $iosRedirectTimeout;

    /** @var int */
    private $androidRedirectTimeout;

    /** @var bool */
    private $oneTimeUse = false;

    /** @var string */
    private $customSmsText;

    /** @var string */
    private $marketingTitle;

    /** @var bool */
    private $publiclyIndexable = true;

    /** @var string[] */
    private $keywords = [];

    /** @var string */
    private $canonicalIdentifier;

    /** @var \DateTimeInterface */
    private $expDate;

    /** @var string */
    private $contentType;

    /** @var string[] */
    private $customMetaTags = [];

    /** @var string */
    private $androidUrl;

    /** @var string */
    private $androidWechatUrl;

    /** @var string */
    private $iosUrl;

    /** @var string */
    private $iosHasAppUrl;

    /** @var string */
    private $iosWechatUrl;

    /** @var string */
    private $fireUrl;

    /** @var string */
    private $windowsPhoneUrl;

    /** @var string */
    private $blackberryUrl;

    /** @var string */
    private $desktopUrl;

    /** @var string */
    private $fallbackUrl;

    /** @var string */
    private $afterClickUrl;

    /** @var string */
    private $androidDeepview;

    /** @var string */
    private $iosDeepview;

    /** @var string */
    private $desktopDeepview;

    /** @var string */
    private $deeplinkPath;

    /** @var string */
    private $androidDeeplinkPath;

    /** @var string */
    private $iosDeeplinkPath;

    /** @var array */
    private $customData = [];

    /** @var OpenGraph */
    private $openGraph;

    /** @var Twitter */
    private $twitter;

    /**
     * LinkData constructor.
     */
    public function __construct()
    {
        $this->openGraph = new OpenGraph;
        $this->twitter = new Twitter;
    }

    /**
     * @param bool $webOnly
     * @return LinkData
     */
    public function setWebOnly(bool $webOnly = false): LinkData
    {
        $this->webOnly = $webOnly;
        return $this;
    }

    /**
     * @param int|null $matchDuration
     * @return LinkData
     */
    public function setMatchDuration(int $matchDuration = null): LinkData
    {
        $this->matchDuration = $matchDuration;
        return $this;
    }

    /**
     * @param bool $alwaysDeeplink
     * @return LinkData
     */
    public function setAlwaysDeeplink(bool $alwaysDeeplink = true): LinkData
    {
        $this->alwaysDeeplink = $alwaysDeeplink;
        return $this;
    }

    /**
     * @param int|null $timeout
     * @return LinkData
     */
    public function setTimeout(int $timeout = null): LinkData
    {
        return $this->setAndroidRedirectTimeout($timeout)->setIosRedirectTimeout($timeout);
    }

    /**
     * @param int|null $timeout
     * @return LinkData
     */
    public function setAndroidRedirectTimeout(int $timeout = null): LinkData
    {
        $this->androidRedirectTimeout = $timeout;
        return $this;
    }

    /**
     * @param int|null $timeout
     * @return LinkData
     */
    public function setIosRedirectTimeout(int $timeout = null): LinkData
    {
        $this->iosRedirectTimeout = $timeout;
        return $this;
    }

    /**
     * @param bool $oneTimeUse
     * @return LinkData
     */
    public function setOneTimeUse(bool $oneTimeUse = false): LinkData
    {
        $this->oneTimeUse = $oneTimeUse;
        return $this;
    }

    /**
     * @param string|null $customSmsText
     * @return LinkData
     */
    public function setCustomSmsText(string $customSmsText = null): LinkData
    {
        if ($customSmsText && preg_match('#{{\s?link\s?}}#', $customSmsText) === 0) {
            $customSmsText = "{$customSmsText} {{ link }}";
        }

        $this->customSmsText = $customSmsText;

        return $this;
    }

    /**
     * @param string|null $marketingTitle
     * @return LinkData
     */
    public function setMarketingTitle(string $marketingTitle = null): LinkData
    {
        $this->marketingTitle = $marketingTitle;
        return $this;
    }

    /**
     * @param bool $publiclyIndexable
     * @return LinkData
     */
    public function setPubliclyIndexable(bool $publiclyIndexable = true): LinkData
    {
        $this->publiclyIndexable = $publiclyIndexable;
        return $this;
    }

    /**
     * @param string[] $keywords
     * @return LinkData
     */
    public function setKeywords(array $keywords = []): LinkData
    {
        $this->keywords = [];
        foreach ($keywords as $keyword) {
            $this->addKeyword($keyword);
        }

        return $this;
    }

    /**
     * @param string|null $keyword
     * @return LinkData
     */
    public function addKeyword(string $keyword): LinkData
    {
        $this->keywords[] = $keyword;
        return $this;
    }

    /**
     * @param string|null $canonicalIdentifier
     * @return LinkData
     */
    public function setCanonicalIdentifier(string $canonicalIdentifier = null): LinkData
    {
        $this->canonicalIdentifier = $canonicalIdentifier;
        return $this;
    }

    /**
     * @param \DateTimeInterface|null $expDate
     * @return LinkData
     */
    public function setExpDate(\DateTimeInterface $expDate = null): LinkData
    {
        $this->expDate = $expDate;
        return $this;
    }

    /**
     * @param string|null $contentType
     * @return LinkData
     */
    public function setContentType(string $contentType = null): LinkData
    {
        $this->contentType = $contentType;
        return $this;
    }

    /**
     * @param string[] $customMetaTags
     * @return LinkData
     */
    public function setCustomMetaTags(array $customMetaTags = []): LinkData
    {
        $this->customMetaTags = [];
        foreach ($customMetaTags as $name => $value) {
            $this->addCustomMetaTag($name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return LinkData
     */
    public function addCustomMetaTag(string $name, $value): LinkData
    {
        $this->customMetaTags[$name] = $value;

        return $this;
    }

    /**
     * @param string $androidUrl
     * @return LinkData
     */
    public function setAndroidUrl(string $androidUrl): LinkData
    {
        $this->androidUrl = $androidUrl;
        return $this;
    }

    /**
     * @param string $androidWechatUrl
     * @return LinkData
     */
    public function setAndroidWechatUrl(string $androidWechatUrl): LinkData
    {
        $this->androidWechatUrl = $androidWechatUrl;
        return $this;
    }

    /**
     * @param string $iosUrl
     * @return LinkData
     */
    public function setIosUrl(string $iosUrl): LinkData
    {
        $this->iosUrl = $iosUrl;
        return $this;
    }

    /**
     * @param string $iosHasAppUrl
     * @return LinkData
     */
    public function setIosHasAppUrl(string $iosHasAppUrl): LinkData
    {
        $this->iosHasAppUrl = $iosHasAppUrl;
        return $this;
    }

    /**
     * @param string $iosWechatUrl
     * @return LinkData
     */
    public function setIosWechatUrl(string $iosWechatUrl): LinkData
    {
        $this->iosWechatUrl = $iosWechatUrl;
        return $this;
    }

    /**
     * @param string $fireUrl
     * @return LinkData
     */
    public function setFireUrl(string $fireUrl): LinkData
    {
        $this->fireUrl = $fireUrl;
        return $this;
    }

    /**
     * @param string $windowsPhoneUrl
     * @return LinkData
     */
    public function setWindowsPhoneUrl(string $windowsPhoneUrl): LinkData
    {
        $this->windowsPhoneUrl = $windowsPhoneUrl;
        return $this;
    }

    /**
     * @param string $blackberryUrl
     * @return LinkData
     */
    public function setBlackberryUrl(string $blackberryUrl): LinkData
    {
        $this->blackberryUrl = $blackberryUrl;
        return $this;
    }

    /**
     * @param string $desktopUrl
     * @return LinkData
     */
    public function setDesktopUrl(string $desktopUrl): LinkData
    {
        $this->desktopUrl = $desktopUrl;
        return $this;
    }

    /**
     * @param string $fallbackUrl
     * @return LinkData
     */
    public function setFallbackUrl(string $fallbackUrl): LinkData
    {
        $this->fallbackUrl = $fallbackUrl;
        return $this;
    }

    /**
     * @param string $afterClickUrl
     * @return LinkData
     */
    public function setAfterClickUrl(string $afterClickUrl): LinkData
    {
        $this->afterClickUrl = $afterClickUrl;
        return $this;
    }

    /**
     * @param string $androidDeepview
     * @return LinkData
     */
    public function setAndroidDeepView(string $androidDeepview): LinkData
    {
        $this->androidDeepview = $androidDeepview;
        return $this;
    }

    /**
     * @param string $iosDeepview
     * @return LinkData
     */
    public function setIosDeepView(string $iosDeepview): LinkData
    {
        $this->iosDeepview = $iosDeepview;
        return $this;
    }

    /**
     * @param string $desktopDeepview
     * @return LinkData
     */
    public function setDesktopDeepView(string $desktopDeepview): LinkData
    {
        $this->desktopDeepview = $desktopDeepview;
        return $this;
    }

    /**
     * @param string $deeplinkPath
     * @return LinkData
     */
    public function setDeeplinkPath(string $deeplinkPath): LinkData
    {
        $this->deeplinkPath = $deeplinkPath;
        return $this;
    }

    /**
     * @param string $androidDeeplinkPath
     * @return LinkData
     */
    public function setAndroidDeeplinkPath(string $androidDeeplinkPath): LinkData
    {
        $this->androidDeeplinkPath = $androidDeeplinkPath;
        return $this;
    }

    /**
     * @param string $iosDeeplinkPath
     * @return LinkData
     */
    public function setIosDeeplinkPath(string $iosDeeplinkPath): LinkData
    {
        $this->iosDeeplinkPath = $iosDeeplinkPath;
        return $this;
    }

    /**
     * @param string[] $customData
     * @return LinkData
     */
    public function setCustomData(array $customData = []): LinkData
    {
        $this->customData = [];
        foreach ($customData as $name => $value) {
            $this->addCustomData($name, $value);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return LinkData
     */
    public function addCustomData(string $name, $value): LinkData
    {
        $this->customData[$name] = $value;

        return $this;
    }

    /**
     * Builds the link data
     *
     * @return array
     */
    public function build()
    {
        $result = [
            '$web_only' => $this->webOnly === true,
            '$match_duration' => $this->matchDuration,
            '$always_deeplink' => $this->alwaysDeeplink !== false,
            '$ios_redirect_timeout' => $this->iosRedirectTimeout,
            '$android_redirect_timeout' => $this->androidRedirectTimeout,
            '$one_time_use' => $this->oneTimeUse === true,
            '$custom_sms_text' => $this->customSmsText,
            '$marketing_title' => $this->marketingTitle,
            '$publicly_indexable' => $this->publiclyIndexable,
            '$keywords' => $this->keywords,
            '$canonical_identifier' => $this->canonicalIdentifier,
            '$exp_date' => $this->expDate ? $this->expDate->format(\DateTime::ATOM) : null,
            '$content_type' => $this->contentType,
            '$custom_meta_tags' => $this->customMetaTags ? json_encode($this->customMetaTags) : null,
            '$android_url' => $this->androidUrl,
            '$android_wechat_url' => $this->androidWechatUrl,
            '$ios_url' => $this->iosUrl,
            '$ios_has_app_url' => $this->iosHasAppUrl,
            '$ios_wechat_url' => $this->iosWechatUrl,
            '$fire_url' => $this->fireUrl,
            '$windows_phone_url' => $this->windowsPhoneUrl,
            '$blackberry_url' => $this->blackberryUrl,
            '$desktop_url' => $this->desktopUrl,
            '$fallback_url' => $this->fallbackUrl,
            '$after_click_url' => $this->afterClickUrl,
            '$android_deepview' => $this->androidDeepview,
            '$ios_deepview' => $this->iosDeepview,
            '$desktop_deepview' => $this->desktopDeepview,
            '$deeplink_path' => $this->deeplinkPath,
            '$android_deeplink_path' => $this->androidDeeplinkPath,
            '$ios_deeplink_path' => $this->iosDeeplinkPath,
        ];

        array_merge($result, $this->openGraph->build());
        array_merge($result, $this->twitter->build());

        if (!empty($this->customData)) {
            $result = array_merge($result, $this->customData);
        }

        return $result;
    }

    /**
     * Call the property setters
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        if (strpos($name, 'og') === 0) {
            $this->openGraph->{$name} = $value;
        } else if (strpos($name, 'twitter') === 0) {
            $this->twitter->{$name} = $value;
        } else {
            $methodName = studly_case($name);

            if (method_exists($this, "set{$methodName}")) {
                $methodName = "set{$methodName}";
                $this->{$methodName}($value);
            } else if (method_exists($this, "add{$methodName}")) {
                $methodName = "add{$methodName}";
                $this->{$methodName}($value);
            } else {
                $this->addCustomData($name, $value);
            }
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
        if (strpos($name, 'og') === 0) {
            return $this->openGraph->{$name};
        }

        if (strpos($name, 'twitter') === 0) {
            return $this->twitter->{$name};
        }

        if (property_exists($this, $name) && !in_array($name, ['openGraph', 'twitter'])) {
            return $this->{$name};
        }

        return array_get($this->customData, $name);
    }

    /**
     * Pass any calls to their linked items
     *
     * @param string $name
     * @param array $arguments
     * @return LinkData
     */
    public function __call($name, array $arguments = []): LinkData
    {
        if (strpos($name, 'setOg') === 0) {
            call_user_func_array([$this->openGraph, $name], $arguments);
            return $this;
        }

        if (strpos($name, 'setTwitter') === 0) {
            call_user_func_array([$this->twitter, $name], $arguments);
            return $this;
        }

        throw new \InvalidArgumentException("Method {$name} does not exist");
    }
}
