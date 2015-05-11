<?php
define('LOGIN_FAIL', 4);
define('USER_IS_FREE', 5);
define('USER_IS_PREMIUM', 6);
define('ERR_FILE_NO_EXIST', 114);
define('ERR_REQUIRED_PREMIUM', 115);
define('ERR_NOT_SUPPORT_TYPE', 116);
define('DOWNLOAD_STATION_USER_AGENT', "Mozilla/4.0 (compatible; MSIE 6.1; Windows XP)");
define('DOWNLOAD_URL', 'downloadurl'); // Real download url
define('DOWNLOAD_FILENAME', 'filename'); // Saved file name
define('DOWNLOAD_COUNT', 'count'); // Number of seconds to wait
define('DOWNLOAD_ISQUERYAGAIN', 'isqueryagain'); // 1: Use the original url query from the user again. 2: Use php output url query again.
define('DOWNLOAD_ISPARALLELDOWNLOAD', 'isparalleldownload'); //Task can download parallel flag.
define('DOWNLOAD_COOKIE', 'cookiepath');

$providers = [
    [
        'class'     => 'SynoFileHostingHOSTER',
        'include'   => '../HOSTER/HOSTER.php',
        'urls'      => [
            'http://HOSTER.de/file123.php'
        ]
    ],

];

foreach ($providers as $provider) {
    include_once $provider['include'];

    foreach($provider['urls'] as $url) {
        $hoster = new $provider['class']($url, '', '', [], '', false);

        $downloadInfo = $hoster->GetDownloadInfo();

        var_dump($downloadInfo);
    }
}
