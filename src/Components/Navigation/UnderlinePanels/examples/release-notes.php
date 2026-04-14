<article>
    <h4 style="margin-top: 0;">Release Notes</h4>
    <p style="margin: 0 0 10px; color: #475569;">Highlights for <?= htmlspecialchars((string) ($version ?? 'latest'), ENT_QUOTES, 'UTF-8') ?>.</p>
    <ul style="margin: 0; padding-left: 20px; display: grid; gap: 4px;">
        <?php foreach (($items ?? []) as $item): ?>
            <li><?= htmlspecialchars((string) $item, ENT_QUOTES, 'UTF-8') ?></li>
        <?php endforeach; ?>
    </ul>
</article>
