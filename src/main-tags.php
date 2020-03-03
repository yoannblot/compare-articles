<?php

use PHPHtmlParser\Dom;

function checkMainTags(Dom $prismicDom, Dom $censhareDom)
{
    logText('Check main tags...');

    checkMainTag($prismicDom, $censhareDom, '.tag.tag--with-icon .inspiration-article__tags-link', 'Destination');
    checkMainTag($prismicDom, $censhareDom, '.tag .inspiration-article__tags-link', 'Thematic', 1);
}

function checkMainTag(Dom $prismicDom, Dom $censhareDom, $selector, $tagName, $position = 0)
{
    $prismicTag  = getMainTag($prismicDom, $selector, $position);
    $censhareTag = getMainTag($censhareDom, $selector, $position);

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

    return $prismicUri === $censhareUri;
}

function getMainTag(Dom $dom, $selector, $position)
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
