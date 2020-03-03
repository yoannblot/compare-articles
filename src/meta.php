<?php

function checkMetaData(DOMNodeList $prismicTags, DOMNodeList $censhareTags, $fieldName, $fieldValue)
{
    $prismicValue  = getValueOfAttribute($prismicTags, $fieldName, $fieldValue);
    $censhareValue = getValueOfAttribute($censhareTags, $fieldName, $fieldValue);

    if ($prismicValue !== $censhareValue) {
        logText("Meta $fieldValue does not match! Prismic '$prismicValue' / Censhare '$censhareValue'");
    } else {
        logText("Meta $fieldValue is alright.");
    }
}

function getTagValue(DOMNodeList $tags, $tagName)
{
    foreach ($tags as $tag) {
        /** @var DOMElement $tag */
        if ($tag->tagName === $tagName) {
            return $tag->nodeValue;
        }
    }

    return null;
}

function getValueOfAttribute(DOMNodeList $tags, $attributeName, $attributeValue)
{
    foreach ($tags as $tag) {
        /** @var DOMElement $tag */
        if (containsAttribute($tag, $attributeName, $attributeValue)) {
            return getContentAttributeValue($tag);
        }
    }

    return null;
}

function getContentAttributeValue(DOMElement $tag)
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

/**
 * @param DOMDocument $prismicDoc
 * @param DOMDocument $censhareDoc
 */
function checkAllMetaData(DOMDocument $prismicDoc, DOMDocument $censhareDoc)
{
    logText('Check metadata...');
    checkTag(
        $prismicDoc->getElementsByTagName('meta'),
        $censhareDoc->getElementsByTagName('meta'),
        'title'
    );
    checkMetaData(
        $prismicDoc->getElementsByTagName('meta'),
        $censhareDoc->getElementsByTagName('meta'),
        'name',
        'description'
    );
    checkMetaData(
        $prismicDoc->getElementsByTagName('meta'),
        $censhareDoc->getElementsByTagName('meta'),
        'property',
        'og:title'
    );
    checkMetaData(
        $prismicDoc->getElementsByTagName('meta'),
        $censhareDoc->getElementsByTagName('meta'),
        'property',
        'og:description'
    );
}

function checkTag(DOMNodeList $prismicTags, DOMNodeList $censhareTags, $tagName)
{
    $prismicValue  = getTagValue($prismicTags, $tagName);
    $censhareValue = getTagValue($censhareTags, $tagName);

    if ($prismicValue !== $censhareValue) {
        logText("Tag '<$tagName>' does not match! Prismic '$prismicValue' / Censhare '$censhareValue'");
    } else {
        logText("Tag '<$tagName>' is alright.");
    }
}
