document.querySelectorAll('[data-component="file-input"]').forEach((root) => {
	if (root.dataset.fileInputBound === 'true') {
		return;
	}

	root.dataset.fileInputBound = 'true';

	const previewEnabled = root.dataset.previewEnabled === 'true';
	const selectedListEnabled = root.dataset.selectedListEnabled === 'true';
	const dropzoneEnabled = root.dataset.dropzoneEnabled === 'true';
	const rowFileStore = new WeakMap();
	const debugPrefix = '[modulr:file-input]';

	const describeFile = (file) => {
		return {
			name: file && file.name ? file.name : '',
			type: file && file.type ? file.type : 'unknown',
			sizeBytes: file && Number.isFinite(file.size) ? file.size : 0,
		};
	};

	const logDebug = (message, payload) => {
		if (payload === undefined) {
			console.debug(`${debugPrefix} ${message}`);
			return;
		}

		console.debug(`${debugPrefix} ${message}`, payload);
	};

	const extractDroppedFiles = (dataTransfer) => {
		if (!dataTransfer) {
			return [];
		}

		const fromFiles = Array.from(dataTransfer.files || []);
		if (fromFiles.length > 0) {
			return fromFiles;
		}

		const items = Array.from(dataTransfer.items || []);
		const fromItems = items
			.filter((item) => item && item.kind === 'file')
			.map((item) => {
				try {
					return item.getAsFile();
				} catch (error) {
					return null;
				}
			})
			.filter((file) => !!file);

		return fromItems;
	};

	const parseAcceptTokens = (acceptValue) => {
		return String(acceptValue || '')
			.split(',')
			.map((token) => token.trim().toLowerCase())
			.filter((token) => token.length > 0);
	};

	const fileMatchesAcceptToken = (file, token) => {
		if (!token || token === '*/*') {
			return true;
		}

		const name = String((file && file.name) || '').toLowerCase();
		const type = String((file && file.type) || '').toLowerCase();

		if (token.startsWith('.')) {
			return name.endsWith(token);
		}

		if (token.endsWith('/*')) {
			const family = token.slice(0, -1);
			return type.startsWith(family);
		}

		return type === token;
	};

	const filterFilesByAccept = (files, input) => {
		const list = Array.from(files || []);
		const tokens = parseAcceptTokens(input && input.accept);

		if (tokens.length === 0) {
			return list;
		}

		return list.filter((file) => tokens.some((token) => fileMatchesAcceptToken(file, token)));
	};

	const syncInputFiles = (input, files) => {
		if (!input) {
			return;
		}

		try {
			if (typeof DataTransfer !== 'undefined') {
				const dt = new DataTransfer();
				files.forEach((file) => {
					dt.items.add(file);
				});

				input.files = dt.files;
			}
		} catch (error) {
			// Ignore assignment issues on browsers that restrict programmatic FileList updates.
		}
	};

	const getRowFiles = (row, input) => {
		if (rowFileStore.has(row)) {
			return rowFileStore.get(row) || [];
		}

		const fromInput = Array.from((input && input.files) || []);
		rowFileStore.set(row, fromInput);
		return fromInput;
	};

	const setRowFiles = (row, input, files) => {
		const normalized = Array.from(files || []);
		rowFileStore.set(row, normalized);
		syncInputFiles(input, normalized);
	};

	const updateRowPreview = (row, files) => {
		if (!previewEnabled || !row) {
			return;
		}

		const text = row.querySelector('[data-file-input-preview-text="true"]');
		const image = row.querySelector('[data-file-input-preview-image="true"]');
		if (!text || !image) {
			return;
		}

		const placeholder = text.dataset.placeholder || text.textContent || 'No file selected';
		const fileList = Array.from(files || []);

		if (image.dataset.previewUrl) {
			URL.revokeObjectURL(image.dataset.previewUrl);
			delete image.dataset.previewUrl;
		}

		if (fileList.length === 0) {
			image.hidden = true;
			image.removeAttribute('src');
			text.textContent = placeholder;
			return;
		}

		const first = fileList[0];
		const suffix = fileList.length > 1 ? ` (+${fileList.length - 1} more)` : '';
		text.textContent = `${first.name}${suffix}`;

		if (first.type && first.type.startsWith('image/')) {
			const objectUrl = URL.createObjectURL(first);
			image.src = objectUrl;
			image.hidden = false;
			image.dataset.previewUrl = objectUrl;
		} else {
			image.hidden = true;
			image.removeAttribute('src');
		}
	};

	const renderSelectedList = (row, files) => {
		if (!selectedListEnabled || !row) {
			return;
		}

		const list = row.querySelector('[data-file-input-selected-list="true"]');
		if (!list) {
			return;
		}

		list.innerHTML = '';

		const fileList = Array.from(files || []);
		logDebug('renderSelectedList:start', {
			rowId: row.dataset.fileInputRowId || null,
			count: fileList.length,
			files: fileList.map(describeFile),
		});

		if (fileList.length === 0) {
			const emptyItem = document.createElement('li');
			emptyItem.className = 'modulr-file-input__selected-empty';
			emptyItem.textContent = 'No files selected';
			list.appendChild(emptyItem);
			return;
		}

		fileList.forEach((file, index) => {
			logDebug('selectedList:addFile', {
				index,
				file: describeFile(file),
			});

			const item = document.createElement('li');
			item.className = 'modulr-file-input__selected-item';

			const name = document.createElement('span');
			name.className = 'modulr-file-input__selected-name';
			name.textContent = file.name;

			const meta = document.createElement('span');
			meta.className = 'modulr-file-input__selected-meta';
			meta.textContent = `${Math.max(1, Math.round(file.size / 1024))} KB`;

			const remove = document.createElement('button');
			remove.type = 'button';
			remove.className = 'modulr-file-input__selected-remove';
			remove.setAttribute('data-file-selected-remove', 'true');
			remove.setAttribute('data-file-index', String(index));
			remove.textContent = 'Remove';

			item.appendChild(name);
			item.appendChild(meta);
			item.appendChild(remove);
			list.appendChild(item);
		});
	};

	const commitRowFiles = (row, input, files) => {
		logDebug('commitRowFiles', {
			inputName: input ? input.name : null,
			count: Array.from(files || []).length,
			files: Array.from(files || []).map(describeFile),
		});

		setRowFiles(row, input, files);
		const latest = getRowFiles(row, input);
		updateRowPreview(row, latest);
		renderSelectedList(row, latest);
	};

	const mergeRowFiles = (row, input, incomingFiles) => {
		const current = getRowFiles(row, input);
		const allowMultiple = input && input.multiple;
		const acceptedIncoming = filterFilesByAccept(incomingFiles, input);

		logDebug('mergeRowFiles', {
			inputName: input ? input.name : null,
			allowMultiple: !!allowMultiple,
			incomingCount: Array.from(incomingFiles || []).length,
			acceptedCount: acceptedIncoming.length,
			incoming: Array.from(incomingFiles || []).map(describeFile),
			accepted: acceptedIncoming.map(describeFile),
		});

		const next = allowMultiple
			? current.concat(acceptedIncoming)
			: acceptedIncoming.slice(0, 1);

		commitRowFiles(row, input, next);
	};

	const bindDropzone = (row) => {
		if (!dropzoneEnabled || !row) {
			return;
		}

		const input = row.querySelector('[data-file-input-control="true"]');
		const dropzone = row.querySelector('[data-file-input-dropzone="true"]');
		if (!input || !dropzone || dropzone.dataset.dropzoneBound === 'true') {
			return;
		}

		dropzone.dataset.dropzoneBound = 'true';

		const setDragState = (state) => {
			dropzone.classList.toggle('is-dragover', state);
		};

		const handleDroppedFiles = (files) => {
			const acceptedIncoming = filterFilesByAccept(files, input);

			logDebug('dropzone:handleDroppedFiles', {
				inputName: input ? input.name : null,
				droppedCount: Array.from(files || []).length,
				acceptedCount: acceptedIncoming.length,
				dropped: Array.from(files || []).map(describeFile),
				accepted: acceptedIncoming.map(describeFile),
			});

			if (acceptedIncoming.length === 0) {
				logDebug('dropzone:noAcceptedFiles');
				return;
			}

			if (!input.multiple) {
				commitRowFiles(row, input, acceptedIncoming.slice(0, 1));
				return;
			}

			mergeRowFiles(row, input, acceptedIncoming);
		};

		dropzone.addEventListener('dragenter', (event) => {
			event.preventDefault();
			setDragState(true);
		});

		dropzone.addEventListener('dragover', (event) => {
			event.preventDefault();
			setDragState(true);
		});

		dropzone.addEventListener('dragleave', (event) => {
			event.preventDefault();
			setDragState(false);
		});

		dropzone.addEventListener('drop', (event) => {
			event.preventDefault();
			setDragState(false);

			const files = extractDroppedFiles(event.dataTransfer);
			logDebug('dropzone:dropEvent', {
				inputName: input ? input.name : null,
				count: files.length,
				files: files.map(describeFile),
				dataTransferTypes: Array.from((event.dataTransfer && event.dataTransfer.types) || []),
				dataTransferItems: Array.from((event.dataTransfer && event.dataTransfer.items) || []).map((item) => ({
					kind: item.kind,
					type: item.type,
				})),
			});

			if (files.length === 0) {
				logDebug('dropzone:dropEventEmpty');
				return;
			}

			handleDroppedFiles(files);
		});

		dropzone.addEventListener('click', () => {
			input.click();
		});

		dropzone.addEventListener('keydown', (event) => {
			if (event.key !== 'Enter' && event.key !== ' ') {
				return;
			}

			event.preventDefault();
			input.click();
		});

		// Fallback: some browsers/users may drop directly over the native input.
		input.addEventListener('dragover', (event) => {
			event.preventDefault();
			setDragState(true);
		});

		input.addEventListener('dragleave', (event) => {
			event.preventDefault();
			setDragState(false);
		});

		input.addEventListener('drop', (event) => {
			event.preventDefault();
			setDragState(false);

			const files = extractDroppedFiles(event.dataTransfer);
			logDebug('input:dropEventFallback', {
				inputName: input ? input.name : null,
				count: files.length,
				files: files.map(describeFile),
				dataTransferTypes: Array.from((event.dataTransfer && event.dataTransfer.types) || []),
			});

			if (files.length === 0) {
				logDebug('input:dropEventFallbackEmpty');
				return;
			}

			handleDroppedFiles(files);
		});
	};

	const initializeRow = (row) => {
		if (!row) {
			return;
		}

		const input = row.querySelector('[data-file-input-control="true"]');
		if (!input) {
			return;
		}

		const existing = Array.from(input.files || []);
		setRowFiles(row, input, existing);
		updateRowPreview(row, existing);
		renderSelectedList(row, existing);
		bindDropzone(row);
	};

	if (previewEnabled) {
		root.querySelectorAll('[data-file-input-preview-text="true"]').forEach((node) => {
			node.dataset.placeholder = node.textContent || 'No file selected';
		});
	}

	root.querySelectorAll('[data-file-input-row="true"]').forEach((row) => {
		initializeRow(row);
	});

	root.addEventListener('change', (event) => {
		const control = event.target.closest('[data-file-input-control="true"]');
		if (!control || !root.contains(control)) {
			return;
		}

		const row = control.closest('[data-file-input-row="true"]');
		if (!row) {
			return;
		}

		commitRowFiles(row, control, Array.from(control.files || []));
	});

	const allowDynamic = root.dataset.dynamicAddition === 'true';
	if (!allowDynamic) {
		root.addEventListener('click', (event) => {
			const removeOne = event.target.closest('[data-file-selected-remove="true"]');
			if (!removeOne || !root.contains(removeOne)) {
				return;
			}

			const row = removeOne.closest('[data-file-input-row="true"]');
			if (!row) {
				return;
			}

			const input = row.querySelector('[data-file-input-control="true"]');
			if (!input) {
				return;
			}

			const index = Number.parseInt(removeOne.dataset.fileIndex || '-1', 10);
			const current = getRowFiles(row, input);
			if (!Number.isFinite(index) || index < 0 || index >= current.length) {
				return;
			}

			const next = current.filter((_, currentIndex) => currentIndex !== index);
			commitRowFiles(row, input, next);
		});

		return;
	}

	const list = root.querySelector('[data-file-input-list="true"]');
	const template = root.querySelector('[data-file-input-template="true"]');
	const addButton = root.querySelector('[data-file-input-add="true"]');

	if (!list || !template || !addButton) {
		return;
	}

	addButton.addEventListener('click', () => {
		const fragment = template.content.cloneNode(true);
		list.appendChild(fragment);

		const lastRow = list.lastElementChild;
		initializeRow(lastRow);
	});

	root.addEventListener('click', (event) => {
		const removeOne = event.target.closest('[data-file-selected-remove="true"]');
		if (removeOne && root.contains(removeOne)) {
			const row = removeOne.closest('[data-file-input-row="true"]');
			if (!row) {
				return;
			}

			const input = row.querySelector('[data-file-input-control="true"]');
			if (!input) {
				return;
			}

			const index = Number.parseInt(removeOne.dataset.fileIndex || '-1', 10);
			const current = getRowFiles(row, input);
			if (!Number.isFinite(index) || index < 0 || index >= current.length) {
				return;
			}

			const next = current.filter((_, currentIndex) => currentIndex !== index);
			commitRowFiles(row, input, next);
			return;
		}

		const removeButton = event.target.closest('[data-file-input-remove="true"]');
		if (!removeButton || !root.contains(removeButton)) {
			return;
		}

		const row = removeButton.closest('[data-file-input-row="true"]');
		if (!row) {
			return;
		}

		const allRows = list.querySelectorAll('[data-file-input-row="true"]');
		if (allRows.length <= 1) {
			const control = row.querySelector('[data-file-input-control="true"]');
			if (control) {
				control.value = '';
			}

			commitRowFiles(row, control, []);
			return;
		}

		const image = row.querySelector('[data-file-input-preview-image="true"]');
		if (image && image.dataset.previewUrl) {
			URL.revokeObjectURL(image.dataset.previewUrl);
		}

		row.remove();
	});
});
