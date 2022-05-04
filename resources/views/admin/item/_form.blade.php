@push('js')
    <script src="{{ asset('components/ckeditor4/ckeditor.js') }}"></script>
    <script src="{{ asset('components/ckeditor4/config-full.js') }}"></script>
@endpush

@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

{!! BootForm::hidden('id') !!}

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link active" href="#tab-content" data-target="#tab-content" data-toggle="tab">{{ __('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#tab-meta" data-target="#tab-meta" data-toggle="tab">{{ __('Meta') }}</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade show active" id="tab-content">
        <file-manager related-table="{{ $model->getTable() }}" :related-id="{{ $model->id ?? 0 }}"></file-manager>
        <file-field  type="image" field="image_id" :init-file="{{ $model->image ?? 'null' }}"></file-field>
        <files-field :init-files="{{ $model->files }}"></files-field>
        <div class="form-row">
            <div class="col-md-6">
                {!! TranslatableBootForm::text(__('Title'), 'title') !!}
            </div>
            <div class="col-md-6">
                @include('core::form._slug')
            </div>
            <div class="col-md-6">
                {!! TranslatableBootForm::text(__('Youtube Code'), 'url') !!}
            </div>
            <div class="col-sm-6">
                {!! BootForm::date(__('Show Date'), 'show_date')->value(old('show_date') ? : $model->present()->dateOrNow('start_date'))->addClass('datepicker')->required() !!}
            </div>
        </div>
        <div class="form-group">
            {!! TranslatableBootForm::hidden('status')->value(0) !!}
            {!! TranslatableBootForm::checkbox(__('Published'), 'status') !!}
        </div>
        <div class="form-group">
            {!! TranslatableBootForm::hidden('show_homepage')->value(0) !!}
            {!! TranslatableBootForm::checkbox(__('Show Homepage'), 'show_homepage') !!}
        </div>
        {!! BootForm::select(__('Category'), 'category_id', Videocategories::allForSelect())->addClass('custom-select')->required() !!}
        {!! TranslatableBootForm::textarea(__('Body'), 'body')->addClass('ckeditor-full') !!}
</div>
<div class="tab-pane fade" id="tab-meta">
    {!! TranslatableBootForm::text(__('Meta title'), 'meta_title') !!}
    {!! TranslatableBootForm::text(__('Meta keywords'), 'meta_keywords') !!}
    {!! TranslatableBootForm::text(__('Meta description'), 'meta_description') !!}
</div>
</div>
