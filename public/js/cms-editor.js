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

    document.querySelectorAll('[data-i18n]:not([data-cms-key])').forEach(function (el) {
        el.dataset.cmsKey = el.dataset.i18n;
    });

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
        return el.dataset.cmsKey || 'content';
    };

    var markEditable = function () {
        document.querySelectorAll('[data-cms-key]').forEach(function (el) {
            if (el.closest('.cms-toolbar, .cms-modal, .cms-editor')) {
                return;
            }
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

        if (event.currentTarget.closest('.cms-toolbar, .cms-modal, .cms-editor')) {
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
            type: tag === 'VIDEO' ? 'video' : tag === 'IMG' ? 'image' : tag === 'I' ? 'icon' : tag === 'A' || el.classList.contains('btn') ? 'button' : 'text',
        };

        openModalByType();
    };

    var openModalByType = function () {
        if (!state.current) {
            return;
        }

        if (state.current.type === 'video') {
            openVideoModal();
        } else if (state.current.type === 'image') {
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
            '<div class="col-4"><label class="form-label">Section BG Light</label><input type="color" class="form-control form-control-color w-100" id="cmsSectionBgLight" value="#ffffff"></div>' +
            '<div class="col-4"><label class="form-label">Section BG Dark</label><input type="color" class="form-control form-control-color w-100" id="cmsSectionBgDark" value="#000000"></div>' +
            '<div class="col-4"><label class="form-label">Section Overlay</label><input class="form-control" id="cmsSectionOverlay" placeholder="rgba(0,0,0,0.35)"></div>' +
            '<div class="col-12"><label class="form-label">Section BG Image URL</label><input class="form-control" id="cmsSectionBgImage" placeholder="https://..."></div>' +
            '<div class="col-12"><button type="button" class="btn btn-outline-danger btn-sm" id="cmsNoBackgroundBtn">No Background</button></div>' +
            '</div>';

        modal.show();

        var noBgBtn = document.getElementById('cmsNoBackgroundBtn');
        if (noBgBtn) {
            noBgBtn.addEventListener('click', function () {
                document.getElementById('cmsBgLight').value = '#ffffff';
                document.getElementById('cmsBgDark').value = '#000000';
                document.getElementById('cmsSectionBgImage').value = '__none__';
                document.getElementById('cmsSectionOverlay').value = '__none__';
                noBgBtn.dataset.noneBackground = '1';
                state.current.el.style.backgroundColor = 'transparent';
                state.current.el.style.backgroundImage = 'none';
            });
        }
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
        var currentWidth = state.current.el.style.width || state.current.el.getAttribute('width') || '';
        var currentHeight = state.current.el.style.height || state.current.el.getAttribute('height') || '';
        modalBody.innerHTML = '' +
            '<div class="mb-2"><label class="form-label">Upload Image</label><input type="file" class="form-control" id="cmsImageInput" accept="image/*"></div>' +
            '<div class="row g-2">' +
            '<div class="col-6"><label class="form-label">Aspect Ratio</label><select class="form-select" id="cmsAspect"><option value="free">Free</option><option value="1:1">1:1</option><option value="4:3">4:3</option><option value="16:9">16:9</option></select></div>' +
            '<div class="col-6"><label class="form-label">Background overlay</label><input type="number" step="0.05" min="0" max="1" class="form-control" id="cmsImageOverlay" value="0"></div>' +
            '<div class="col-6"><label class="form-label">Width</label><input class="form-control" id="cmsImageWidth" value="' + currentWidth + '" placeholder="e.g. 160px"></div>' +
            '<div class="col-6"><label class="form-label">Height</label><input class="form-control" id="cmsImageHeight" value="' + currentHeight + '" placeholder="e.g. 48px"></div>' +
            '</div>' +
            '<small class="text-muted mt-2 d-block">Crop is browser-based in this iteration (canvas preview + ratio lock).</small>' +
            '<canvas id="cmsCropCanvas" class="w-100 mt-2 border" style="max-height:200px;"></canvas>';

        bindImagePreview();
        modal.show();
    };

    var openVideoModal = function () {
        modalBody.innerHTML = '' +
            '<div class="mb-3"><label class="form-label">Upload Video</label><input type="file" class="form-control" id="cmsVideoInput" accept="video/mp4,video/webm,video/ogg"></div>' +
            '<div class="mb-3"><label class="form-label">Cover Image</label><input type="file" class="form-control" id="cmsVideoPosterInput" accept="image/*"></div>' +
            '<small class="text-muted d-block">Supported video types: MP4, WebM, OGG. Max video size: 200MB.</small>';

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
                var previewUrl = URL.createObjectURL(file);
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
                img.src = previewUrl;

                applyImageToMatchingElements(state.current.sectionKey, state.current.fieldKey, {
                    src: previewUrl,
                    url: previewUrl,
                }, {
                    width: document.getElementById('cmsImageWidth')?.value || null,
                    height: document.getElementById('cmsImageHeight')?.value || null,
                });
            });
        }, 0);
    };

    document.getElementById('cmsApplyBtn').addEventListener('click', function () {
        if (!state.current) return;

        if (state.current.type === 'image') {
            saveImageChanges();
            return;
        }

        if (state.current.type === 'video') {
            saveVideoChanges();
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
        var noneBackground = document.getElementById('cmsNoBackgroundBtn')?.dataset.noneBackground === '1';

        el.textContent = window.CMS_EDITOR.locale === 'ar' ? ar : en;
        el.style.fontSize = fontSize;
        el.style.lineHeight = lineHeight || '';
        el.style.textAlign = align;
        el.style.color = getMode() === 'dark' ? textDark : textLight;
        if (noneBackground) {
            el.style.background = 'none';
            el.style.backgroundImage = 'none';
        } else {
            el.style.backgroundColor = getMode() === 'dark' ? bgDark : bgLight;
        }
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
                background_color: noneBackground ? '__none__' : styleForModes(bgLight, bgDark),
            }
        });

        var sectionBgImage = document.getElementById('cmsSectionBgImage').value || null;
        var sectionOverlay = document.getElementById('cmsSectionOverlay').value || null;
        var sectionBgMode = styleForModes(
            document.getElementById('cmsSectionBgLight').value,
            document.getElementById('cmsSectionBgDark').value
        );

        if (sectionBgImage === '__none__' || sectionOverlay === '__none__') {
            sectionBgMode = '__none__';
            sectionBgImage = '__none__';
            sectionOverlay = '__none__';
        }

        queueSectionStyle(state.current.sectionKey, {
            background_color: sectionBgMode,
            background_image: sectionBgImage,
            overlay: sectionOverlay,
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
            content: { type: 'icon', value: iconClass },
            style: {
                color: styleForModes(iconColor, iconColor),
                size: iconSize,
            },
        });

        modal.hide();
    };

    var saveImageChanges = function () {
        var file = document.getElementById('cmsImageInput').files[0];
        var width = document.getElementById('cmsImageWidth').value;
        var height = document.getElementById('cmsImageHeight').value;
        var style = {
            overlay_opacity: document.getElementById('cmsImageOverlay').value,
            width: width || null,
            height: height || null,
        };

        applyImageToMatchingElements(state.current.sectionKey, state.current.fieldKey, {
            src: state.current.el.getAttribute('src'),
        }, style);

        if (!file) {
            queueChange(state.current.sectionKey, {
                field_key: state.current.fieldKey,
                content: {
                    type: 'image',
                    src: state.current.el.getAttribute('src'),
                    aspect_ratio: document.getElementById('cmsAspect').value,
                },
                style: style,
            });
            if (typeof window.aquaApplyCmsPage === 'function') {
                window.aquaApplyCmsPage();
            }
            modal.hide();
            return;
        }

        var form = new FormData();
        form.append('image', file);

        fetch(window.CMS_EDITOR.routes.uploadImage, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': window.CMS_EDITOR.csrf },
            body: form,
        })
            .then(function (response) {
                return response.json().then(function (payload) {
                    if (!response.ok || !payload.url) {
                        throw new Error(payload.message || 'Image upload failed.');
                    }

                    return payload;
                });
            })
            .then(function (payload) {
                applyImageToMatchingElements(state.current.sectionKey, state.current.fieldKey, {
                    src: payload.url,
                    url: payload.url,
                }, style);

                queueChange(state.current.sectionKey, {
                    field_key: state.current.fieldKey,
                    content: {
                        type: 'image',
                        path: payload.path,
                        src: payload.url,
                        aspect_ratio: document.getElementById('cmsAspect').value,
                    },
                    style: style,
                });
                if (typeof window.aquaApplyCmsPage === 'function') {
                    window.aquaApplyCmsPage();
                }
                modal.hide();
            })
            .catch(function (error) {
                alert(error.message || 'Image upload failed.');
            });
    };

    var saveVideoChanges = function () {
        var videoFile = document.getElementById('cmsVideoInput').files[0];
        var posterFile = document.getElementById('cmsVideoPosterInput').files[0];
        var currentSource = state.current.el.querySelector('source')?.getAttribute('src') || '';
        var currentPoster = state.current.el.getAttribute('poster') || '';
        var maxVideoSize = 200 * 1024 * 1024;

        if (videoFile && videoFile.size > maxVideoSize) {
            alert('Video is too large. Please upload a file up to 200MB.');
            return;
        }

        var uploadVideo = videoFile
            ? uploadCmsFile(window.CMS_EDITOR.routes.uploadVideo, 'video', videoFile)
            : Promise.resolve({ url: currentSource, path: null });

        var uploadPoster = posterFile
            ? uploadCmsFile(window.CMS_EDITOR.routes.uploadImage, 'image', posterFile)
            : Promise.resolve({ url: currentPoster, path: null });

        Promise.all([uploadVideo, uploadPoster])
            .then(function (results) {
                var videoPayload = results[0];
                var posterPayload = results[1];
                var content = {
                    type: 'video',
                    src: videoPayload.url || currentSource,
                    poster: posterPayload.url || currentPoster,
                };

                if (videoPayload.path) {
                    content.path = videoPayload.path;
                }

                if (posterPayload.path) {
                    content.poster_path = posterPayload.path;
                }

                applyVideoToMatchingElements(state.current.sectionKey, state.current.fieldKey, content);
                queueChange(state.current.sectionKey, {
                    field_key: state.current.fieldKey,
                    content: content,
                    style: {},
                });

                if (typeof window.aquaApplyCmsPage === 'function') {
                    window.aquaApplyCmsPage();
                }

                modal.hide();
            })
            .catch(function (error) {
                alert(error.message || 'Video upload failed.');
            });
    };

    var uploadCmsFile = function (route, fieldName, file) {
        var form = new FormData();
        form.append(fieldName, file);

        return fetch(route, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': window.CMS_EDITOR.csrf,
                'Accept': 'application/json',
            },
            body: form,
        })
            .then(function (response) {
                return response.text().then(function (text) {
                    var payload = {};

                    try {
                        payload = text ? JSON.parse(text) : {};
                    } catch (error) {
                        throw new Error('Upload failed. The server returned an HTML error page instead of JSON. Please check the file type and size.');
                    }

                    if (!response.ok || !payload.url) {
                        throw new Error(payload.message || Object.values(payload.errors || {}).flat().join(' ') || 'Upload failed.');
                    }

                    return payload;
                });
            });
    };

    var applyImageToMatchingElements = function (sectionKey, fieldKey, content, style) {
        var scope = document.querySelector('[data-cms-section="' + sectionKey + '"]') || document;

        scope.querySelectorAll('[data-cms-key="' + fieldKey + '"]').forEach(function (el) {
            if (el.tagName !== 'IMG') {
                return;
            }

            var src = content.src || content.url;
            if (src) {
                el.src = src;
                el.setAttribute('src', src);
                el.removeAttribute('srcset');
            }

            if (style?.width) {
                el.style.width = style.width;
            }

            if (style?.height) {
                el.style.height = style.height;
            }
        });
    };

    var applyVideoToMatchingElements = function (sectionKey, fieldKey, content) {
        var scope = document.querySelector('[data-cms-section="' + sectionKey + '"]') || document;

        scope.querySelectorAll('[data-cms-key="' + fieldKey + '"]').forEach(function (el) {
            if (el.tagName !== 'VIDEO') {
                return;
            }

            if (content.poster) {
                el.setAttribute('poster', content.poster);
            }

            if (content.src) {
                var source = el.querySelector('source');
                if (!source) {
                    source = document.createElement('source');
                    el.appendChild(source);
                }

                source.setAttribute('src', content.src);
                el.load();
            }

            el.closest('.appointment-video')?.querySelector('.appointment-video__placeholder')?.remove();
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
        syncBrowserCmsSection(sectionKey, change.field_key, change.content, change.style);
    };

    var syncBrowserCmsSection = function (sectionKey, fieldKey, content, style) {
        window.AQUA_CMS_PAGE = window.AQUA_CMS_PAGE || {};
        window.AQUA_CMS_PAGE[sectionKey] = window.AQUA_CMS_PAGE[sectionKey] || {
            content: {},
            style: {},
            is_visible: true,
            sort_order: 0,
        };
        window.AQUA_CMS_PAGE[sectionKey].content = window.AQUA_CMS_PAGE[sectionKey].content || {};
        window.AQUA_CMS_PAGE[sectionKey].style = window.AQUA_CMS_PAGE[sectionKey].style || {};
        window.AQUA_CMS_PAGE[sectionKey].content[fieldKey] = content;
        window.AQUA_CMS_PAGE[sectionKey].style[fieldKey] = style || {};
    };

    var queueSectionStyle = function (sectionKey, style) {
        state.pending[sectionKey] = state.pending[sectionKey] || {
            section_key: sectionKey,
            content_json: {},
            style_json: {},
        };

        state.pending[sectionKey].style_json.__section = style;
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
            .then(function (response) {
                return response.json().then(function (payload) {
                    if (!response.ok || payload.status !== 'saved') {
                        throw new Error(payload.message || 'CMS content was not saved.');
                    }

                    return payload;
                });
            })
            .then(function () {
                state.pending = {};
                alert('CMS content saved successfully.');
            })
            .catch(function (error) {
                alert(error.message || 'CMS content was not saved.');
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
        var noneBackground = document.getElementById('cmsNoBackgroundBtn')?.dataset.noneBackground === '1';
