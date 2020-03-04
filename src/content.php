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
    checkHtmlTag($prismicDom, $censhareDom, 'p');
    checkHtmlTag($prismicDom, $censhareDom, 'h2');
    checkHtmlTag($prismicDom, $censhareDom, 'h3');
}

function checkHtmlTag(Dom $prismicDom, Dom $censhareDom, $tagName)
{
    $prismicModules  = $prismicDom->find('.content-module.content-module-rich-text > ' . $tagName);
    $censhareModules = $censhareDom->find('.content-module.content-module-rich-text > ' . $tagName);

    $totalPrismicModules  = count($prismicModules);
    $totalCenshareModules = count($censhareModules);
    if ($totalPrismicModules !== $totalCenshareModules) {
        logError(
            "Total <$tagName> HTML modules does not match : $totalPrismicModules in Prismic // $totalCenshareModules in Censhare"
        );

        return false;
    }

    logSuccess("Total <$tagName> HTML modules match : $totalPrismicModules");

    $error = false;
    for ($position = 0; $position < $totalPrismicModules; $position++) {
        $prismicParagrap  = cleanHtmlTag($prismicModules[$position]->innerHtml());
        $censhareParagrap = cleanHtmlTag($censhareModules[$position]->innerHtml());

        if ($prismicParagrap !== $censhareParagrap) {
            // TODO find a way to display diff between sentences
            logError(
                "<$tagName> does not match : " . PHP_EOL . ">>$prismicParagrap<<" . PHP_EOL . ">>$censhareParagrap<<"
            );
            $error = true;
        }
    }

    if (!$error) {
        logSuccess("All <$tagName> match!");

        return true;
    }

    return false;
}

function cleanHtmlTag(string $htmlContent): string
{
    $htmlContent = str_replace('&nbsp;', ' ', $htmlContent);
    $htmlContent = str_replace(['  ', ' <'], [' ', '<'], $htmlContent);
    $htmlContent = trim(html_entity_decode($htmlContent));

    return $htmlContent;
}

function checkOfferModules(Dom $prismicDom, Dom $censhareDom)
{
    // TODO
}

function checkMediaModules(Dom $prismicDom, Dom $censhareDom)
{
    // TODO
}
