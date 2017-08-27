<?php

namespace ChanceZeus\BranchApi\App;

use Carbon\Carbon;

/**
 * Class AppConfig
 * @package ChanceZeus\BranchApi\App
 *
 * @property string $appName
 * @property string $devName
 * @property string $devEmail
 * @property bool $alwaysOpenApp
 * @property AppTypeEnum $androidApp
 * @property string $androidUrl
 * @property string $androidUriScheme
 * @property string $androidPackageName
 * @property bool $androidAppLinksEnabled
 * @property AppTypeEnum $iosApp
 * @property string $iosUrl
 * @property string $iosUriScheme
 * @property string $iosStoreCountry
 * @property string $iosBundleId
 * @property string $iosTeamId
 * @property bool $universalLinkingEnabled
 * @property string $fireUrl
 * @property string $windowsPhoneUrl
 * @property string $blackberryUrl
 * @property string $webUrl
 * @property string $defaultDesktopUrl
 * @property string $textMessage
 * @property string $ogAppId
 * @property string $ogTitle
 * @property string $ogImageUrl
 * @property string $ogDescription
 * @property string $deepviewDesktop
 * @property string $deepviewIos
 * @property string $deepviewAndroid
 * @property array $sha256CertFingerprints
 * @property-read string $id
 * @property-read string $appKey
 * @property-read Carbon $creationDate
 * @property-read string $origin
 * @property-read string $devPhoneNumber
 * @property-read string $shortUrlDomain
 * @property-read string $defaultShortUrlDomain
 * @property-read string $alternateShortUrlDomain
 * @property-read string $branchKey
 * @property-read string $branchSecret
 */
class AppConfig
{
    /** @var string */
    private $id;

    /** @var string */
    private $appKey;

    /** @var Carbon */
    private $creationDate;

    /** @var string */
    private $appName;

    /** @var string */
    private $origin;

    /** @var string */
    private $devName;

    /** @var string */
    private $devEmail;

    /** @var string */
    private $devPhoneNumber;

    /** @var bool */
    private $alwaysOpenApp;

    /** @var AppTypeEnum */
    private $androidApp;

    /** @var string */
    private $androidUrl;

    /** @var string */
    private $androidUriScheme;

    /** @var string */
    private $androidPackageName;

    /** @var bool */
    private $androidAppLinksEnabled = true;

    /** @var AppTypeEnum */
    private $iosApp;

    /** @var string */
    private $iosUrl;

    /** @var string */
    private $iosUriScheme;

    /** @var string */
    private $iosStoreCountry;

    /** @var string */
    private $iosBundleId;

    /** @var string */
    private $iosTeamId;

    /** @var bool */
    private $universalLinkingEnabled = true;

    /** @var string */
    private $fireUrl;

    /** @var string */
    private $windowsPhoneUrl;

    /** @var string */
    private $blackberryUrl;

    /** @var string */
    private $webUrl;

    /** @var string */
    private $defaultDesktopUrl;

    /** @var string */
    private $shortUrlDomain;

    /** @var string */
    private $defaultShortUrlDomain;

    /** @var string */
    private $alternateShortUrlDomain;

    /** @var string */
    private $textMessage;

    /** @var string */
    private $ogAppId;

    /** @var string */
    private $ogTitle;

    /** @var string */
    private $ogImageUrl;

    /** @var string */
    private $ogDescription;

    /** @var string */
    private $deepviewDesktop;

    /** @var string */
    private $deepviewIos;

    /** @var string */
    private $deepviewAndroid;

    /** @var string */
    private $branchKey;

    /** @var string */
    private $branchSecret;

    /** @var array */
    private $sha256CertFingerprints = [];

    /**
     * AppConfig constructor.
     *
     * @param string $appName
     */
    public function __construct(string $appName)
    {
        $this->appName = $appName;

        $this->androidApp = AppTypeEnum::instance(AppTypeEnum::STORE);
        $this->iosApp = AppTypeEnum::instance(AppTypeEnum::STORE);
    }

    /**
     * Parse the array representation back into a AppConfig object
     * @param array $data
     * @return AppConfig
     */
    public static function parse(array $data): AppConfig
    {
        $appConfig = new AppConfig(array_get($data, 'app_name'));

        array_walk_recursive($data, function ($value, $key) use ($appConfig) {
            if ($key === 'app_name') {
                return;
            }

            if ($key === 'creation_date') {
                $value = Carbon::parse(preg_replace('#Z$#', '+0000', $value));
            } else if (in_array($key, ['android_app', 'ios_app'])) {
                $value = AppTypeEnum::instance($value);
            } else if (in_array($key, ['always_open_app', 'android_app_links_enabled', 'universal_linking_enabled'])) {
                $value = $value == '1';
            }

            $key = camel_case($key);

            if (property_exists($appConfig, $key)) {
                $appConfig->{$key} = $value;
            }
        });

        return $appConfig;
    }

