@php
    $cmsCanEdit = auth()->check() && (bool) data_get(auth()->user(), 'is_admin', false) && (bool) data_get(auth()->user(), 'status', false);
    $cmsPageKey = str_replace('.', '-', Route::currentRouteName() ?? trim(request()->path(), '/') ?: 'home');
@endphp

@if($cmsCanEdit)
    <link href="{{ asset('css/cms-editor.css') }}" rel="stylesheet">

    <div class="cms-topbar cms-toolbar cms-editor" id="cmsTopbar">
        <div class="cms-topbar__group">
            <button class="btn btn-sm btn-light" id="cmsTogglePreview">Preview ON</button>
            <button class="btn btn-sm btn-success" id="cmsSaveBtn">Save</button>
            <button class="btn btn-sm btn-outline-light" id="cmsDiscardBtn">Discard</button>
        </div>
        <div class="cms-topbar__group">
            <span class="badge bg-dark">Text</span>
            <span class="badge bg-dark">Image</span>
            <span class="badge bg-dark">Colors</span>
            <span class="badge bg-dark">Buttons</span>
            <span class="badge bg-dark">Sections</span>
        </div>
    </div>

    <div class="modal fade cms-modal cms-editor" id="cmsEditModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CMS Editor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="cmsModalBody"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="cmsApplyBtn">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.CMS_EDITOR = {
            pageKey: @json($cmsPageKey),
            csrf: @json(csrf_token()),
            routes: {
                save: @json(route('admin.cms.save')),
                uploadImage: @json(route('admin.cms.upload-image')),
            },
            locale: @json(app()->getLocale()),
        };
    </script>
    <script src="{{ asset('js/cms-editor.js') }}"></script>
@endif
