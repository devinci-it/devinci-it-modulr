<?php

use DevinciIT\Modulr\Components\Feedback\Modal\Modal;

showDemo(
    'Modal Alert',
    'Simple alert modal with only body and one action button.',
    <<<'CODE'
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-alert">Open Alert</button>';

echo Modal::make()
    ->setId('modal-alert')
    ->setMode('alert')
    ->setTone('info')
    ->setBody('Your profile was saved successfully.')
    ->setCloseLabel('Got it')
    ->render();
CODE,
    function () {
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-alert">Open Alert</button>';

        echo Modal::make()
            ->setId('modal-alert')
            ->setMode('alert')
            ->setTone('info')
            ->setBody('Your profile was saved successfully.')
            ->setCloseLabel('Got it')
            ->render();
    }
);

showDemo(
    'Modal Confirm Only',
    'Confirm modal with a header slot, body slot, and one confirm action.',
    <<<'CODE'
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-confirm">Open Confirm</button>';

echo Modal::make()
    ->setId('modal-confirm')
    ->setMode('confirm')
    ->setTone('warning')
    ->setHeader('Publish Changes')
    ->setBody('Publishing will push your edits to production immediately.')
    ->setConfirmLabel('Publish now')
    ->render();
CODE,
    function () {
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-confirm">Open Confirm</button>';

        echo Modal::make()
            ->setId('modal-confirm')
            ->setMode('confirm')
            ->setTone('warning')
            ->setHeader('Publish Changes')
            ->setBody('Publishing will push your edits to production immediately.')
            ->setConfirmLabel('Publish now')
            ->render();
    }
);

showDemo(
    'Modal Confirm + Cancel',
    'Confirm/cancel modal with explicit footer actions.',
    <<<'CODE'
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-confirm-cancel">Open Confirm + Cancel</button>';

echo Modal::make()
    ->setId('modal-confirm-cancel')
    ->setMode('confirm-cancel')
    ->setTone('error')
    ->setHeader('Delete Project')
    ->setBody('This will permanently remove this project and all records.')
    ->setConfirmLabel('Delete')
    ->setCancelLabel('Cancel')
    ->setActions([
        ['label' => 'Cancel', 'variant' => 'secondary', 'action' => 'cancel', 'dismiss' => true],
        ['label' => 'Delete', 'variant' => 'danger', 'action' => 'confirm', 'dismiss' => true],
    ])
    ->render();
CODE,
    function () {
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-confirm-cancel">Open Confirm + Cancel</button>';

        echo Modal::make()
            ->setId('modal-confirm-cancel')
            ->setMode('confirm-cancel')
            ->setTone('error')
            ->setHeader('Delete Project')
            ->setBody('This will permanently remove this project and all records.')
            ->setConfirmLabel('Delete')
            ->setCancelLabel('Cancel')
            ->setActions([
                ['label' => 'Cancel', 'variant' => 'secondary', 'action' => 'cancel', 'dismiss' => true],
                ['label' => 'Delete', 'variant' => 'danger', 'action' => 'confirm', 'dismiss' => true],
            ])
            ->render();
    }
);

showDemo(
    'Modal Header / Body / Footer Slots',
    'Custom footer slot content and body HTML allowed.',
    <<<'CODE'
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-slots">Open Slot Modal</button>';

echo Modal::make()
    ->setId('modal-slots')
    ->setTone('alert')
    ->setHeader('Security Notice')
    ->setBody('<p>Rotate your API tokens every 90 days for better security posture.</p>')
    ->setFooter('<button type="button" class="modulr-modal__action modulr-modal__action--ghost" data-modal-close="action">Later</button> <button type="button" class="modulr-modal__action modulr-modal__action--primary" data-modal-close="action">Rotate Tokens</button>')
    ->allowHtml(true)
    ->render();
CODE,
    function () {
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-slots">Open Slot Modal</button>';

        echo Modal::make()
            ->setId('modal-slots')
            ->setTone('alert')
            ->setHeader('Security Notice')
            ->setBody('<p>Rotate your API tokens every 90 days for better security posture.</p>')
            ->setFooter('<button type="button" class="modulr-modal__action modulr-modal__action--ghost" data-modal-close="action">Later</button> <button type="button" class="modulr-modal__action modulr-modal__action--primary" data-modal-close="action">Rotate Tokens</button>')
            ->allowHtml(true)
            ->render();
    }
);

showDemo(
    'Modal Tone Variants',
    'Quick preview of info, warning, error, alert, and success modal variants.',
    <<<'CODE'
echo '<div style="display:flex;flex-wrap:wrap;gap:8px;">';
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-info">Info</button>';
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-warning">Warning</button>';
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-error">Error</button>';
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-alert">Alert</button>';
echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-success">Success</button>';
echo '</div>';

echo Modal::make()->setId('modal-variant-info')->setTone('info')->setHeader('Info')->setBody('Informational modal variant.')->render();
echo Modal::make()->setId('modal-variant-warning')->setTone('warning')->setHeader('Warning')->setBody('Warning modal variant.')->render();
echo Modal::make()->setId('modal-variant-error')->setTone('error')->setHeader('Error')->setBody('Error modal variant.')->render();
echo Modal::make()->setId('modal-variant-alert')->setTone('alert')->setHeader('Alert')->setBody('Alert modal variant.')->render();
echo Modal::make()->setId('modal-variant-success')->setTone('success')->setHeader('Success')->setBody('Success modal variant.')->render();
CODE,
    function () {
        echo '<div style="display:flex;flex-wrap:wrap;gap:8px;">';
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-info">Info</button>';
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-warning">Warning</button>';
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-error">Error</button>';
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-alert">Alert</button>';
        echo '<button class="modulr-modal-trigger" data-modal-target="#modal-variant-success">Success</button>';
        echo '</div>';

        echo Modal::make()
            ->setId('modal-variant-info')
            ->setTone('info')
            ->setHeader('Info')
            ->setBody('Informational modal variant.')
            ->render();

        echo Modal::make()
            ->setId('modal-variant-warning')
            ->setTone('warning')
            ->setHeader('Warning')
            ->setBody('Warning modal variant.')
            ->render();

        echo Modal::make()
            ->setId('modal-variant-error')
            ->setTone('error')
            ->setHeader('Error')
            ->setBody('Error modal variant.')
            ->render();

        echo Modal::make()
            ->setId('modal-variant-alert')
            ->setTone('alert')
            ->setHeader('Alert')
            ->setBody('Alert modal variant.')
            ->render();

        echo Modal::make()
            ->setId('modal-variant-success')
            ->setTone('success')
            ->setHeader('Success')
            ->setBody('Success modal variant.')
            ->render();
    }
);
