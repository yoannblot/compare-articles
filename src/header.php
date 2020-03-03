<?php

use PHPHtmlParser\Dom;

function checkHeader(Dom $prismicDom, Dom $censhareDom)
{
    logText('..................');
    logText('...Check header...');
    logText('..................');
    checkTagBySelector($prismicDom, $censhareDom, 'h1');
    checkTagBySelector($prismicDom, $censhareDom, 'p.publish-information', true);
    checkTagBySelector($prismicDom, $censhareDom, '.inspiration-article__introduction.col-md-8', true);
    logText('..................');
    logText('.......Done.......');
}
