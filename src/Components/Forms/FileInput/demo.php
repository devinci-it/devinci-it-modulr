<?php

use DevinciIT\Modulr\Components\Forms\FileInput\FileInput;

showDemo(
	'FileInput MIME Variants',
	'Show the MIME presets and how to override accept lists fluently.',
	<<<'CODE'
echo FileInput::make()
	->setName('profile_image')
	->setLabel('Profile Image')
	->setAllowedMimeVariant('image')
	->setHelperText('Images only')
	->render();

echo FileInput::make()
	->setName('media_assets')
	->setLabel('Media Assets')
	->setAllowedMimeVariant('media')
	->setMultiple(true)
	->render();

echo FileInput::make()
	->setName('contract_files')
	->setLabel('Contract Files')
	->setAllowedMimeVariant('document')
	->render();

echo FileInput::make()
	->setName('spreadsheet')
	->setLabel('Spreadsheet Upload')
	->setAllowedMimeVariant('spreadsheet')
	->render();
CODE,
	function () {
		echo '<div style="display:grid;gap:14px;">';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Image Preset</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Accept only image files using the image MIME variant.</p>';

		echo FileInput::make()
			->setName('profile_image')
			->setLabel('Profile Image')
			->setAllowedMimeVariant('image')
			->setHelperText('Images only')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Media Preset</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Allow images, video, and audio in a single multi-file control.</p>';

		echo FileInput::make()
			->setName('media_assets')
			->setLabel('Media Assets')
			->setAllowedMimeVariant('media')
			->setMultiple(true)
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Document Preset</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Accept office and text-document style uploads.</p>';

		echo FileInput::make()
			->setName('contract_files')
			->setLabel('Contract Files')
			->setAllowedMimeVariant('document')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Spreadsheet Preset</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Use a dedicated preset for CSV and spreadsheet formats.</p>';

		echo FileInput::make()
			->setName('spreadsheet')
			->setLabel('Spreadsheet Upload')
			->setAllowedMimeVariant('spreadsheet')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Archive Preset</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Restrict selection to archive bundles.</p>';

		echo FileInput::make()
			->setName('archive_bundle')
			->setLabel('Archive Bundle')
			->setAllowedMimeVariant('archive')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Custom Accept Override</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Override presets with exact MIME and extension tokens.</p>';

		echo FileInput::make()
			->setName('custom_accept')
			->setLabel('Custom MIME Override')
			->setAllowedMimeVariant('media')
			->setAccept(['image/webp', 'application/pdf'])
			->setHelperText('Custom accept overrides preset variant.')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Dynamic Attachment Rows</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Allow users to add and remove rows while previewing selected files.</p>';

		echo FileInput::make()
			->setName('attachments')
			->setLabel('Add Multiple Attachments')
			->setAllowedMimeVariant('any')
			->setDynamicInputAddition(true)
			->setShowPreview(true)
			->setPreviewPlaceholder('Select a file to preview')
			->setAddButtonLabel('Add Attachment')
			->setRemoveButtonLabel('Delete')
			->render();

		echo '</section>';

		echo '</div>';
	}
);

showDemo(
	'FileInput Features',
	'Multifile selection, preview, selected file lists, row addition, deletion, and drag-drop support.',
	<<<'CODE'
echo FileInput::make()
	->setName('avatar_preview')
	->setLabel('Avatar With Preview')
	->setAllowedMimeVariant('image')
	->setShowPreview(true)
	->setPreviewPlaceholder('Choose an image to preview')
	->render();

echo FileInput::make()
	->setName('dropzone_gallery')
	->setLabel('Gallery Upload (Dropzone + Multi)')
	->setAllowedMimeVariant('image')
	->setMultiple(true)
	->setShowPreview(true)
	->setShowSelectedFiles(true)
	->setEnableDropzone(true)
	->setDropzoneText('Drop images here or click to select')
	->setSelectedFilesTitle('Images queued for upload')
	->render();

echo FileInput::make()
	->setName('attachment_rows')
	->setLabel('Attachments (Add Rows + Delete)')
	->setAllowedMimeVariant('any')
	->setDynamicInputAddition(true)
	->setShowSelectedFiles(true)
	->setShowPreview(true)
	->setEnableDropzone(true)
	->setAddButtonLabel('Add Attachment Row')
	->setRemoveButtonLabel('Remove Row')
	->render();
CODE,
	function () {
		echo '<div style="display:grid;gap:14px;">';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Single Preview</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Display a live preview area for single-image uploads.</p>';

		echo FileInput::make()
			->setName('avatar_preview')
			->setLabel('Avatar With Preview')
			->setAllowedMimeVariant('image')
			->setShowPreview(true)
			->setPreviewPlaceholder('Choose an image to preview')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Dropzone + Multi-file</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Combine drag-and-drop, selected-file listing, and image previews.</p>';

		echo FileInput::make()
			->setName('dropzone_gallery')
			->setLabel('Gallery Upload (Dropzone + Multi)')
			->setAllowedMimeVariant('image')
			->setMultiple(true)
			->setShowPreview(true)
			->setShowSelectedFiles(true)
			->setEnableDropzone(true)
			->setDropzoneText('Drop images here or click to select')
			->setSelectedFilesTitle('Images queued for upload')
			->render();

		echo '</section>';

		echo '<section class="demo-preview" style="padding:12px; border:1px solid #ddd; border-radius:6px;">';
		echo '<h4 style="margin:0 0 4px;">Add/Remove Attachment Rows</h4>';
		echo '<p style="margin:0 0 10px; font-size:13px; color:#6b7280;">Use dynamic rows with dropzone and previews for flexible attachment flows.</p>';

		echo FileInput::make()
			->setName('attachment_rows')
			->setLabel('Attachments (Add Rows + Delete)')
			->setAllowedMimeVariant('any')
			->setDynamicInputAddition(true)
			->setShowSelectedFiles(true)
			->setShowPreview(true)
			->setEnableDropzone(true)
			->setAddButtonLabel('Add Attachment Row')
			->setRemoveButtonLabel('Remove Row')
			->render();

		echo '</section>';

		echo '</div>';
	}
);