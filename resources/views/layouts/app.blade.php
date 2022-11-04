<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$title ?? 'Welcome'}} | {{config('app.name')}}</title>

        @include('layouts.components.favicon')
        @include('layouts.components.seo')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <style type="text/css">

body, p, input, .form-control {
    font-family: 'Varela Round', sans-serif;
}

h3, h4, h5, h6, button, .btn, label, .label, .navbar .nav-link, .font-cursive {
    font-family: 'Fredoka One', cursive;
}

h1, h2 {
    font-family: 'LuckiestGuy', sans-serif;
    letter-spacing: .5px;
}
 
h1, h2, button {
    -webkit-text-stroke: 2px black;
}

h3, h4, h5, h5, .btn, button, .nav-link {
    -webkit-text-stroke: 1px black;
}

h6, label, .label {
    -webkit-text-stroke: .5px black;
}

a {
    -webkit-text-stroke: inherit;
}

.no-stroke {
    -webkit-text-stroke: 0 !important;
}


.setlist-counter {
    width: 90%;
    max-width: 900px;
    position: relative;
}

.setlist-counter-fill {
    background: #f2cd3d !important;
    min-width: 37px;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    color: #b32743 !important;
    font-weight: bold;
}

.table-row:nth-of-type(even) {
   background: rgba(0,0,0,0.08);
 }

.table-row:hover {
    background: rgba(0,0,0,0.1) !important;
}

.table-row > div {
    width: 95%;
}

.offcanvas.offcanvas-end {
    width: auto;
    min-width: 300px;
}
      @keyframes blinking {
        0% {
          opacity: 0.7;
        }
        50% {
          opacity: 1;
        }
        100% {
          opacity: .7;
        }
      }

      .blink {
        animation: blinking 1s infinite;
      }

      .pagination .page-link {
        padding: .7rem !important;
        background: transparent;
        border: 0;
      }


      .ui-icon.ui-icon-circle-triangle-w {
        background-image: url({{asset('images/icons/arrow-left.svg')}});
        background-position: 0 !important;
      }
      .ui-icon.ui-icon-circle-triangle-e {
        background-image: url({{asset('images/icons/arrow-right.svg')}});
        background-position: 0 !important;
      }

        </style>
<script>
    window.app = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'url' => \Request::root(),
        'route' => \Request::route()->getName(),
        'user' => auth()->check() ? auth()->user() : null
    ]); ?>
</script>

        @stack('header')
    </head>
    <body class="bg-primary">
        @include('layouts.header')

        <div id="page-content">
            
            @yield('content')
        
        </div>

        @include('layouts.footer')

        @include('layouts.components.alerts')

        @unless(auth()->check())
        @include('auth.login.modal')
        @endunless

        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="{{mix('js/vendor/datepicker-pt-BR.js')}}"></script>

<script type="text/javascript">
//////////////////////
// GLOBAL VARIABLES //
//////////////////////

var sortable, sorting;

if (app.user) {
    if (app.user.is_admin) {
        listenToEvents();
    } else {
        getUserAlert();
    }
}

function listenToEvents()
{
    window.Echo
          .channel('setlist')
          .listen('SongRequested', function(event) {
            if (app.route == 'setlists.admin') {
                getEventTable();
            } else {
                getAdminAlert();
            }
          });

    window.Echo
          .channel('setlist')
          .listen('SongCancelled', function(event) {
            if (app.route == 'setlists.admin') {
                getEventTable();
            }
          });
}

function stopListening()
{
    Echo.channel('setlist')
        .stopListening('SongRequested');

    Echo.channel('setlist')
        .stopListening('SongCancelled');
}

function getUserAlert()
{
    axios.get('{!! route('setlists.alert.user') !!}')
         .then(function(response) {
            $('body').append(response.data);
         })
         .catch(function(error) {
            alert(error);
         });
}

function getEventTable(newOrder = null)
{
    axios.get('{!! route('setlists.table') !!}', {params: {newOrder: newOrder}})
        .then(function(response) {

            $('#setlist-container').html(response.data);

            if (newOrder) {
                listenToEvents();
                enableDraggable();
            }
        })
        .catch(function(error) {
            log(error);
        });
}

function getAdminAlert()
{
    axios.get('{!! route('setlists.alert.admin') !!}')
        .then(function(response) {
            $('body').append(response.data);
        })
        .catch(function(error) {
            log(error);
        });
}

function enableDraggable() {
    sorting = false;

    sortable = new Sortable(setlist, {
        animation: 150,
        filter: '.btn, .modal',
        forceFallback: true,
        scrollSensitivity: 120,
        ghostClass: 'dragged',

        onUpdate: function (e) {
            sorting = true;
            stopListening();
        },

        onEnd: function (e) {
            if (sorting)
                sortable.option("disabled", true);

            let newOrder = [];

            $(e.to).children().each(function(index) {
                newOrder.push({id: $(this).data('id'), order: index});
            });

            getEventTable(newOrder);
        },
    });    
}

</script>

<script type="text/javascript">
$('.load-more').click(function() {
    let $remaining = $(this).nextAll();
    let $slice = $(this).nextAll().slice(0,4);

    $slice.insertBefore(this)
    $slice.show();

    if($remaining.length == $slice.length)
        $(this).remove();
});
</script>

<script type="text/javascript">
       $(document).on('keypress', '[data-datepicker]', function(e){
            e.preventDefault();
        });

        $(document).ready(function() {
            enableTimepicker();
            enableDatepicker();
        });

        function enableTimepicker(container = '')
        {
            $(container + ' [data-timepicker] button').on('click', function() {
                let $button = $(this);
                let $current = $button.siblings('.timepicker-times').children(':visible');
                let name = $current.data('name');
                let $input = $($current.data('input'));

                if ($button.data('target') == 'next') {
                    if ($current.next().length) {
                        $current.next().show();
                        $current.hide();
                    }
                } else {
                    if ($current.prev().length) {
                        $current.prev().show();
                        $current.hide();
                    }
                }

                let minute = $('.timepicker-times [data-name="'+name+'"][data-type="minute"]:visible').text();
                let hour = $('.timepicker-times [data-name="'+name+'"][data-type="hour"]:visible').text();
                let time = hour+':'+minute;

                $input.val(time);
            });
        }

        function enableDatepicker()
        {
            $('[data-datepicker]').each(function() {
                let $element = $(this);
                $element.datepicker({
                    // defaultDate: new Date($element.data('datepicker')),
                    onSelect: function() {
                        if ($element.attr('data-input'))
                            $($element.data('input')).val(this.value);
                    }
                });
            });
        }
</script>
        @stack('scripts')
    </body>
</html>
