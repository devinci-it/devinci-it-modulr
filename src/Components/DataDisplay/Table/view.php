<?php
/**
 * Table component view template.
 *
 * @var array $headers
 * @var array $rows
 * @var string $style
 * @var string $script
 * @var string $config
 *
 * Convention:
 * - Table root: class="modulr-table" id="modulr-table"
 * - Table rows: class="modulr-table-row"
 * - Table cells: class="modulr-table-cell"
 *
 * Developers can override style/script/config by passing custom paths to the Table constructor.
 */
?>
<table class="modulr-table" id="modulr-table" data-component="table">
    <?php if (!empty($headers)): ?>
        <thead>
        <tr>
            <?php foreach ($headers as $header): ?>
                <th><?= htmlspecialchars($header) ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>
    <?php endif; ?>
    <?php if (!empty($rows)): ?>
        <tbody>
        <?php foreach ($rows as $row): ?>
            <tr class="modulr-table-row">
                <?php foreach ($row as $cell): ?>
                    <td class="modulr-table-cell"><?= htmlspecialchars($cell) ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </tbody>
    <?php endif; ?>
</table>
