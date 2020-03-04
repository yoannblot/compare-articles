<?php

use PHPHtmlParser\Dom;

define('ROOT_PATH', __DIR__ . '/');

require_once ROOT_PATH . 'vendor/autoload.php';
require_once 'src/functions.php';

$prismicUrl  = $_GET['prismic'] ?? null;
$censhareUrl = $_GET['censhare'] ?? null;
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/styles.css" type="text/css" charset="utf-8"/>
</head>
<body>
<h1>Compare Prismic and Censhare URLs</h1>
<?php
require_once 'front/form.php';

if ($prismicUrl === null || $censhareUrl === null) {
    logError('Fill URLs in form');
    exit;
}

$prismicContent  = getHtmlContent($prismicUrl);
$censhareContent = getHtmlContent($censhareUrl);

$prismicDom = new Dom();
$prismicDom->loadStr($prismicContent, []);

$censhareDom = new Dom();
$censhareDom->loadStr($censhareContent, []);

checkAllMetaData($prismicDom, $censhareDom);
checkBreadcrumb($prismicDom, $censhareDom);
checkMainTags($prismicDom, $censhareDom);
checkHeader($prismicDom, $censhareDom);
checkContent($prismicDom, $censhareDom);
?>
</body>
</html>
