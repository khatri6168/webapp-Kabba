@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    {!! Form::open(['class' => 'form-import-data', 'files' => 'true']) !!}
        <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-8 col-lg-10 col-12">
                <div class="widget meta-boxes">
                    <div class="widget-title pl-2">
                        <h4>Import Contacts</h4>
                    </div>
                    <div class="widget-body">

                        <div class="form-group mb-3 @if ($errors->has('file')) has-error @endif">
                            <label class="control-label required" for="input-group-file">
                                {{ trans('plugins/ecommerce::bulk-import.choose_file') }}
                            </label>
                            {!! Form::file('file', [
                                'id' => 'input-group-file',
                                'class' => 'form-control',
                                'required' => true,
                                'aria-describedby' => 'input-group-addon',
                            ]) !!}
                            <label class="d-block mt-1 help-block" for="input-group-file">
                                {{ trans('plugins/ecommerce::bulk-import.choose_file_with_mime', ['types' =>  implode(', ', config('plugins.ecommerce.general.bulk-import.mimes', []))])}}
                            </label>

                            {!! Form::error('file', $errors) !!}
                            <div class="mt-3 text-center p-2 border bg-light">
                                <a href="http://rentnking.com/csv/samplefile.csv" class="buttons-csv download-template"
                                    data-url="http://rentnking.com/csv/samplefile.csv"
                                    data-extension="csv"
                                    download
                                    data-filename="template_contacts_import.csv"
                                    data-downloading="<i class='fas fa-spinner fa-spin'></i> {{ trans('plugins/ecommerce::bulk-import.downloading') }}">
                                    <i class="fas fa-file-csv"></i>
                                    {{ trans('plugins/ecommerce::bulk-import.download-csv-file') }}
                                </a> &nbsp; | &nbsp;
                                <a href="http://rentnking.com/csv/template_contact_import.xlsx" class="download-template"
                                    data-url="http://rentnking.com/csv/template_contact_import.xlsx"
                                    data-extension="xlsx"
                                    data-filename="template_contact_import.xlsx"
                                    data-downloading="<i class='fas fa-spinner fa-spin'></i> {{ trans('plugins/ecommerce::bulk-import.downloading') }}">
                                    <i class="fas fa-file-excel"></i>
                                    {{ trans('plugins/ecommerce::bulk-import.download-excel-file') }}
                                </a>
                            </div>
                        </div>
                        <div class="form-group mb-3 d-grid">
                            <button type="submit" class="btn btn-info"
                                    data-choose-file="{{ trans('plugins/ecommerce::bulk-import.please_choose_the_file')}}"
                                    data-loading-text="{{ trans('plugins/ecommerce::bulk-import.loading_text') }}"
                                    data-complete-text="{{ trans('plugins/ecommerce::bulk-import.imported_successfully') }}"
                                    id="input-group-addon">
                                {{ trans('plugins/ecommerce::bulk-import.start_import') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="hidden main-form-message">
                    <p id="imported-message"></p>
                    <div class="show-errors hidden">
                        <h3 class="text-warning text-center">{{ trans('plugins/ecommerce::bulk-import.failures') }}</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th scope="col">#{{ trans('plugins/ecommerce::bulk-import.row') }}</th>
                                  <th scope="col">{{ trans('plugins/ecommerce::bulk-import.attribute') }}</th>
                                  <th scope="col">{{ trans('plugins/ecommerce::bulk-import.errors') }}</th>
                                </tr>
                            </thead>
                            <tbody id="imported-listing">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="widget meta-boxes">
        <div class="widget-title pl-2">
            <h4 class="text-info">{{ trans('plugins/ecommerce::bulk-import.template') }}</h4>
        </div>
        <div class="widget-body">
            <div class="table-responsive">
                <table class="table text-start table-striped table-bordered">
                    <thead>
                        <tr>
                            @foreach ($headings as $heading)
                                <th>{{ $heading }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($data as $product)
                            <tr>
                                @foreach ($headings as $k => $h)

                                    <td>{{ Arr::get($product, $h) }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script type="text/x-custom-template" id="failure-template">
        <tr>
            <td scope="row">__row__</td>
            <td>__attribute__</td>
            <td>__errors__</td>
        </tr>
    </script>
@stop