    /**
     * @param string $appName
     * @return AppConfig
     */
    public function setAppName(string $appName): AppConfig
    {
        $this->appName = $appName;

        return $this;
    }

    /**
     * @param string $devName
     * @return AppConfig
     */
    public function setDevName(string $devName): AppConfig
    {
        $this->devName = $devName;

        return $this;
    }

    /**
     * @param string $devEmail
     * @return AppConfig
     */
    public function setDevEmail(string $devEmail): AppConfig
    {
        $this->devEmail = $devEmail;

        return $this;
    }

    /**
     * @param bool $alwaysOpenApp
     * @return AppConfig
     */
    public function setAlwaysOpenApp(bool $alwaysOpenApp = true): AppConfig
    {
        $this->alwaysOpenApp = $alwaysOpenApp;

        return $this;
    }

    /**
     * @param AppTypeEnum $androidApp
     * @return AppConfig
     */
    public function setAndroidApp(AppTypeEnum $androidApp): AppConfig
    {
        $this->androidApp = $androidApp;

        return $this;
    }

    /**
     * @param string|null $androidUrl
     * @return AppConfig
     */
    public function setAndroidUrl(string $androidUrl = null): AppConfig
    {
        $this->androidUrl = $androidUrl;

        return $this;
    }

    /**
     * @param string|null $androidUriScheme
     * @return AppConfig
     */
    public function setAndroidUriScheme(string $androidUriScheme = null): AppConfig
    {
        $this->androidUriScheme = $androidUriScheme;

        return $this;
    }

    /**
     * @param string|null $androidPackageName
     * @return AppConfig
     */
    public function setAndroidPackageName(string $androidPackageName = null): AppConfig
    {
        $this->androidPackageName = $androidPackageName;

        return $this;
    }

    /**
     * @param bool $androidAppLinksEnabled
     * @return AppConfig
     */
    public function setAndroidAppLinksEnabled(bool $androidAppLinksEnabled = true): AppConfig
    {
        $this->androidAppLinksEnabled = $androidAppLinksEnabled;

        return $this;
    }

    /**
     * @param AppTypeEnum $iosApp
     * @return AppConfig
     */
    public function setIosApp(AppTypeEnum $iosApp): AppConfig
    {
        $this->iosApp = $iosApp;

        return $this;
    }

    /**
     * @param string|null $iosUrl
     * @return AppConfig
     */
    public function setIosUrl(string $iosUrl = null): AppConfig
    {
        $this->iosUrl = $iosUrl;

        return $this;
    }

    /**
     * @param string|null $iosUriScheme
     * @return AppConfig
     */
    public function setIosUriScheme(string $iosUriScheme = null): AppConfig
    {
        $this->iosUriScheme = $iosUriScheme;

        return $this;
    }

    /**
     * @param string|null $iosStoreCountry
     * @return AppConfig
     */
    public function setIosStoreCountry(string $iosStoreCountry = null): AppConfig
    {
        $this->iosStoreCountry = $iosStoreCountry;

        return $this;
    }

    /**
     * @param string|null $iosBundleId
     * @return AppConfig
     */
    public function setIosBundleId(string $iosBundleId = null): AppConfig
    {
        $this->iosBundleId = $iosBundleId;

        return $this;
    }

    /**
     * @param string|null $iosTeamId
     * @return AppConfig
     */
    public function setIosTeamId(string $iosTeamId = null): AppConfig
    {
        $this->iosTeamId = $iosTeamId;

        return $this;
    }

    /**
     * @param bool $universalLinkingEnabled
     * @return AppConfig
     */
    public function setUniversalLinkingEnabled(bool $universalLinkingEnabled): AppConfig
    {
        $this->universalLinkingEnabled = $universalLinkingEnabled;

        return $this;
    }

    /**
     * @param string|null $fireUrl
     * @return AppConfig
     */
    public function setFireUrl(string $fireUrl = null): AppConfig
    {
        $this->fireUrl = $fireUrl;

        return $this;
    }

    /**
     * @param string|null $windowsPhoneUrl
     * @return AppConfig
     */
    public function setWindowsPhoneUrl(string $windowsPhoneUrl = null): AppConfig
    {
        $this->windowsPhoneUrl = $windowsPhoneUrl;

        return $this;
    }

    /**
     * @param string|null $blackberryUrl
     * @return AppConfig
     */
    public function setBlackberryUrl(string $blackberryUrl = null): AppConfig
    {
        $this->blackberryUrl = $blackberryUrl;

        return $this;
    }

    /**
     * @param string|null $webUrl
     * @return AppConfig
     */
    public function setWebUrl(string $webUrl = null): AppConfig
    {
        $this->webUrl = $webUrl;

        return $this;
    }

