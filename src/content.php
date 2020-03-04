<?php

use PHPHtmlParser\Dom;

function checkContent(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('Check content');
    checkRichTextModules($prismicDom, $censhareDom);
    checkOfferModules($prismicDom, $censhareDom);
    checkMediaModules($prismicDom, $censhareDom);
}

function checkRichTextModules(Dom $prismicDom, Dom $censhareDom)
{
    checkRichTextModuleTag($prismicDom, $censhareDom, 'h2');
    checkRichTextModuleTag($prismicDom, $censhareDom, 'h3');
    checkRichTextModuleTag($prismicDom, $censhareDom, 'h4');
    checkRichTextModuleTag($prismicDom, $censhareDom, 'h5');
    checkRichTextModuleTag($prismicDom, $censhareDom, 'h6');
    checkRichTextModuleTag($prismicDom, $censhareDom, 'p');
    checkRichTextModuleTag($prismicDom, $censhareDom, 'li');
}

function checkRichTextModuleTag(Dom $prismicDom, Dom $censhareDom, $tagName)
{
    $prismicModules  = $prismicDom->find('.content-module.content-module-rich-text ' . $tagName);
    $censhareModules = $censhareDom->find('.content-module.content-module-rich-text ' . $tagName);

    $totalPrismicModules  = count($prismicModules);
    $totalCenshareModules = count($censhareModules);
    if ($totalPrismicModules !== $totalCenshareModules) {
        logError(
            "Total &lt;$tagName&gt; tags does not match : $totalPrismicModules in Prismic // $totalCenshareModules in Censhare"
        );

        return false;
    }

    if ($totalPrismicModules === 0) {
        return true;
    }

    logSuccess("Total &lt;$tagName&gt; tags match : $totalPrismicModules");

    $error = false;
    for ($position = 0; $position < $totalPrismicModules; $position++) {
        $prismicTag  = cleanHtmlTag($prismicModules[$position]->innerHtml());
        $censhareTag = cleanHtmlTag($censhareModules[$position]->innerHtml());

        if ($prismicTag !== $censhareTag) {
            logError(
                "&lt;$tagName&gt; does not match!",
                $prismicTag,
                $censhareTag
            );
            $error = true;
        }
    }

    if (!$error) {
        logSuccess("All &lt;$tagName&gt; match!");

        return true;
    }

    return false;
}

function cleanHtmlTag(string $htmlContent): string
{
    $htmlContent = str_replace('&nbsp;', ' ', $htmlContent);
    $htmlContent = str_replace(['  ', ' <', 'target="_blank"', 'rel="noopener"'], [' ', '<', '', ''], $htmlContent);
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
