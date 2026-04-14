<?php

namespace DevinciIT\Modulr\Components\Forms\FileInput;

use DevinciIT\Modulr\Components\ComponentsBase;

class FileInput extends ComponentsBase
{
    protected array $props = [
        'id' => null,
        'name' => 'file',
        'label' => 'Upload file',
        'required' => false,
        'disabled' => false,
        'multiple' => false,
        'acceptVariant' => 'any',
        'accept' => [],
        'helperText' => null,
        'dynamicInputAddition' => false,
        'addButtonLabel' => 'Add File',
        'removeButtonLabel' => 'Remove',
        'showPreview' => false,
        'previewPlaceholder' => 'No file selected',
        'showSelectedFiles' => true,
        'selectedFilesTitle' => 'Selected files',
        'enableDropzone' => false,
        'dropzoneText' => 'Drop files here or click to browse',
    ];

    protected array $acceptVariantMap = [
        'any' => [],
        'image' => ['image/*'],
        'video' => ['video/*'],
        'audio' => ['audio/*'],
        'media' => ['image/*', 'video/*', 'audio/*'],
        'document' => [
            'application/pdf',
            'text/plain',
            '.doc',
            '.docx',
            '.ppt',
            '.pptx',
            '.xls',
            '.xlsx',
        ],
        'pdf' => ['application/pdf'],
        'archive' => ['.zip', '.rar', '.7z', '.tar', '.gz'],
        'spreadsheet' => ['.csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'],
    ];

    public function __construct(array $options = [])
    {
        if (isset($options['id']) && is_scalar($options['id'])) {
            $this->setId((string) $options['id']);
        }

        if (isset($options['name']) && is_scalar($options['name'])) {
            $this->setName((string) $options['name']);
        }

        if (isset($options['label']) && is_scalar($options['label'])) {
            $this->setLabel((string) $options['label']);
        }

        if (isset($options['required'])) {
            $this->setRequired((bool) $options['required']);
        }

        if (isset($options['disabled'])) {
            $this->setDisabled((bool) $options['disabled']);
        }

        if (isset($options['multiple'])) {
            $this->setMultiple((bool) $options['multiple']);
        }

        if (isset($options['acceptVariant']) && is_scalar($options['acceptVariant'])) {
            $this->setAcceptVariant((string) $options['acceptVariant']);
        }

        if (isset($options['accept']) && (is_array($options['accept']) || is_string($options['accept']))) {
            $this->setAccept($options['accept']);
        }

        if (isset($options['helperText']) && is_scalar($options['helperText'])) {
            $this->setHelperText((string) $options['helperText']);
        }

        if (isset($options['dynamicInputAddition'])) {
            $this->setDynamicInputAddition((bool) $options['dynamicInputAddition']);
        }

        if (isset($options['addButtonLabel']) && is_scalar($options['addButtonLabel'])) {
            $this->setAddButtonLabel((string) $options['addButtonLabel']);
        }

        if (isset($options['removeButtonLabel']) && is_scalar($options['removeButtonLabel'])) {
            $this->setRemoveButtonLabel((string) $options['removeButtonLabel']);
        }

        if (isset($options['showPreview'])) {
            $this->setShowPreview((bool) $options['showPreview']);
        }

        if (isset($options['previewPlaceholder']) && is_scalar($options['previewPlaceholder'])) {
            $this->setPreviewPlaceholder((string) $options['previewPlaceholder']);
        }

        if (isset($options['showSelectedFiles'])) {
            $this->setShowSelectedFiles((bool) $options['showSelectedFiles']);
        }

        if (isset($options['selectedFilesTitle']) && is_scalar($options['selectedFilesTitle'])) {
            $this->setSelectedFilesTitle((string) $options['selectedFilesTitle']);
        }

        if (isset($options['enableDropzone'])) {
            $this->setEnableDropzone((bool) $options['enableDropzone']);
        }

        if (isset($options['dropzoneText']) && is_scalar($options['dropzoneText'])) {
            $this->setDropzoneText((string) $options['dropzoneText']);
        }

        if (isset($options['class']) && is_scalar($options['class'])) {
            $this->setClass((string) $options['class']);
        }
    }

    public static function make(array $options = []): static
    {
        return new static($options);
    }

    public function setId(string $id): static
    {
        parent::setId($id);
        $this->props['id'] = trim($id);
        return $this;
    }

    public function setName(string $name): static
    {
        $name = trim($name);
        if ($name === '') {
            throw new \InvalidArgumentException('File input name cannot be empty.');
        }

        $this->props['name'] = $name;
        return $this;
    }

    public function setLabel(string $label): static
    {
        $this->props['label'] = trim($label);
        return $this;
    }

    public function setRequired(bool $state = true): static
    {
        $this->props['required'] = $state;
        return $this;
    }

    public function setDisabled(bool $state = true): static
    {
        $this->props['disabled'] = $state;
        return $this;
    }

    public function setMultiple(bool $state = true): static
    {
        $this->props['multiple'] = $state;
        return $this;
    }

