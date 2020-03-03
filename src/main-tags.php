<?php

use PHPHtmlParser\Dom;

function checkMainTags(Dom $prismicDom, Dom $censhareDom)
{
    logText('Check main tags...');

    checkUrlTags($prismicDom, $censhareDom, '.tag.tag--with-icon .inspiration-article__tags-link', 'Destination');
    checkUrlTags($prismicDom, $censhareDom, '.tag .inspiration-article__tags-link', 'Thematic', 1);
}

