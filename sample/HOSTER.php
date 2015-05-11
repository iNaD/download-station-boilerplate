<?php

/**
 * @author Daniel Gehn <me@theinad.com>
 * @version 0.1a
 * @copyright 2015 Daniel Gehn
 * @license http://opensource.org/licenses/MIT Licensed under MIT License
 */

require_once 'provider.php';

class SynoFileHostingHOSTER extends TheiNaDProvider {
    protected $LogPath = '/tmp/HOSTER.log';

    public function GetDownloadInfo() {
        // TODO: Implement URL parser

        $DownloadInfo = array();
        $DownloadInfo[DOWNLOAD_URL] = $this->Url;
        $DownloadInfo[DOWNLOAD_FILENAME] = $this->safeFilename($this->Filename);

        return $DownloadInfo;
    }

 }
?>
