<?php

function logText($text)
{
    echo $text . PHP_EOL;
}

function getHtmlContent($url, $type)
{
    $cacheFile = ROOT_PATH . 'var/cache/' . md5($url);
    if (!file_exists($cacheFile)) {
        $arrContextOptions = [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ];
        logText("Getting $type content...");
        file_put_contents($cacheFile, file_get_contents($url, false, stream_context_create($arrContextOptions)));
        logText("$type content retrieved!");
    }

    return file_get_contents($cacheFile);
}
