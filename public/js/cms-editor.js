(function () {
    if (!window.CMS_EDITOR || typeof bootstrap === 'undefined') {
        return;
    }

    var state = {
        preview: true,
        pending: {},
        current: null,
        sectionOrder: {},
    };

    var modalEl = document.getElementById('cmsEditModal');
    var modal = new bootstrap.Modal(modalEl);
    var modalBody = document.getElementById('cmsModalBody');

    var isDark = function () {
        return document.body.classList.contains('dark-mode');
    };

    var getMode = function () {
        return isDark() ? 'dark' : 'light';
    };

    var resolveFieldKey = function (el) {
        var explicit = el.dataset.cmsKey || el.dataset.i18n || 'content';
        var section = getSectionKey(el);

        if (explicit.indexOf('.') === -1) {
            return explicit;
        }

        var normalized = explicit.split('.');
        if (normalized.length <= 2) {
            return explicit;
        }

        if (normalized[1] === section) {
            return normalized.slice(2).join('.');
        }

        return explicit;
    };

    var markEditable = function () {
        document.querySelectorAll('[data-i18n], [data-cms-key], img[data-cms-key], .btn, i[class*=fa], i[class*=bi]').forEach(function (el) {
            el.classList.toggle('cms-editable', state.preview);
            if (!el.dataset.cmsBound) {
                el.addEventListener('click', onEditableClick);
                el.dataset.cmsBound = '1';
            }
        });

        enableSectionDnD();
    };

    var getSectionKey = function (el) {
        var section = el.closest('[data-cms-section]');
        if (section && section.dataset.cmsSection) {
            return section.dataset.cmsSection;
        }

        return 'global';
    };

    var getCurrentStyle = function (el) {
        return {
            textColor: rgbToHex(getComputedStyle(el).color),
            bgColor: rgbToHex(getComputedStyle(el).backgroundColor),
            borderColor: rgbToHex(getComputedStyle(el).borderColor),
            fontSize: getComputedStyle(el).fontSize,
        };
    };

    var rgbToHex = function (rgb) {
        if (!rgb || rgb.indexOf('rgb') === -1) {
            return '#000000';
        }

        var result = rgb.match(/\d+/g);
        if (!result || result.length < 3) {
            return '#000000';
        }

        return '#' + result.slice(0, 3).map(function (n) {
            return ('0' + parseInt(n, 10).toString(16)).slice(-2);
        }).join('');
    };

    var onEditableClick = function (event) {
        if (!state.preview) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        var el = event.currentTarget;
        var tag = el.tagName;

        state.current = {
            el: el,
            sectionKey: getSectionKey(el),
            fieldKey: resolveFieldKey(el),
            type: tag === 'IMG' ? 'image' : tag === 'I' ? 'icon' : tag === 'A' || el.classList.contains('btn') ? 'button' : 'text',
        };

        openModalByType();
    };

    var openModalByType = function () {
        if (!state.current) {
            return;
        }

        if (state.current.type === 'image') {
            openImageModal();
        } else if (state.current.type === 'button') {
            openButtonModal();
        } else if (state.current.type === 'icon') {
            openIconModal();
        } else {
            openTextModal();
        }
    };

    var openTextModal = function () {
        var style = getCurrentStyle(state.current.el);
        var text = state.current.el.textContent.trim();

        modalBody.innerHTML = '' +
            '<div class="mb-3"><label class="form-label">Arabic</label><textarea class="form-control" id="cmsTextAr" rows="2">' + text + '</textarea></div>' +
            '<div class="mb-3"><label class="form-label">English</label><textarea class="form-control" id="cmsTextEn" rows="2">' + text + '</textarea></div>' +
            '<div class="row g-2">' +
            '<div class="col-6"><label class="form-label">Font Size</label><input class="form-control" id="cmsFontSize" value="' + style.fontSize + '"></div>' +
            '<div class="col-6"><label class="form-label">Line Height</label><input class="form-control" id="cmsLineHeight" placeholder="1.6"></div>' +
            '<div class="col-6"><label class="form-label">Text Align</label><select class="form-select" id="cmsTextAlign"><option>right</option><option>center</option><option>left</option></select></div>' +
            '<div class="col-3"><label class="form-label">Text (Light)</label><input type="color" class="form-control form-control-color w-100" id="cmsTextLight" value="' + style.textColor + '"></div>' +
            '<div class="col-3"><label class="form-label">Text (Dark)</label><input type="color" class="form-control form-control-color w-100" id="cmsTextDark" value="' + style.textColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Background (Light)</label><input type="color" class="form-control form-control-color w-100" id="cmsBgLight" value="' + style.bgColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Background (Dark)</label><input type="color" class="form-control form-control-color w-100" id="cmsBgDark" value="' + style.bgColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Overlay Opacity</label><input type="number" class="form-control" id="cmsOverlayOpacity" step="0.05" min="0" max="1" value="0"></div>' +
            '<div class="col-6 d-flex align-items-end"><div class="form-check"><input class="form-check-input" type="checkbox" id="cmsVisible" checked><label class="form-check-label" for="cmsVisible">Show element</label></div></div>' +
            '</div>';

        modal.show();
    };

    var openButtonModal = function () {
        var style = getCurrentStyle(state.current.el);
        modalBody.innerHTML = '' +
            '<div class="mb-2"><label class="form-label">Button Text (AR)</label><input class="form-control" id="cmsBtnTextAr" value="' + (state.current.el.textContent.trim()) + '"></div>' +
            '<div class="mb-2"><label class="form-label">Button Text (EN)</label><input class="form-control" id="cmsBtnTextEn" value="' + (state.current.el.textContent.trim()) + '"></div>' +
            '<div class="mb-2"><label class="form-label">Link URL</label><input class="form-control" id="cmsBtnLink" value="' + (state.current.el.getAttribute('href') || '#') + '"></div>' +
            '<div class="row g-2">' +
            '<div class="col-6"><label class="form-label">BG Light</label><input type="color" class="form-control form-control-color w-100" id="cmsBtnBgLight" value="' + style.bgColor + '"></div>' +
            '<div class="col-6"><label class="form-label">BG Dark</label><input type="color" class="form-control form-control-color w-100" id="cmsBtnBgDark" value="' + style.bgColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Text Light</label><input type="color" class="form-control form-control-color w-100" id="cmsBtnTextLight" value="' + style.textColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Text Dark</label><input type="color" class="form-control form-control-color w-100" id="cmsBtnTextDark" value="' + style.textColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Border</label><input type="color" class="form-control form-control-color w-100" id="cmsBtnBorder" value="' + style.borderColor + '"></div>' +
            '<div class="col-6"><label class="form-label">Hover BG</label><input type="color" class="form-control form-control-color w-100" id="cmsBtnHoverBg" value="' + style.bgColor + '"></div>' +
            '</div>';

        modal.show();
    };

    var openIconModal = function () {
        modalBody.innerHTML = '' +
            '<div class="mb-2"><label class="form-label">Icon Class (Bootstrap/Hero/Fa)</label><input class="form-control" id="cmsIconClass" value="' + state.current.el.className + '"></div>' +
            '<div class="row g-2">' +
            '<div class="col-6"><label class="form-label">Icon Color</label><input type="color" class="form-control form-control-color w-100" id="cmsIconColor" value="' + rgbToHex(getComputedStyle(state.current.el).color) + '"></div>' +
            '<div class="col-6"><label class="form-label">Icon Size</label><input class="form-control" id="cmsIconSize" value="' + getComputedStyle(state.current.el).fontSize + '"></div>' +
            '</div>';

        modal.show();
    };

    var openImageModal = function () {
        modalBody.innerHTML = '' +
            '<div class="mb-2"><label class="form-label">Upload Image</label><input type="file" class="form-control" id="cmsImageInput" accept="image/*"></div>' +
            '<div class="row g-2">' +
            '<div class="col-6"><label class="form-label">Aspect Ratio</label><select class="form-select" id="cmsAspect"><option value="free">Free</option><option value="1:1">1:1</option><option value="4:3">4:3</option><option value="16:9">16:9</option></select></div>' +
            '<div class="col-6"><label class="form-label">Background overlay</label><input type="number" step="0.05" min="0" max="1" class="form-control" id="cmsImageOverlay" value="0"></div>' +
            '</div>' +
            '<small class="text-muted mt-2 d-block">Crop is browser-based in this iteration (canvas preview + ratio lock).</small>' +
            '<canvas id="cmsCropCanvas" class="w-100 mt-2 border" style="max-height:200px;"></canvas>';

        bindImagePreview();
        modal.show();
    };

    var bindImagePreview = function () {
        setTimeout(function () {
            var input = document.getElementById('cmsImageInput');
            var canvas = document.getElementById('cmsCropCanvas');
            if (!input || !canvas) return;
            var ctx = canvas.getContext('2d');

            input.addEventListener('change', function () {
                var file = input.files[0];
                if (!file) return;
                var img = new Image();
                img.onload = function () {
                    var ratio = document.getElementById('cmsAspect').value;
                    var width = img.width;
                    var height = img.height;

                    if (ratio === '1:1') height = width;
                    if (ratio === '4:3') height = Math.round(width * 3 / 4);
                    if (ratio === '16:9') height = Math.round(width * 9 / 16);

                    canvas.width = Math.min(width, 900);
                    canvas.height = Math.min(height, 500);
                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
                };
                img.src = URL.createObjectURL(file);
            });
        }, 0);
    };

    document.getElementById('cmsApplyBtn').addEventListener('click', function () {
        if (!state.current) return;

        if (state.current.type === 'image') {
            saveImageChanges();
            return;
        }

        if (state.current.type === 'button') {
            applyButtonChanges();
            return;
        }

        if (state.current.type === 'icon') {
            applyIconChanges();
            return;
        }

        applyTextChanges();
    });

    var styleForModes = function (lightVal, darkVal) {
        return { light_value: lightVal, dark_value: darkVal };
    };

    var applyTextChanges = function () {
        var el = state.current.el;
        var ar = document.getElementById('cmsTextAr').value;
        var en = document.getElementById('cmsTextEn').value;
        var fontSize = document.getElementById('cmsFontSize').value;
        var lineHeight = document.getElementById('cmsLineHeight').value;
        var align = document.getElementById('cmsTextAlign').value;
        var textLight = document.getElementById('cmsTextLight').value;
        var textDark = document.getElementById('cmsTextDark').value;
        var bgLight = document.getElementById('cmsBgLight').value;
        var bgDark = document.getElementById('cmsBgDark').value;
        var overlay = document.getElementById('cmsOverlayOpacity').value;
        var visible = document.getElementById('cmsVisible').checked;

        el.textContent = window.CMS_EDITOR.locale === 'ar' ? ar : en;
        el.style.fontSize = fontSize;
        el.style.lineHeight = lineHeight || '';
        el.style.textAlign = align;
        el.style.color = getMode() === 'dark' ? textDark : textLight;
        el.style.backgroundColor = getMode() === 'dark' ? bgDark : bgLight;
        el.style.display = visible ? '' : 'none';

        queueChange(state.current.sectionKey, {
            field_key: state.current.fieldKey,
            content: {
                type: 'text',
                ar: ar,
                en: en,
            },
            style: {
                font_size: fontSize,
                line_height: lineHeight,
                text_align: align,
                overlay_opacity: overlay,
                visible: visible,
                text_color: styleForModes(textLight, textDark),
                background_color: styleForModes(bgLight, bgDark),
            }
        });

        modal.hide();
    };

    var applyButtonChanges = function () {
        var el = state.current.el;
        var ar = document.getElementById('cmsBtnTextAr').value;
        var en = document.getElementById('cmsBtnTextEn').value;
        var link = document.getElementById('cmsBtnLink').value;

        var style = {
            background_color: styleForModes(document.getElementById('cmsBtnBgLight').value, document.getElementById('cmsBtnBgDark').value),
            text_color: styleForModes(document.getElementById('cmsBtnTextLight').value, document.getElementById('cmsBtnTextDark').value),
            border_color: styleForModes(document.getElementById('cmsBtnBorder').value, document.getElementById('cmsBtnBorder').value),
            hover_background_color: styleForModes(document.getElementById('cmsBtnHoverBg').value, document.getElementById('cmsBtnHoverBg').value),
        };

        el.textContent = window.CMS_EDITOR.locale === 'ar' ? ar : en;
        el.setAttribute('href', link || '#');
        el.style.backgroundColor = getMode() === 'dark' ? style.background_color.dark_value : style.background_color.light_value;
        el.style.color = getMode() === 'dark' ? style.text_color.dark_value : style.text_color.light_value;
        el.style.borderColor = style.border_color.light_value;

        queueChange(state.current.sectionKey, {
            field_key: state.current.fieldKey,
            content: { type: 'button', ar: ar, en: en, link: link },
            style: style,
        });

        modal.hide();
    };

    var applyIconChanges = function () {
        var iconClass = document.getElementById('cmsIconClass').value;
        var iconColor = document.getElementById('cmsIconColor').value;
        var iconSize = document.getElementById('cmsIconSize').value;

        state.current.el.className = iconClass;
        state.current.el.style.color = iconColor;
        state.current.el.style.fontSize = iconSize;

        queueChange(state.current.sectionKey, {
            field_key: state.current.fieldKey,
            content: { type: 'icon', class: iconClass },
            style: {
                color: styleForModes(iconColor, iconColor),
                size: iconSize,
            },
        });

        modal.hide();
    };

    var saveImageChanges = function () {
        var file = document.getElementById('cmsImageInput').files[0];
        if (!file) return;

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

                queueChange(state.current.sectionKey, {
                    field_key: state.current.fieldKey,
                    content: {
                        type: 'image',
                        path: payload.path,
                        url: payload.url,
                        aspect_ratio: document.getElementById('cmsAspect').value,
                    },
                    style: {
                        overlay_opacity: document.getElementById('cmsImageOverlay').value,
                    },
                });
                modal.hide();
            });
    };

    var queueChange = function (sectionKey, change) {
        state.pending[sectionKey] = state.pending[sectionKey] || {
            section_key: sectionKey,
            content_json: {},
            style_json: {},
        };

        state.pending[sectionKey].content_json[change.field_key] = change.content;
        state.pending[sectionKey].style_json[change.field_key] = change.style;
    };

    var enableSectionDnD = function () {
        document.querySelectorAll('[data-cms-section]').forEach(function (section, index) {
            section.setAttribute('draggable', state.preview ? 'true' : 'false');
            section.dataset.cmsOrder = String(index);

            if (!section.dataset.cmsDndBound) {
                section.addEventListener('dragstart', function (e) {
                    if (!state.preview) return;
                    e.dataTransfer.setData('text/plain', section.dataset.cmsSection);
                });

                section.addEventListener('dragover', function (e) {
                    if (!state.preview) return;
                    e.preventDefault();
                });

                section.addEventListener('drop', function (e) {
                    if (!state.preview) return;
                    e.preventDefault();
                    var from = e.dataTransfer.getData('text/plain');
                    var to = section.dataset.cmsSection;
                    reorderSections(from, to);
                });

                section.dataset.cmsDndBound = '1';
            }
        });
    };

    var reorderSections = function (fromKey, toKey) {
        if (fromKey === toKey) return;

        var fromEl = document.querySelector('[data-cms-section="' + fromKey + '"]');
        var toEl = document.querySelector('[data-cms-section="' + toKey + '"]');
        if (!fromEl || !toEl || !toEl.parentNode) return;

        toEl.parentNode.insertBefore(fromEl, toEl);

        document.querySelectorAll('[data-cms-section]').forEach(function (section, i) {
            var key = section.dataset.cmsSection;
            state.pending[key] = state.pending[key] || { section_key: key, content_json: {}, style_json: {} };
            state.pending[key].sort_order = i;
        });
    };

    document.getElementById('cmsSaveBtn').addEventListener('click', function () {
        var changes = Object.values(state.pending);
        if (!changes.length) return;

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
