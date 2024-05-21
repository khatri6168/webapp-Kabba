@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    <div id="customer-chart-widget-parent" class="mb-3 widget-item col-md-12">
        <div class="bg-white p-3"><h5>{{ trans('plugins/ecommerce::deliveries.name') }}</h5>
            <div style="display: flex; flex-direction: row; gap:20px; align-items: center;" class="side-bar">
                <button class="btn btn-success btn-sm today">Today</button>
                <button class="rounded-pill btn prev">
                    <img alt="prev" src="{{ url('vendor/core/plugins/ecommerce/images/ic-arrow-line-left.png') }}">
                </button>
                <button class="rounded-pill btn next">
                    <img alt="prev" src="{{ url('vendor/core/plugins/ecommerce/images/ic-arrow-line-right.png') }}">
                </button>
                <span style="margin-left: 1rem;font-size: 1.25rem;" class="range">2024-02</span>

                <div class="sidebar-item">
                    <input type="checkbox" id="delivery" value="delivery" checked />
                    <label class="checkbox checkbox-calendar checkbox-delivery" for="delivery">{{ trans('plugins/ecommerce::deliveries.delivery') }}</label>
                </div>
                <div class="sidebar-item">
                    <input type="checkbox" id="pickup" value="pickup" checked />
                    <label class="checkbox checkbox-calendar checkbox-pickup" for="pickup">{{ trans('plugins/ecommerce::deliveries.pickup') }}</label>
                </div>
                <div class="sidebar-item">
                    <input class="checkbox-all" type="checkbox" id="store_pickup" value="store_pickup" checked />
                    <label class="checkbox checkbox-all" for="store_pickup">{{ trans('plugins/ecommerce::deliveries.store_pickup') }}</label>
                </div>
                <div class="sidebar-item">
                    <input class="checkbox-all" type="checkbox" id="store_return" value="store_return" checked />
                    <label class="checkbox checkbox-all" for="store_return">{{ trans('plugins/ecommerce::deliveries.store_return') }}</label>
                </div>
                <div class="sidebar-item">
                    <input class="checkbox-all" type="checkbox" id="timeline" value="timeline" checked />
                    <label class="checkbox checkbox-all" for="timeline">{{ trans('plugins/ecommerce::deliveries.timeline') }}</label>
                </div>
                @foreach ($stores as $store)
                    <div class="sidebar-item" onclick="clickStore(this)" data-store="{{$store->id}}">
                        <input type="checkbox" class="store" id="{{$store->id}}" value="{{$store->id}}" data-color="{{$store->color}}" checked />
                        <label class="checkbox checkbox-calendar checkbox-{{$store->id}}" for="{{$store->id}}">{{ $store->name }}</label>
                    </div>
                @endforeach
            </div>
            <div id="calendar" style="height: 1000px;"></div>
        </div>
    </div>
@stop

@push('header')
    <style>
        .sidebar-item input[type="checkbox"]:not(.checkbox-all) {
            visibility: hidden;
        }

        .checkbox {
            position: relative;
        }

        .checkbox-calendar::before {
            content: "";
            position: absolute;
            left: -1.5rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 50%;
            border: 1px solid #ddd;
        }

        .checkbox.checkbox-delivery::before {
            background-color: var(--checkbox-delivery);
        }

        .checkbox.checkbox-pickup::before {
            background-color: var(--checkbox-pickup);
        }

        @foreach($stores as $store)
             .checkbox.checkbox-{{ $store->id }}::before {
                background-color: var(--checkbox-{{ $store->id }});
            }
        @endforeach

        /*.checkbox.checkbox-store_pickup::before {*/
        /*    background-color: var(--checkbox-store_pickup);*/
        /*}*/

        /*.checkbox.checkbox-store_return::before {*/
        /*    background-color: var(--checkbox-store_return);*/
        /*}*/

    </style>
@endpush

