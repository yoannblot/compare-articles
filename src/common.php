<?php

use PHPHtmlParser\Dom;

function logError($text, $prismicValue = '', $censhareValue = '')
{
    echo '<p style="color: red;font-weight: bold;"> /!\ ' . $text . '</p>';
    if ($prismicValue !== '') {
        $diff = new Diff(
            [$prismicValue], [$censhareValue], [
                               'ignoreNewLines'   => true,
                               'ignoreWhitespace' => true,
                               'ignoreCase'       => true
                           ]
        );
        echo $diff->render(new Diff_Renderer_Html_Inline());
    }
}

function logSuccess($text)
{
    echo '<p style="color: green;">  [OK] ' . $text . '</p>';
}

function logInfo($text)
{
    echo '<hr>';
    echo '<h3>' . $text . '</h3>';
}

function getHtmlContent($url)
{
    $cacheFile = ROOT_PATH . 'var/cache/' . md5($url);
    if (!file_exists($cacheFile) || isCacheTooOld($cacheFile)) {
        $arrContextOptions = [
            'ssl' => [
                'verify_peer'      => false,
                'verify_peer_name' => false,
            ],
        ];
        file_put_contents($cacheFile, file_get_contents($url, false, stream_context_create($arrContextOptions)));
    }

    return file_get_contents($cacheFile);
}

function isCacheTooOld(string $cacheFile): bool
{
    $creationTime = @filemtime($cacheFile);
    if ($creationTime === false) {
        return true;
    }

    return time() - $creationTime >= 60 * 24;
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
        logError("'$selector' does not match!", $prismicValue, $censhareValue);

        return false;
    }

    logSuccess("'$selector' is alright . ");

    return true;
}

function cleanHtmlTag(string $htmlContent): string
{
    $htmlContent = str_replace('&nbsp;', ' ', $htmlContent);
    $htmlContent = str_replace(['  ', ' <', 'target="_blank"', 'rel="noopener"'], [' ', '<', '', ''], $htmlContent);
    $htmlContent = trim(html_entity_decode($htmlContent));

    return $htmlContent;
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

    $text = cleanHtmlTag($node->innerHtml());
    $href = str_replace('/hcms', '', parse_url($node->getAttribute('href'))['path']);

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
        logError(
            "$tagName text tag does not match!",
            $prismicTag['value'],
            $censhareTag['value']
        );

        return;
    }
    if ($prismicTag['url'] !== $censhareTag['url']) {
        logError(
            "$tagName URL tag does not match!",
            $prismicTag['url'],
            $censhareTag['url']
        );

        return;
    }

    logSuccess("$tagName tag is alright . ");
}
