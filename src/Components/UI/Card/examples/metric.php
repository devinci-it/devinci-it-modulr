<?php
$metricLabel = isset($metricLabel) ? (string) $metricLabel : 'Metric';
$metricValue = isset($metricValue) ? (string) $metricValue : '0';
$metricDelta = isset($metricDelta) ? (string) $metricDelta : '';
?>
<div style="display:grid; gap:8px;">
    <strong style="font-size:13px; color:#334155;"><?= htmlspecialchars($metricLabel, ENT_QUOTES, 'UTF-8') ?></strong>
    <span style="font-size:28px; font-weight:700; line-height:1;"><?= htmlspecialchars($metricValue, ENT_QUOTES, 'UTF-8') ?></span>
    <?php if ($metricDelta !== ''): ?>
        <span style="font-size:12px; color:#0f766e;"><?= htmlspecialchars($metricDelta, ENT_QUOTES, 'UTF-8') ?></span>
    <?php endif; ?>
</div>
