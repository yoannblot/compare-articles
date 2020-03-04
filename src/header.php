<?php

use PHPHtmlParser\Dom;

function checkHeader(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('..................');
    logInfo('...Check header...');
    logInfo('..................');
    checkTagBySelector($prismicDom, $censhareDom, 'h1');
    checkTagBySelector($prismicDom, $censhareDom, 'p.publish-information', true);
    checkTagBySelector($prismicDom, $censhareDom, '.inspiration-article__introduction.col-md-8', true);
    logInfo('..................');
    logInfo('.......Done.......');
}
