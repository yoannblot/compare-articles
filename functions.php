<?php

function logText($text)
{
    echo $text . PHP_EOL;
}

function getHtmlContent($url, $type)
{
    $cacheFile = __DIR__ . '/var/cache/' . md5($url);
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

function checkMetaData(DOMNodeList $prismicTags, DOMNodeList $censhareTags, $fieldName, $fieldValue)
{
    $prismicValue  = getTagValue($prismicTags, $fieldName, $fieldValue);
    $censhareValue = getTagValue($censhareTags, $fieldName, $fieldValue);

    if ($prismicValue !== $censhareValue) {
        logText("Meta $fieldValue does not match! Prismic '$prismicValue' / Censhare '$censhareValue'");
    } else {
        logText("Meta $fieldValue is alright.");
    }
}

function getTagValue(DOMNodeList $tags, $fieldName, $fieldValue)
{
    foreach ($tags as $tag) {
        /** @var DOMElement $tag */
        if (containsAttribute($tag, $fieldName, $fieldValue)) {
            return getAttributeValue($tag);
        }
    }

    return null;
}

function getAttributeValue(DOMElement $tag)
{
    foreach ($tag->attributes as $attribute) {
        /** @var DOMAttr $attribute */
        if ($attribute->name === 'content') {
            return $attribute->value;
        }
    }

    return null;
}

function containsAttribute(DOMElement $tag, $fieldName, $fieldValue)
{
    foreach ($tag->attributes as $attribute) {
        /** @var DOMAttr $attribute */
        if ($attribute->name === $fieldName && $attribute->value === $fieldValue) {
            return true;
        }
    }

    return false;
}
