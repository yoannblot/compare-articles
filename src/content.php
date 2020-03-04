<?php

use PHPHtmlParser\Dom;

function checkContent(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('Check content');
    checkHtmlModules($prismicDom, $censhareDom);
    checkOfferModules($prismicDom, $censhareDom);
    checkMediaModules($prismicDom, $censhareDom);
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
