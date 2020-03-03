<?php

use PHPHtmlParser\Dom;

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

function checkTagBySelector(Dom $prismicDom, Dom $censhareDom, $selector, $stripTags = false)
{
    $prismicValue  = getTagValueBySelector($prismicDom, $selector);
    $censhareValue = getTagValueBySelector($censhareDom, $selector);
    if ($stripTags) {
        $prismicValue  = strip_tags($prismicValue);
        $censhareValue = strip_tags($censhareValue);
    }

    if ($prismicValue !== $censhareValue) {
        logText("'$selector' does not match! Prismic '$prismicValue' / Censhare '$censhareValue'");

        return false;
    }

    logText("'$selector' is alright.");

    return true;
}

function getUrlTag(Dom $dom, $selector, $position)
{
    $collection = $dom->find($selector);
    if (count($collection) < $position + 1) {
        return [
            'value' => null,
            'url'   => null
        ];
    }

    /** @var Dom\HtmlNode $node */
    $node = $collection[$position];

    $text = trim($node->innerHtml());
    $href = $node->getAttribute('href');

    return [
        'value' => $text,
        'url'   => $href
    ];
}

function checkUrlTags(Dom $prismicDom, Dom $censhareDom, $selector, $tagName, $position = 0)
{
    $prismicTag  = getUrlTag($prismicDom, $selector, $position);
    $censhareTag = getUrlTag($censhareDom, $selector, $position);

    if ($prismicTag['value'] !== $censhareTag['value']) {
        logText(
            "$tagName tag does not match! Prismic '{$prismicTag['value']}' / Censhare '{$censhareTag['value']}'"
        );

        return;
    }
    if (!areSameUrls($prismicTag['url'], $censhareTag['url'])) {
        logText(
            "$tagName tag does not match! Prismic '{$prismicTag['url']}' / Censhare '{$censhareTag['url']}'"
        );

        return;
    }

    logText("$tagName tag is alright.");
}

function areSameUrls($prismicUrl, $censhareUrl)
{
    $prismicUri  = parse_url($prismicUrl)['path'];
    $censhareUri = parse_url($censhareUrl)['path'];

    $censhareUri = str_replace('/hcms', '', $censhareUri);

    return $prismicUri === $censhareUri;
}
