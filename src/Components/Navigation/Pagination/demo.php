<?php

use DevinciIT\Modulr\Components\Navigation\Pagination\Pagination;

$iframeName = 'modulr-pagination-preview';
$previewBaseUrl = '/pagination-preview.php?collection=orders&variant=default';
$activePage = isset($_GET['page']) ? max(1, min(18, (int) $_GET['page'])) : 4;
$compactIframeName = 'modulr-pagination-compact-preview';
$compactPreviewBaseUrl = '/pagination-preview.php?collection=products&variant=ghost';
$compactPage = max(1, min(7, $activePage));

showDemo(
    'Pagination URL Navigation',
    'Pagination should navigate by URL. In this demo, links target an iframe so the main demo page does not navigate away.',
    <<<'CODE'
$iframeName = 'modulr-pagination-preview';
$previewBaseUrl = '/demo/pagination-preview.php?collection=orders&variant=default';
$activePage = isset($_GET['page']) ? max(1, min(18, (int) $_GET['page'])) : 4;

echo Pagination::make()
    ->setCurrentPage($activePage)
    ->setTotalPages(18)
    ->setWindow(1)
    ->setSize('lg')
    ->setBaseUrl($previewBaseUrl)
    ->setTarget($iframeName)
    ->setAriaLabel('Orders pagination')
    ->render();

echo '<iframe name="' . $iframeName . '" src="' . $previewBaseUrl . '&page=' . $activePage . '" style="width:100%;height:190px;border:1px solid #e5e7eb;border-radius:10px;margin-top:12px;background:#fff;"></iframe>';
CODE,
    function () use ($iframeName, $previewBaseUrl, $activePage) {
        echo Pagination::make()
            ->setCurrentPage($activePage)
            ->setTotalPages(18)
            ->setWindow(1)
            ->setSize('lg')
            ->setBaseUrl($previewBaseUrl)
            ->setTarget($iframeName)
            ->setAriaLabel('Orders pagination')
            ->render();

        echo '<iframe name="' . htmlspecialchars($iframeName, ENT_QUOTES, 'UTF-8') . '" src="' . htmlspecialchars($previewBaseUrl . '&page=' . $activePage, ENT_QUOTES, 'UTF-8') . '" title="Pagination preview" style="width:100%;height:190px;border:1px solid #e5e7eb;border-radius:10px;margin-top:12px;background:#fff;"></iframe>';
    }
);

showDemo(
    'Pagination Compact',
    'A compact version without first/last controls still navigates by URL.',
    <<<'CODE'
$compactIframeName = 'modulr-pagination-compact-preview';
$compactPreviewBaseUrl = '/demo/pagination-preview.php?collection=products&variant=ghost';
$compactPage = isset($_GET['page']) ? max(1, min(7, (int) $_GET['page'])) : 2;

echo Pagination::make()
    ->setCurrentPage($compactPage)
    ->setTotalPages(7)
    ->setWindow(1)
    ->setShowFirstLast(false)
    ->setSize('sm')
    ->setVariant('ghost')
    ->setBaseUrl($compactPreviewBaseUrl)
    ->setTarget($compactIframeName)
    ->setAriaLabel('Products pagination')
    ->render();

echo '<iframe name="' . $compactIframeName . '" src="' . $compactPreviewBaseUrl . '&page=' . $compactPage . '" style="width:100%;height:190px;border:1px solid #e5e7eb;border-radius:10px;margin-top:12px;background:#fff;"></iframe>';
CODE,
    function () {
        $compactPage = isset($_GET['page']) ? max(1, min(7, (int) $_GET['page'])) : 2;
        $compactIframeName = 'modulr-pagination-compact-preview';
        $compactPreviewBaseUrl = '/pagination-preview.php?collection=products&variant=ghost';

        echo Pagination::make()
            ->setCurrentPage($compactPage)
            ->setTotalPages(7)
            ->setWindow(1)
            ->setShowFirstLast(false)
            ->setSize('sm')
            ->setVariant('ghost')
            ->setBaseUrl($compactPreviewBaseUrl)
            ->setTarget($compactIframeName)
            ->setAriaLabel('Products pagination')
            ->render();

        echo '<iframe name="' . htmlspecialchars($compactIframeName, ENT_QUOTES, 'UTF-8') . '" src="' . htmlspecialchars($compactPreviewBaseUrl . '&page=' . $compactPage, ENT_QUOTES, 'UTF-8') . '" title="Compact pagination preview" style="width:100%;height:190px;border:1px solid #e5e7eb;border-radius:10px;margin-top:12px;background:#fff;"></iframe>';
    }
);

showDemo(
    'Pagination Boundary',
    'A short collection ending at page 3 does not show page 4 once you are on the last page.',
    <<<'CODE'
$boundaryIframeName = 'modulr-pagination-boundary-preview';
$boundaryPreviewBaseUrl = '/demo/pagination-preview.php?collection=short&variant=default&totalItems=15&perPage=5';
$boundaryPage = isset($_GET['page']) ? max(1, min(3, (int) $_GET['page'])) : 3;

echo Pagination::make()
    ->setCurrentPage($boundaryPage)
    ->setTotalPages(3)
    ->setWindow(1)
    ->setSize('md')
    ->setBaseUrl($boundaryPreviewBaseUrl)
    ->setTarget($boundaryIframeName)
    ->setAriaLabel('Short collection pagination')
    ->render();

echo '<iframe name="' . $boundaryIframeName . '" src="' . $boundaryPreviewBaseUrl . '&page=' . $boundaryPage . '" style="width:100%;height:190px;border:1px solid #e5e7eb;border-radius:10px;margin-top:12px;background:#fff;"></iframe>';
CODE,
    function () {
        $boundaryIframeName = 'modulr-pagination-boundary-preview';
        $boundaryPreviewBaseUrl = '/demo/pagination-preview.php?collection=short&variant=default&totalItems=15&perPage=5';
        $boundaryPage = isset($_GET['page']) ? max(1, min(3, (int) $_GET['page'])) : 3;

        echo Pagination::make()
            ->setCurrentPage($boundaryPage)
            ->setTotalPages(3)
            ->setWindow(1)
            ->setSize('md')
            ->setBaseUrl($boundaryPreviewBaseUrl)
            ->setTarget($boundaryIframeName)
            ->setAriaLabel('Short collection pagination')
            ->render();

        echo '<iframe name="' . htmlspecialchars($boundaryIframeName, ENT_QUOTES, 'UTF-8') . '" src="' . htmlspecialchars($boundaryPreviewBaseUrl . '&page=' . $boundaryPage, ENT_QUOTES, 'UTF-8') . '" title="Boundary pagination preview" style="width:100%;height:190px;border:1px solid #e5e7eb;border-radius:10px;margin-top:12px;background:#fff;"></iframe>';
    }
);
