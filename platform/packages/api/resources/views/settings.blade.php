@extends(BaseHelper::getAdminMasterLayoutTemplate())

@section('content')
    <div class="max-width-1200">
        {!! Form::open(['route' => ['api.settings.update']]) !!}
        <x-core-setting::section :title="trans('packages/api::api.setting_title')" :description="trans('packages/api::api.setting_description')">
            <x-core-setting::on-off name="api_enabled" :label="trans('packages/api::api.api_enabled')" :value="ApiHelper::enabled()" />
        </x-core-setting::section>

        <div class="flexbox-annotated-section" style="border: none">
            <div class="flexbox-annotated-section-annotation">&nbsp;</div>
            <div class="flexbox-annotated-section-content">
                <button class="btn btn-info" type="submit">{{ trans('packages/api::api.save_settings') }}</button>
            </div>
        </div>
        {!! Form::close() !!}

        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs mb-0 border-0 " id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active text-white bg-secondary" id="service-tab" data-toggle="tab"
                            href="#services" role="tab" aria-controls="services" aria-selected="true">API Services</a>
                    </li>
                </ul>
                <div class="card border-0">
                    <div class="tab-content card-body" id="myTabContent">
                        <div class="tab-pane fade show active" id="services" role="tabpanel" aria-labelledby="service-tab">
                            @php
                                $records = \DB::table('api_informations')->get();
                            @endphp
                            @if (count($records) > 0)
                                @foreach ($records as $item)
                                    <div class="">
                                        <p>
                                            <h5>{{ $item->title }}</h5>
                                        </p>
                                        <p>{{ $item->description }}</p>
                                        <p>
                                            <i class="fas fa-external-link-alt"></i>
                                            <a href="{{ $item->link }}" target="_blank">{{ $item->link_text }}</a>
                                        </p>
                                    </div>
                                    <hr class="bg-danger border-2 border-top border-primary" />
                                @endforeach
                            @else
                                <h5 class="text-danger">No Data found.</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