@push('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.45/moment-timezone-with-data.js"></script>
    <link rel="stylesheet" href="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.css" />
    <script src="https://uicdn.toast.com/calendar/latest/toastui-calendar.min.js"></script>
    <script>
        let deliveries = {!! json_encode($result) !!};

        for (let i = 0; i < deliveries.length; i++) {
            if (deliveries[i].storeId != null) {
                console.log(deliveries[i]);
            }
        }

        let maxCount = {!! $maxCount !!};

        let cal;
        let MOCK_CALENDARS = [
            {
                id: 'delivery',
                name: 'Delivery',
                backgroundColor: '#D50000',
            },
            {
                id: 'pickup',
                name: 'Pick Up',
                // color: '#000',
                backgroundColor: '#00BFA5',
            },
            {
                id: 'store_pickup',
                name: 'In Store Pick Up',
                backgroundColor: '#FF8A80',
            },
            {
                id: 'store_return',
                name: 'In Store Return',
                backgroundColor: '#A7FFEB',
            },
            {
                id: 'timeline',
                name: 'Timeline',
            },
        ];

        document.getElementById("calendar").style.height = `${(maxCount * 28 + 34) * 6 + 34}px`;

        function clickStore() {
            let delivery = $('#delivery').prop('checked');
            let pickup = $('#pickup').prop('checked');
            let timeline = $('#timeline').prop('checked');
            let store_pickup = $('#store_pickup').prop('checked');
            let store_return = $('#store_return').prop('checked');
            let stores = [];
            let checkboxes = $('.store');
            for (let i = 0; i < checkboxes.length; i++) {
                if ($(checkboxes[i]).prop('checked') == true) {
                    stores.push(checkboxes[i].value);
                }
            }
            let newDeliveries = [];

            for (let i = 0; i < deliveries.length; i++) {
                if (delivery == true && deliveries[i].type == 1) {
                    newDeliveries.push(deliveries[i]);
                }
                if (pickup == true && deliveries[i].type == 2) {
                    newDeliveries.push(deliveries[i]);
                }
                if (timeline == true && deliveries[i].type == 5) {
                    newDeliveries.push(deliveries[i]);
                }

                if (deliveries[i].type == 3 && store_pickup == true && stores.indexOf(`${deliveries[i]['storeId']}`) > -1) {
                    newDeliveries.push(deliveries[i]);
                }
                if (deliveries[i].type == 4 && store_return == true && stores.indexOf(`${deliveries[i]['storeId']}`) > -1) {
                    newDeliveries.push(deliveries[i]);
                }
            }

            cal.clear();
            cal.createEvents(newDeliveries);
        }

        function setCheckboxBackgroundColor(checkbox) {
            var calendarId = checkbox.value;
            var label = checkbox.nextElementSibling;
            var calendarInfo = MOCK_CALENDARS.find(function (cal) {
                return cal.id === calendarId;
            });

            if (!calendarInfo) {
                calendarInfo = {
                    backgroundColor: checkbox.getAttribute('data-color'),
                };
            }

            label.style.setProperty(
                '--checkbox-' + calendarId,
                checkbox.checked ? calendarInfo.backgroundColor : '#fff'
            );
        }

        function initCheckbox() {
            var checkboxes = $('input[type="checkbox"]');

            for (let i = 0; i < checkboxes.length; i++) {
                setCheckboxBackgroundColor(checkboxes[i]);
            }
        }

        $(document).ready(function () {
            moment().tz("America/Chicago").format();
            // data preprocessing
            for (let i = 0; i < deliveries.length; i ++) {
                // calendar type
                switch (deliveries[i].type) {
                    // delivery event
                    case '1':
                        deliveries[i].calendarId = 'delivery';
                        deliveries[i].category = 'time';
                        break;
                    // pickup event
                    case '2':
                        deliveries[i].category = 'time';
                        deliveries[i].calendarId = 'pickup';
                        break;
                    // customer delivery (in store pickup)
                    case '3':
                        deliveries[i].category = 'time';
                        deliveries[i].calendarId = 'store_pickup';
                        break;
                    // customer pickup (in store return)
                    case '4':
                        deliveries[i].category = 'time';
                        deliveries[i].calendarId = 'store_return';
                        // deliveries[i].backgroundColor = ''
                        break;
                    // timeline
                    case '5':
                        deliveries[i].category = 'allday';
                        deliveries[i].isAllday = true;
                        deliveries[i].calendarId = 'timeline';
                        break;
                    default:
                        deliveries[i].category = 'allday';
                        deliveries[i].isAllday = true;
                        deliveries[i].calendarId = 'timeline';
                }

                // calculate location
                let location = deliveries[i].address + ', ' + deliveries[i].city + ', ' + deliveries[i].state + ', ' + deliveries[i].zip_code;
                deliveries[i].location = "<a target='_blank' href='https://maps.google.com/?q=" + location + "'> " +
                    "<a target='_blank' href='https://maps.apple.com/maps?q=" + location +"'>" +
                    location + "</a></a>";

                // replace state with phone
                let phone = deliveries[i].phone;
                let phoneString = '<a href="tel:' + phone.replace(/[()\s]/g, '') + '">' + deliveries[i].phone + '</a>';
                let stateBtn = '';
                if (deliveries[i].type == 1 || deliveries[i].type == 2 || deliveries[i].type == 3 || deliveries[i].type == 4) {
                    let disabled = '';
                    if (deliveries[i].disabled == 1) {
                        disabled = 'disabled';
                    }
                    stateBtn = `<select  class="state" ${disabled} data-id=${deliveries[i].id} data-type="${deliveries[i].type}" style="border-radius:4px;width:80px;margin-left: 15px;padding:0;padding-left:4px;padding-right:0;"><option value=1>Pending</option><option value=2>Completed</option></select>`;
                } else {
                    stateBtn = `<select class="state" data-id=${deliveries[i].id} data-type="${deliveries[i].type}" style="visibility:hidden; border-radius:4px;width:80px;margin-left: 15px;padding:0;padding-left:4px;padding-right:0;"><option value=1>Pending</option><option value=2>Completed</option></select>`;
                }

                let viewMore = '<a class="label-info status-label font-size-11px" style="margin-left: 10px;" href="/admin/ecommerce/deliveries/edit/' + deliveries[i].id + '" target="_blank">Order</a>';
                deliveries[i].state = phoneString + stateBtn + viewMore;

                // set attendees with name
                deliveries[i].attendees = [deliveries[i].name];

                // set border color
                if (deliveries[i]['type'] == 5) {
                    deliveries[i].borderColor = deliveries[i].backgroundColor;
                } else {
                    deliveries[i].borderColor = 'white';
                }

                // deliveries[i].borderColor = deliveries[i].backgroundColor;
                // set title with name
                deliveries[i].title = deliveries[i].product_name;
                deliveries[i].isReadOnly = true;
            }

            const Calendar = tui.Calendar;
            cal = new Calendar('#calendar', {
                usageStatistics: false,
                isReadOnly: true,
                defaultView: 'month',
                useDetailPopup: true,
                template: {
                    time(event) {
                        const { calendarId, title, time, } = event;
                        if (calendarId == 'pickup' || calendarId == 'delivery' || calendarId == 'store_pickup' || calendarId == 'store_return') {
                            return `<span style="color: #424242;">${title}</span>`;
                        } else {
                            return `<span style="color: white;">${title}</span>`;
                        }
                    },
                    allday(event) {
                        const { calendarId, title, backgroundColor } = event;
                        if (backgroundColor > '#888888') {
                            return `<span style="color: #424242;">${title}</span>`;
                        }
                        return `<span style="color: white;">${title}</span>`;
                    },
                    milestone(event) {
                        const { calendarId, title } = event;
                        return `<span style="color: white;">${title}</span>`;
                    },
                    task(event) {
                        const { calendarId, title } = event;
                        return `<span style="color: white">${title}</span>`;
                    },
                    popupDetailDate({ start, end }) {
                        let startDate = moment(start.toString()).format('MMM D, YYYY');
                        let endDate = moment(end.toString()).format('MMM D, YYYY');
                        if (startDate == endDate) {
                            startDate = moment(start.toString()).format('MMM D, YYYY hh:mm A');
                            return `${startDate}`;
                        } else {
                            return `${startDate} - ${endDate}`;
                        }
                    },
                },
                calendars: [
                    {
                        id: 'delivery',
                        name: 'Delivery',
                        backgroundColor: '#D50000',
                    },
                    {
                        id: 'pickup',
                        name: 'Pick Up',
                        // color: '#000',
                        backgroundColor: '#00BFA5',
                    },
                    {
                        id: 'store_pickup',
                        name: 'In Store Pick Up',
                        backgroundColor: '#FF8A80',
                    },
                    {
                        id: 'store_return',
                        name: 'In Store Return',
                        backgroundColor: '#A7FFEB',
                    },
                    {
                        id: 'duration',
                        name: 'Duration',
                    },
                ],
                month: {
                    visibleEventCount: 100,
                }
            });

            cal.createEvents(deliveries);

            function getNavbarRange(tzStart, tzEnd, viewType) {
                var start = tzStart.toDate();
                var end = tzEnd.toDate();
                var middle;
                if (viewType === 'month') {
                    middle = new Date(start.getTime() + (end.getTime() - start.getTime()) / 2);
                    return moment(middle).format('MMM, Y');
                }
                if (viewType === 'day') {
                    return moment(start).format('YYYY-MM-DD');
                }
                if (viewType === 'week') {
                    return moment(start).format('YYYY-MM-DD') + ' ~ ' + moment(end).format('YYYY-MM-DD');
                }
                throw new Error('no view type');
            }

            function displayRenderRange() {
                $('.range').text(getNavbarRange(cal.getDateRangeStart(), cal.getDateRangeEnd(), 'month'));
            }

            $('.today').on('click', function () {
                cal.today();
                // displayEvents();
                displayRenderRange();
            });

            $('.prev').on('click', function () {
                cal.prev();
                displayRenderRange();
            });

            $('.next').on('click', function () {
                cal.next();
                displayRenderRange();
            });

            displayRenderRange();

            document.getElementsByClassName('toastui-calendar-event-detail-popup-slot')[0].addEventListener( 'DOMNodeInserted', function ( event ) {
                $('.state', $(event.target)).on('change', function (ev) {
                    $.ajax({
                        url: '/admin/ecommerce/deliveries/update-status',
                        type: 'post',
                        data: {
                            id: ev.target.getAttribute('data-id'),
                            type: ev.target.getAttribute('data-type'),
                            status: ev.target.value,
                            action_name: 'save_and_calendar',
                        },
                        success: (data) => {
                            if (data.error) {
                                Botble.showError(data.message)

                                if (data.data && data.data.redirect) {
                                    window.location.href
                                }
                            } else {
                                Botble.showSuccess(data.message)
                                setTimeout(() => {
                                    window.location.reload()
                                }, 2000)
                            }
                        },
                        error: (data) => {

                        },
                    })
                });
            }, false );

            var appState = {
                activeCalendarIds: MOCK_CALENDARS.map(function (cal) {
                    return cal.id;
                }),
                isDropdownActive: false,
            };

            let sidebar = $('.side-bar');
            sidebar.on('click', function (e) {
                if ('value' in e.target) {
                    if (e.target.value === 'all') {
                        if (appState.activeCalendarIds.length > 0) {
                            cal.setCalendarVisibility(appState.activeCalendarIds, false);
                            appState.activeCalendarIds = [];
                        } else {
                            appState.activeCalendarIds = MOCK_CALENDARS.map(function (cal) {
                                return cal.id;
                            });
                            cal.setCalendarVisibility(appState.activeCalendarIds, true);
                        }
                    } else if (appState.activeCalendarIds.indexOf(e.target.value) > -1) {
                        appState.activeCalendarIds.splice(appState.activeCalendarIds.indexOf(e.target.value), 1);
                        clickStore();
                        cal.setCalendarVisibility(e.target.value, false);
                        setCheckboxBackgroundColor(e.target);
                    } else {
                        appState.activeCalendarIds.push(e.target.value);
                        clickStore();
                        cal.setCalendarVisibility(e.target.value, true);
                        setCheckboxBackgroundColor(e.target);
                    }
                }
            });
            initCheckbox();
        });
    </script>
@endpush
