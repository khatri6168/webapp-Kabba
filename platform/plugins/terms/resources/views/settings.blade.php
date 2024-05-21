<x-core-setting::section
    :title="trans('plugins/terms::terms.settings.title')"
    :description="trans('plugins/terms::terms.settings.description')"
>
    <x-core-setting::checkbox
        name="enable_terms_schema"
        :label="trans('plugins/terms::terms.settings.enable_terms_schema')"
        :checked="setting('enable_terms_schema', false)"
        :helper-text="trans('plugins/terms::terms.settings.enable_terms_schema_description')"
    />
</x-core-setting::section>
