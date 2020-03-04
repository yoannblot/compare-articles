<?php

use PHPHtmlParser\Dom;

function checkBreadcrumb(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('Check breadcrumb');
    checkUrlTags($prismicDom, $censhareDom, '.breadcrumb-item__link', 'Rubric', 1);
    checkUrlTags($prismicDom, $censhareDom, '.breadcrumb-item__link', 'Article', 2);
}
