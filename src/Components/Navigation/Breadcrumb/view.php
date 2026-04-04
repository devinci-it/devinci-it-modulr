<?php

if (!function_exists('renderIcon')) {
    function renderIcon($item)
    {
        if (empty($item['icon'])) return '';

        return '<span class="modulr-breadcrumb__icon" aria-hidden="true">'
            . $item['icon'] .
            '</span>';
    }
}

if (!function_exists('renderContent')) {
    function renderContent($item, $label)
    {
        $isLink = !empty($item['href']) && empty($item['disabled']) && empty($item['current']);

        if ($isLink) {
            return '<a href="' . htmlspecialchars($item['href']) . '" class="modulr-breadcrumb__link">'
                . $label .
                '</a>';
        }

        $attrs = '';

        if (!empty($item['current'])) {
            $attrs .= ' aria-current="page"';
        }

        if (!empty($item['disabled'])) {
            $attrs .= ' aria-disabled="true"';
        }

        return '<span class="modulr-breadcrumb__text"' . $attrs . '>'
            . $label .
            '</span>';
    }
}

if (!function_exists('renderSeparator')) {
    function renderSeparator($isLast, $separator)
    {
        if ($isLast) return '';

        return '<span class="modulr-breadcrumb__separator" aria-hidden="true">'
            . htmlspecialchars($separator) .
            '</span>';
    }
}

if (!function_exists('renderToggle')) {
    function renderToggle($isLast, $separator)
    {
        $html = '
            <li class="modulr-breadcrumb__item modulr-breadcrumb__item--toggle modulr-breadcrumb__item--ellipsis">
                <button type="button" class="modulr-breadcrumb__toggle" aria-label="Expand breadcrumb" aria-expanded="false">
                    ...
                </button>
            </li>';

        if (!$isLast) {
            $html .= '<span class="modulr-breadcrumb__separator" aria-hidden="true">'
                . htmlspecialchars($separator) .
                '</span>';
        }

        return $html;
    }
}

?>
<nav class="modulr-breadcrumb" aria-label="Breadcrumb">
    <ol class="modulr-breadcrumb__list">

        <?php
        $total = count($items);

        foreach ($items as $index => $item):

            $isLast = $index === $total - 1;

            if (!empty($item['toggle'])) {
                echo renderToggle($isLast, $separator);
                continue;
            }

            $classes = ['modulr-breadcrumb__item'];

            if (!empty($item['current'])) {
                $classes[] = 'modulr-breadcrumb__item--current';
            }

            if (!empty($item['disabled'])) {
                $classes[] = 'modulr-breadcrumb__item--disabled';
            }

            if (!empty($item['hidden'])) {
                $classes[] = 'modulr-breadcrumb__item--hidden';
            }

            $label = htmlspecialchars($item['label']);
        ?>

            <li class="<?= implode(' ', $classes) ?>">

                <?= renderIcon($item) ?>
                <?= renderContent($item, $label) ?>
                <?= renderSeparator($isLast, $separator) ?>

            </li>

        <?php endforeach; ?>

    </ol>
</nav>