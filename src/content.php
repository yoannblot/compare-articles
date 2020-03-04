<?php

use PHPHtmlParser\Dom;

function checkContent(Dom $prismicDom, Dom $censhareDom)
{
    logInfo('Check content');
    checkRichTextModules($prismicDom, $censhareDom);
    checkEditoCardModules($prismicDom, $censhareDom);
    checkAgencyCardModules($prismicDom, $censhareDom);
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
            "Total &lt;$tagName&gt; tags does not match!",
            $totalPrismicModules,
            $totalCenshareModules
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

function checkAgencyCardModules(Dom $prismicDom, Dom $censhareDom)
{
    $prismicModules  = $prismicDom->find('.content-module-agency-cards.content-module');
    $censhareModules = $censhareDom->find('.content-module-agency-cards.content-module');

    $totalPrismicModules  = count($prismicModules);
    $totalCenshareModules = count($censhareModules);
    if ($totalPrismicModules !== $totalCenshareModules) {
        logError(
            'Total AgencyCard module does not match!',
            $totalPrismicModules,
            $totalCenshareModules
        );

        return false;
    }

    if ($totalPrismicModules === 0) {
        return true;
    }

    logSuccess("Total AgencyCard module match : $totalPrismicModules");

    for ($position = 0; $position < $totalPrismicModules; $position++) {
        checkUrlTags(
            $prismicModules[$position],
            $censhareModules[$position],
            '.large-agency-card__title',
            'Agency link'
        );
    }
}

function checkEditoCardModules(Dom $prismicDom, Dom $censhareDom)
{
    $prismicModules  = $prismicDom->find('.content-module-edito-cards.content-module');
    $censhareModules = $censhareDom->find('.content-module-edito-cards.content-module');

    $totalPrismicModules  = count($prismicModules);
    $totalCenshareModules = count($censhareModules);
    if ($totalPrismicModules !== $totalCenshareModules) {
        logError(
            'Total EditoCard module does not match!',
            $totalPrismicModules,
            $totalCenshareModules
        );

        return false;
    }

    if ($totalPrismicModules === 0) {
        return true;
    }

    logSuccess("Total EditoCard module match : $totalPrismicModules");

    $error = false;
    for ($position = 0; $position < $totalPrismicModules; $position++) {
        // TODO check title
        // TODO check url
        // TODO check description
        // TODO check alt image text

        $prismicModule  = cleanHtmlTag($prismicModules[$position]->innerHtml());
        $censhareModule = cleanHtmlTag($censhareModules[$position]->innerHtml());

        if ($prismicModule !== $censhareModule) {
            logError(
                "EditoCard module does not match!",
                $prismicModule,
                $censhareModule
            );
            $error = true;
        }
    }

    if (!$error) {
        logSuccess("All EditoCard modules match!");

        return true;
    }

    return false;
}

function checkMediaModules(Dom $prismicDom, Dom $censhareDom)
{
    // TODO
}
