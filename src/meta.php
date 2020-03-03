<?php

use PHPHtmlParser\Dom;

function checkMetaData(Dom $prismicDom, Dom $censhareDom, $fieldName, $fieldValue)
{
    $prismicValue  = getValueOfAttribute($prismicDom, $fieldName, $fieldValue);
    $censhareValue = getValueOfAttribute($censhareDom, $fieldName, $fieldValue);

    if ($prismicValue !== $censhareValue) {
        logText("Meta $fieldValue does not match! Prismic '$prismicValue' / Censhare '$censhareValue'");
    } else {
        logText("Meta $fieldValue is alright.");
    }
}

function getValueOfAttribute(Dom $dom, $attributeName, $attributeValue)
{
    $selector   = "meta[$attributeName='$attributeValue']";
    $collection = $dom->find($selector);
    if (count($collection) === 0) {
        return null;
    }

    /** @var Dom\HtmlNode $node */
    $node = $collection[0];

    return $node->getAttribute('content');
}

function checkAllMetaData(Dom $prismicDom, Dom $censhareDom)
{
    logText('Check metadata...');
    checkTag(
        $prismicDom,
        $censhareDom,
        'title'
    );
    checkMetaData(
        $prismicDom,
        $censhareDom,
        'name',
        'description'
    );
    checkMetaData(
        $prismicDom,
        $censhareDom,
        'property',
        'og:title'
    );
    checkMetaData(
        $prismicDom,
        $censhareDom,
        'property',
        'og:description'
    );
}

function getTagValue(Dom $dom, $tagName)
{
    $collection = $dom->find($tagName);

    if (count($collection) === 0) {
        return null;
    }

    /** @var Dom\HtmlNode $node */
    $node = $collection[0];

    return $node->innerHtml();
}

function checkTag(Dom $prismicDom, Dom $censhareDom, $tagName)
{
    $prismicValue  = getTagValue($prismicDom, $tagName);
    $censhareValue = getTagValue($censhareDom, $tagName);

    if ($prismicValue !== $censhareValue) {
        logText("Tag '<$tagName>' does not match! Prismic '$prismicValue' / Censhare '$censhareValue'");
    } else {
        logText("Tag '<$tagName>' is alright.");
    }
}