    /**
     * @param string|null $defaultDesktopUrl
     * @return AppConfig
     */
    public function setDefaultDesktopUrl(string $defaultDesktopUrl = null): AppConfig
    {
        $this->defaultDesktopUrl = $defaultDesktopUrl;

        return $this;
    }

    /**
     * @param string|null $textMessage
     * @return AppConfig
     */
    public function setTextMessage(string $textMessage = null): AppConfig
    {
        $this->textMessage = $textMessage;

        return $this;
    }

    /**
     * @param string|null $ogAppId
     * @return AppConfig
     */
    public function setOgAppId(string $ogAppId = null): AppConfig
    {
        $this->ogAppId = $ogAppId;

        return $this;
    }

    /**
     * @param string|null $ogTitle
     * @return AppConfig
     */
    public function setOgTitle(string $ogTitle = null): AppConfig
    {
        $this->ogTitle = $ogTitle;

        return $this;
    }

    /**
     * @param string|null $ogImageUrl
     * @return AppConfig
     */
    public function setOgImageUrl(string $ogImageUrl = null): AppConfig
    {
        $this->ogImageUrl = $ogImageUrl;

        return $this;
    }

    /**
     * @param string|null $ogDescription
     * @return AppConfig
     */
    public function setOgDescription(string $ogDescription = null): AppConfig
    {
        $this->ogDescription = $ogDescription;

        return $this;
    }

    /**
     * @param string|null $deepviewDesktop
     * @return AppConfig
     */
    public function setDeepviewDesktop(string $deepviewDesktop = null): AppConfig
    {
        $this->deepviewDesktop = $deepviewDesktop;

        return $this;
    }

    /**
     * @param string|null $deepviewIos
     * @return AppConfig
     */
    public function setDeepviewIos(string $deepviewIos = null): AppConfig
    {
        $this->deepviewIos = $deepviewIos;
        return $this;
    }

    /**
     * @param string|null $deepviewAndroid
     * @return AppConfig
     */
    public function setDeepviewAndroid(string $deepviewAndroid = null): AppConfig
    {
        $this->deepviewAndroid = $deepviewAndroid;

        return $this;
    }

    /**
     * @param array $sha256CertFingerprints
     * @return AppConfig
     */
    public function setSha256CertFingerprints(array $sha256CertFingerprints = []): AppConfig
    {
        $this->sha256CertFingerprints = [];
        foreach ($sha256CertFingerprints as $fingerprint) {
            $this->addSha256CertFingerprint($fingerprint);
        }

        return $this;
    }

    public function addSha256CertFingerprint(string $sha256CertFingerprint): AppConfig
    {
        $this->sha256CertFingerprints[] = $sha256CertFingerprint;

        return $this;
    }

    /**
     * Builds the config
     *
     * @return array
     */
    public function build()
    {
        return [
            'app_name' => $this->appName,
            'dev_name' => $this->devName,
            'dev_email' => $this->devEmail,
            'android_app' => $this->androidApp ? $this->androidApp->getValue() : AppTypeEnum::instance(AppTypeEnum::NONE),
            'android_url' => $this->androidUrl,
            'android_uri_scheme' => $this->androidUriScheme,
            'android_package_name' => $this->androidPackageName,
            'sha256_cert_fingerprints' => $this->sha256CertFingerprints,
            'android_app_links_enabled' => $this->androidAppLinksEnabled ? 1 : 0,
            'ios_app' => $this->iosApp ? $this->iosApp->getValue() : AppTypeEnum::instance(AppTypeEnum::NONE),
            'ios_url' => $this->iosUrl,
            'ios_uri_scheme' => $this->iosUriScheme,
            'ios_store_country' => $this->iosStoreCountry,
            'ios_bundle_id' => $this->iosBundleId,
            'ios_team_id' => $this->iosTeamId,
            'universal_linking_enabled' => $this->universalLinkingEnabled ? 1 : 0,
            'fire_url' => $this->fireUrl,
            'windows_phone_url' => $this->windowsPhoneUrl,
            'blackberry_url' => $this->blackberryUrl,
            'web_url' => $this->webUrl,
            'default_desktop_url' => $this->defaultDesktopUrl,
            'short_url_domain' => $this->shortUrlDomain,
            'text_message' => $this->textMessage,
            'og_app_id' => $this->ogAppId,
            'og_title' => $this->ogTitle,
            'og_image_url' => $this->ogImageUrl,
            'og_description' => $this->ogDescription,
            'deepview_desktop' => $this->deepviewDesktop,
            'deepview_ios' => $this->deepviewIos,
            'deepview_android' => $this->deepviewAndroid,
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
        $propertyName = camel_case($name);
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        throw new \InvalidArgumentException("Property {$name} does not exist");
    }
}
