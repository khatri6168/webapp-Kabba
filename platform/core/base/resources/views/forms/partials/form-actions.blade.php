@if (Request::segment(3) != 'reply')
<div class="widget meta-boxes form-actions form-actions-default action-{{ $direction ?? 'horizontal' }}">
    <div class="widget-title">
        <h4>
            @if (!empty($icon))
                <i class="{{ $icon }}"></i>
            @endif
            <span>{{ $title ?? apply_filters(BASE_ACTION_FORM_ACTIONS_TITLE, trans('core/base::forms.publish')) }}</span>
        </h4>
    </div>
    <div class="widget-body">
        <div class="btn-set">
            @php do_action(BASE_ACTION_FORM_ACTIONS, 'default') @endphp
            @if (!isset($onlySave) || ! $onlySave)
                <button type="submit" name="submit" value="save" class="btn btn-info">
                    <i class="{{ $saveIcon ?? 'fa fa-save' }}"></i> {{ $saveTitle ?? trans('core/base::forms.save') }}
                </button>
            @endif
            &nbsp;
            <button type="submit" name="submit" value="apply" class="btn btn-success">
                <i class="fa fa-check-circle"></i> {{ trans('core/base::forms.save_and_continue') }}
            </button>
            @if (request()->is('admin/ecommerce/options/edit*'))
                <button type="submit" name="submit" value="save_as_new" class="btn btn-warning">
                    {{-- <i class="fa fa-check-circle"></i> --}} Save as New
                </button>
            @endif
            @if (request()->is('admin/customers/edit*'))
                &nbsp;
                <button type="submit" name="submit" value="login" class="btn btn-danger">
                     <i class="fa fa-sign-in"></i>  Login
                </button>
            @endif
        </div>
    </div>
</div>
<div id="waypoint"></div>
<div class="form-actions form-actions-fixed-top hidden">
    {!! Breadcrumbs::render('main', PageTitle::getTitle(false)) !!}
    <div class="btn-set">
        @php do_action(BASE_ACTION_FORM_ACTIONS, 'fixed-top') @endphp
        @if (!isset($onlySave) || !$onlySave)
            <button type="submit" name="submit" value="save" class="btn btn-info">
                <i class="{{ $saveIcon ?? 'fa fa-save' }}"></i> {{ $saveTitle ?? trans('core/base::forms.save') }}
            </button>
        @endif

        &nbsp;
        <button type="submit" name="submit" value="apply" class="btn btn-success">
            <i class="fa fa-check-circle"></i> {{ trans('core/base::forms.save_and_continue') }}
        </button>
    </div>
</div>
@endif
<script>
    $('button[name="submit"]').click(function(){
        var currentval = $(this).val();
        console.log($(this).val());
        $( document ).ajaxComplete(function(e, xhr, settings) {
            var url = settings.url
            var splitUrl = url.split("/")
            if(currentval == 'save'){
             $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(1)').trigger('click');
                //$('form').submit();
            }
            if(currentval == 'apply'){
             $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(2)').trigger('click');
                //$('form').submit();
            }
            if(currentval == 'save_as_new'){
             $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(3)').trigger('click');
                //$('form').submit();
            }
            if(currentval == 'login'){
                $('#botble-ecommerce-forms-global-option-form button[name="submit"]:nth-child(4)').trigger('click');
                //$('form').submit();
            }
        });
    })
</script>
