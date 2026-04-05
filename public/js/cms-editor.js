(function () {
    if (!window.CMS_EDITOR || typeof bootstrap === 'undefined') {
        return;
    }

    var state = {
        preview: true,
        pending: {},
        current: null,
    };

    var modalEl = document.getElementById('cmsEditModal');
    var modal = new bootstrap.Modal(modalEl);
    var modalBody = document.getElementById('cmsModalBody');

    var markEditable = function () {
        document.querySelectorAll('[data-i18n], [data-cms-key], img[data-cms-key]').forEach(function (el) {
            el.classList.toggle('cms-editable', state.preview);
            el.addEventListener('click', onEditableClick);
        });
    };

    var getSectionKey = function (el) {
        return el.closest('[data-cms-section]')?.dataset.cmsSection || 'global';
    };

    var onEditableClick = function (event) {
        if (!state.preview) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        var el = event.currentTarget;
        var isImage = el.tagName === 'IMG';

        state.current = {
            el: el,
            sectionKey: getSectionKey(el),
            fieldKey: el.dataset.cmsKey || el.dataset.i18n || 'content',
            isImage: isImage,
        };

        if (isImage) {
            openImageModal(el);
            return;
        }

        openTextModal(el);
    };

    var openTextModal = function (el) {
        var currentText = el.textContent.trim();

        modalBody.innerHTML = '' +
            '<label class="form-label">Arabic</label>' +
            '<textarea class="form-control mb-3" id="cmsTextAr" rows="3">' + currentText + '</textarea>' +
            '<label class="form-label">English</label>' +
            '<textarea class="form-control mb-3" id="cmsTextEn" rows="3">' + currentText + '</textarea>' +
            '<div class="row g-2">' +
            '  <div class="col-6"><label class="form-label">Font Size</label><input class="form-control" id="cmsFontSize" placeholder="e.g. 18px"></div>' +
            '  <div class="col-6"><label class="form-label">Text Color</label><input type="color" class="form-control form-control-color w-100" id="cmsColor"></div>' +
            '</div>';

        modal.show();
    };

    var openImageModal = function () {
        modalBody.innerHTML = '' +
            '<label class="form-label">Upload Image</label>' +
            '<input type="file" class="form-control" id="cmsImageInput" accept="image/*">' +
            '<small class="text-muted d-block mt-2">Aspect ratio and crop are supported by browser-level selection in this version.</small>';
        modal.show();
    };

    document.getElementById('cmsApplyBtn').addEventListener('click', function () {
        if (!state.current) {
            return;
        }

        if (state.current.isImage) {
            var file = document.getElementById('cmsImageInput').files[0];
            if (!file) {
                return;
            }

            var form = new FormData();
            form.append('image', file);

            fetch(window.CMS_EDITOR.routes.uploadImage, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': window.CMS_EDITOR.csrf },
                body: form,
            })
                .then(function (response) { return response.json(); })
                .then(function (payload) {
                    state.current.el.src = payload.url;
                    queueChange(state.current.sectionKey, state.current.fieldKey, {
                        type: 'image',
                        path: payload.path,
                        url: payload.url,
                    });
                    modal.hide();
                });

            return;
        }

        var valueAr = document.getElementById('cmsTextAr').value;
        var valueEn = document.getElementById('cmsTextEn').value;
        var fontSize = document.getElementById('cmsFontSize').value;
        var color = document.getElementById('cmsColor').value;

        var lang = window.CMS_EDITOR.locale === 'ar' ? valueAr : valueEn;
        state.current.el.textContent = lang;

        if (fontSize) {
            state.current.el.style.fontSize = fontSize;
        }

        if (color) {
            state.current.el.style.color = color;
        }

        queueChange(state.current.sectionKey, state.current.fieldKey, {
            type: 'text',
            ar: valueAr,
            en: valueEn,
            style: {
                font_size: fontSize || null,
                text_color: color || null,
            },
        });

        modal.hide();
    });

    var queueChange = function (sectionKey, fieldKey, payload) {
        state.pending[sectionKey] = state.pending[sectionKey] || {
            section_key: sectionKey,
            content_json: {},
            style_json: {},
        };

        state.pending[sectionKey].content_json[fieldKey] = payload;
        if (payload.style) {
            state.pending[sectionKey].style_json[fieldKey] = payload.style;
        }
    };

    document.getElementById('cmsSaveBtn').addEventListener('click', function () {
        var changes = Object.values(state.pending);

        if (!changes.length) {
            return;
        }

        fetch(window.CMS_EDITOR.routes.save, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.CMS_EDITOR.csrf,
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                page_key: window.CMS_EDITOR.pageKey,
                changes: changes,
            }),
        })
            .then(function (response) { return response.json(); })
            .then(function () {
                state.pending = {};
                alert('CMS content saved successfully.');
            });
    });

    document.getElementById('cmsDiscardBtn').addEventListener('click', function () {
        state.pending = {};
        window.location.reload();
    });

    document.getElementById('cmsTogglePreview').addEventListener('click', function (event) {
        state.preview = !state.preview;
        event.currentTarget.textContent = state.preview ? 'Preview ON' : 'Preview OFF';
        document.body.classList.toggle('cms-preview-on', state.preview);
        markEditable();
    });

    document.body.classList.add('cms-preview-on');
    markEditable();
})();
