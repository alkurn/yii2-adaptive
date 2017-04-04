<?php

namespace alkurn\adaptive;

use Yii;
use Yii\base\ErrorException;
use Yii\helpers\ArrayHelper;
use yii\base\Component;
use PayPal\Service\AdaptivePaymentsService;

class Adaptive extends Component
{
    //region Mode (production/development)
    const MODE_SANDBOX = 'sandbox';
    const MODE_LIVE    = 'live';
    const PAYPAL_REDIRECT_URL = 'https://www.sandbox.paypal.com/webscr&cmd=';
    const DEVELOPER_PORTAL = 'https://developer.paypal.com';

    //region API settings
    public $userName;
    public $password;
    public $signature;
    public $appId;
    public $isProduction = false;
    public $currency = 'USD';
    public $mode ;
    public $businessEmail;
    public $config = [];

    /** @var ApiContext */
    protected $_apiService = null;

    /**
     * @setConfig
     * _apiContext in init() method
     */
    public function init()
    {
        $this->setConfig();
    }
    /**
     * @inheritdoc
     */
    public function setConfig()
    {
        $config = array(
            // Signature Credential
            "mode" => self::MODE_SANDBOX,
            "acct1.UserName" =>  $this->userName,
            "acct1.Password" => $this->password,
            "acct1.Signature" => $this->signature,
            "acct1.AppId" => $this->appId

            // Sample Certificate Credential
            // "acct1.UserName" => "certuser_biz_api1.paypal.com",
            // "acct1.Password" => "D6JNKKULHN3G5B8A",
            // Certificate path relative to config folder or absolute path in file system
            // "acct1.CertPath" => "cert_key.pem",
            // "acct1.AppId" => "APP-80W284485P519543T"
        );

        $this->_apiService = new AdaptivePaymentsService($config);

        return $this->_apiService;
    }

}