    /**
     * @param string|array<int, string> $accept
     */
    public function setAccept($accept): static
    {
        if (is_string($accept)) {
            $accept = array_filter(array_map('trim', explode(',', $accept)), static fn ($item) => $item !== '');
        }

        if (!is_array($accept)) {
            throw new \InvalidArgumentException('Accept list must be a string or array.');
        }

        $normalized = [];
        foreach ($accept as $item) {
            if (!is_scalar($item)) {
                continue;
            }

            $token = trim((string) $item);
            if ($token !== '') {
                $normalized[] = $token;
            }
        }

        $this->props['accept'] = array_values(array_unique($normalized));
        return $this;
    }

    public function setAcceptVariant(string $variant): static
    {
        $variant = strtolower(trim($variant));

        if (!array_key_exists($variant, $this->acceptVariantMap)) {
            throw new \InvalidArgumentException('Invalid file input accept variant: ' . $variant);
        }

        $this->props['acceptVariant'] = $variant;
        return $this;
    }

    public function setAllowedMimeVariant(string $variant): static
    {
        return $this->setAcceptVariant($variant);
    }

    public function setHelperText(?string $helperText): static
    {
        $helperText = $helperText !== null ? trim($helperText) : '';
        $this->props['helperText'] = $helperText !== '' ? $helperText : null;
        return $this;
    }

    public function setDynamicInputAddition(bool $value = true): static
    {
        $this->props['dynamicInputAddition'] = $value;
        return $this;
    }

    public function setAddButtonLabel(string $label): static
    {
        $label = trim($label);
        if ($label !== '') {
            $this->props['addButtonLabel'] = $label;
        }

        return $this;
    }

    public function setRemoveButtonLabel(string $label): static
    {
        $label = trim($label);
        if ($label !== '') {
            $this->props['removeButtonLabel'] = $label;
        }

        return $this;
    }

    public function setShowPreview(bool $state = true): static
    {
        $this->props['showPreview'] = $state;
        return $this;
    }

    public function setPreviewPlaceholder(string $text): static
    {
        $text = trim($text);
        if ($text !== '') {
            $this->props['previewPlaceholder'] = $text;
        }

        return $this;
    }

    public function setShowSelectedFiles(bool $state = true): static
    {
        $this->props['showSelectedFiles'] = $state;
        return $this;
    }

    public function setSelectedFilesTitle(string $title): static
    {
        $title = trim($title);
        if ($title !== '') {
            $this->props['selectedFilesTitle'] = $title;
        }

        return $this;
    }

    public function setEnableDropzone(bool $state = true): static
    {
        $this->props['enableDropzone'] = $state;
        return $this;
    }

    public function setDropzoneText(string $text): static
    {
        $text = trim($text);
        if ($text !== '') {
            $this->props['dropzoneText'] = $text;
        }

        return $this;
    }

    protected function resolveAcceptList(): array
    {
        if (!empty($this->props['accept'])) {
            return $this->props['accept'];
        }

        return $this->acceptVariantMap[$this->props['acceptVariant']] ?? [];
    }

    public function render(): string
    {
        $id = $this->props['id'];
        if (!$id) {
            $id = 'modulr-file-input-' . substr(md5(uniqid((string) mt_rand(), true)), 0, 8);
        }

        $acceptList = $this->resolveAcceptList();
        $accept = implode(',', $acceptList);

        $inputName = (string) $this->props['name'];
        if ($this->props['multiple'] && substr($inputName, -2) !== '[]') {
            $inputName .= '[]';
        }

        $attributes = $this->mergeBaseAttributes([
            'id' => $id,
            'class' => 'modulr-file-input modulr-file-input--' . $this->props['acceptVariant'],
            'data-component' => 'file-input',
            'data-accept' => $accept,
            'data-name' => $inputName,
            'data-multiple' => $this->props['multiple'] ? 'true' : 'false',
            'data-dynamic-addition' => $this->props['dynamicInputAddition'] ? 'true' : 'false',
            'data-remove-label' => (string) $this->props['removeButtonLabel'],
            'data-preview-enabled' => $this->props['showPreview'] ? 'true' : 'false',
            'data-selected-list-enabled' => $this->props['showSelectedFiles'] ? 'true' : 'false',
            'data-dropzone-enabled' => $this->props['enableDropzone'] ? 'true' : 'false',
        ]);

        return $this->renderComponentView([
            'id' => $id,
            'name' => $inputName,
            'label' => $this->props['label'],
            'required' => $this->props['required'],
            'disabled' => $this->props['disabled'],
            'multiple' => $this->props['multiple'],
            'accept' => $accept,
            'acceptVariant' => $this->props['acceptVariant'],
            'helperText' => $this->props['helperText'],
            'dynamicInputAddition' => $this->props['dynamicInputAddition'],
            'addButtonLabel' => $this->props['addButtonLabel'],
            'removeButtonLabel' => $this->props['removeButtonLabel'],
            'showPreview' => $this->props['showPreview'],
            'previewPlaceholder' => $this->props['previewPlaceholder'],
            'showSelectedFiles' => $this->props['showSelectedFiles'],
            'selectedFilesTitle' => $this->props['selectedFilesTitle'],
            'enableDropzone' => $this->props['enableDropzone'],
            'dropzoneText' => $this->props['dropzoneText'],
            'attributes' => $attributes,
        ], __DIR__);
    }
}