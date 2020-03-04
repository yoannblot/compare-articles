<?php

use PHPHtmlParser\Dom;

function checkBreadcrumb(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('..................');
    logInfo('...Check breadcrumb...');
    logInfo('..................');
    checkUrlTags($prismicDom, $censhareDom, '.breadcrumb-item__link', 'Rubric', 1);
    checkUrlTags($prismicDom, $censhareDom, '.breadcrumb-item__link', 'Article', 2);
    logInfo('..................');
    logInfo('.......Done.......');
}
