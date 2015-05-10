<?php

/**
 * Basic Synology Hosting Provider Boilerplate
 *
 * @author Daniel Gehn <me@theinad.com>
 * @version 0.1a
 * @copyright 2015 Daniel Gehn
 * @license http://opensource.org/licenses/MIT Licensed under MIT License
 */

abstract class TheiNaDProvider {

    protected static $safeCharacters = array(
        'search' => array(
            'ß',
            'ä',
            'Ä„',
            'ö',
            'Ö',
            'ü',
            'Ü',
        ),
        'replace' => array(
            'ss',
            'ae',
            'Ae',
            'oe',
            'Oe',
            'ue',
            'Ue',
        ),
    );

    protected $Url;
    protected $Username;
    protected $Password;
    protected $HostInfo;
    protected $Filename;

    protected $LogPath = '/tmp/provider.log';
    protected $LogEnabled = false;

    /**
     * Is called on construct by Download Station
     *
     * @param string $Url           Download Url
     * @param string $Username      Login Username
     * @param string $Password      Login Password
     * @param string $HostInfo      Hoster Info
     * @param string $Filename      Filename
     * @param boolean $debug        Debug enabled or disabled
     */
    public function __construct($Url, $Username = '', $Password = '', $HostInfo = '', $Filename = '', $debug = false)
    {
        $this->Url = $Url;
        $this->Username = $Username;
        $this->Password = $Password;
        $this->HostInfo = $HostInfo;
        $this->Filename = $Filename;
        $this->LogEnabled = $debug;

        $this->DebugLog("URL: $Url");
    }

    /**
     * Is called after the download finishes
     *
     * @return void
     */
    public function onDownloaded()
    {
    }

    /**
     * Verifies the Account
     *
     * @param string $ClearCookie
     * @return integer
     */
    public function Verify($ClearCookie = '')
    {
        $this->DebugLog("Verifying User");

        return USER_IS_PREMIUM;
    }

    /**
     * Returns the Download URI to be used by Download Station
     *
     * @return mixed
     */
    public function GetDownloadInfo()
    {
        $DownloadInfo = array();
        $DownloadInfo[DOWNLOAD_URL] = $this->Url;
        $DownloadInfo[DOWNLOAD_FILENAME] = $this->Filename;

        return $DownloadInfo;
    }

    /**
     * Logs debug messages to the logfile, if log is enabled
     *
     * @param string $message Message to be logged
     */
    protected function DebugLog($message)
    {
        if($this->LogEnabled === true)
        {
            file_put_contents($this->LogPath, $message . "\n", FILE_APPEND);
        }
    }

    /**
     * Unified curl request handling
     *
     * @param $url Url which should be requested
     * @return null | String
     */
    protected function curlRequest($url)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, DOWNLOAD_STATION_USER_AGENT);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        if(!$result)
        {
            $this->DebugLog("Failed to retrieve XML. Error Info: " . curl_error($curl));
            return null;
        }

        curl_close($curl);

        return $result;
    }

    /**
     * Returns a Synology safe filename, because Umlauts currently won't work
     *
     * @param $filename string
     * @return string
     */
    protected function safeFilename($filename) {
        return str_replace(self::$safeCharacters['search'], self::$safeCharacters['replace'], $filename);
    }

    /**
     * Checks if haystack starts with needle
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    protected function startsWith($haystack, $needle) {
        // search backwards starting from haystack length characters from the end
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }

}
