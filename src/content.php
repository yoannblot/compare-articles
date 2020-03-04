<?php

use PHPHtmlParser\Dom;

function checkContent(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('..................');
    logInfo('...Check content...');
    logInfo('..................');
    checkHtmlModules($prismicDom, $censhareDom);
    checkOfferModules($prismicDom, $censhareDom);
    checkMediaModules($prismicDom, $censhareDom);
    logInfo('..................');
    logInfo('.......Done.......');
}

function checkHtmlModules(Dom $prismicDom, Dom $censhareDom)
{
    // TODO
}

function checkOfferModules(Dom $prismicDom, Dom $censhareDom)
{
    // TODO
}

function checkMediaModules(Dom $prismicDom, Dom $censhareDom)
{
    // TODO
}
