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
* {
  touch-action: manipulation;
}
  
.plyr__controls { display: none!important }

.bg-transparent {
    background: rgba(0,0,0,0.1) !important;
}

body, p, input, .form-control {
    font-family: 'Nunito', sans-serif;
}

p {
    font-weight: bold;
}

h3, h4, h5, h6, button, .btn, label, .label, .navbar .nav-link, .font-cursive {
    font-family: 'Fredoka One', cursive;
}

h1, h2 {
    font-family: 'LuckiestGuy', sans-serif;
    letter-spacing: .5px;
}
 
h1, h2, button, .stroke-bold {
    -webkit-text-stroke: 2px black;
}

h3, h4, h5, h5, .btn, button, .nav-link, .stroke-light {
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

.table-cell *:not(img, .no-truncate) {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.striped-row:nth-of-type(odd) {
   background: rgba(0,0,0,0.08);
 }

.striped-row:hover {
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
        'user' => auth()->check() ? auth()->user() : null,
        'gig' => auth()->check() ? auth()->user()->liveGig() : null
    ]); ?>
</script>

        @stack('header')
    </head>
    <body class="bg-primary">
            @auth
            @unless(isset($raw))
            @include('pages.gigs.banner')
            @endunless
            @endauth
        <div class="position-relative">
            @unless(isset($raw))
            @include('layouts.header')
            @endunless

            <div id="page-content">
                
                @yield('content')
            
            </div>

            @unless(isset($raw))
            @include('layouts.footer')
            @endunless
        </div>
        @include('layouts.components.alerts')

        @if($modal = session('modal'))
        @include($modal)
        @php(session()->forget('modal'))
        @endif

        @unless(auth()->check())
        @include('auth.login.modal')
        @endunless

        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="{{mix('js/vendor/datepicker-pt-BR.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/vendor/jquery.jscroll.min.js')}}"></script>
<script type="text/javascript">

function enableScroll()
{
    $('ul.pagination').parent().hide();

    $('.artists-container').jscroll({
        loadingHtml: '<div class="text-center"><div class="spinner-border opacity-4 text-white"></div></div>',
        autoTrigger: true,
        padding: 0,
        nextSelector: '.pagination li.active + li a',
        contentSelector: '.artists-container',
        callback: function() {
            $('ul.pagination').parent().remove();
        }
    });

    $('.results-container').jscroll({
        loadingHtml: '<div class="text-center"><div class="spinner-border opacity-4 text-white"></div></div>',
        autoTrigger: true,
        padding: 0,
        debug: true,
        nextSelector: '.pagination li.active + li a',
        contentSelector: '.results-container',
        callback: function() {
            $('ul.pagination').parent().remove();
        }
    });
}

function clearResults(container = null)
{
    if (container) {
        $(container).html('');
    } else {
        $('#results').html('');
        $('#change-results').html('');
        $('.artists-container').show();
    }

    url([]);
    $('input[name="search"]').val('');
}

function showResults(targetId, data)
{
    $(targetId).parent().find('.artists-container').hide();
    $(targetId).html(data);
}

function search(targetId, url, table, paginate, input)
{
    axios.get(url, { params: { input: input, table: table, paginate: paginate } })
         .then(function(response) {
            showResults(targetId, response.data);
            enableScroll();
         })
         .catch(function(error) {
            log(error);
        });
}

$(document).ready(function() {
    $(document).on('keyup', 'input[name="search"]', function() {
        let input = $(this).val();
        url(['input', input]);

        if (input.length == 0) {
            clearResults();
            $('.artists-container').show();
        } else if (input.length >= 3) {
            search($(this).data('target'), $(this).data('url'), $(this).data('table'), $(this).data('paginate'), input);
        }
    });
});

$(document).on('click', '#clear-results', function() {
    clearResults();
});

$(document).on('hidden.bs.modal', '.song-request-modal', function (e) {
  clearResults('#change-results');
});
</script>

<script type="text/javascript">
var sortable, sorting;

if (app.user && app.gig) {
    if (app.user.is_admin) {
        listenToEvents();
    } else {
        getUserAlert();
    }
}

function listenToEvents()
{
    try {
    window.Echo
          .channel('setlist')
          .listen('SongRequested', function(event) {
                getEventTable();
          });

    window.Echo
          .channel('setlist')
          .listen('SongCancelled', function(event) {
                getEventTable();
          });
    } catch(error) {
        log(error);
        alert('Erro com o Pusher!!! ' + error);
    }
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
    axios.get('{!! route('setlists.alert') !!}')
         .then(function(response) {
            $('body').append(response.data);
         })
         .catch(function(error) {
            alert(error);
         });
}

function getEventTable(newOrder = null)
{
    if ($('#setlist-container').length) {
    axios.get('{!! route('setlists.table') !!}', {params: {newOrder: newOrder}})
        .then(function(response) {
            $('#setlist-container').html(response.data);
            
            enableDraggable();
            
            if (newOrder)
                listenToEvents();
        })
        .catch(function(error) {
            log(error);
        });
    }
}

function disableDraggable() {
    sortable.option("disabled", true);
}

function enableDraggable() {
    sorting = false;

    sortable = new Sortable(setlist, {
        animation: 150,
        filter: '.btn, .btn-raw, .modal',
        forceFallback: true,
        scrollSensitivity: 120,
        ghostClass: 'dragged',

        onUpdate: function (e) {
            sorting = true;
            stopListening();
        },

        onEnd: function (e) {
            if (sorting)
                disableDraggable();

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
$(document).ready(function() {
    $('.modal-autoshow').modal('show');
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
                    minDate: new Date(),
                    dateFormat: 'dd/mm/yy',
                    defaultDate: moment($element.data('datepicker'), 'DD/MM/YYYY')._d,
                    onSelect: function() {
                        if ($element.attr('data-input'))
                            $($element.data('input')).val(this.value);
                    }
                });
            });
        }
</script>

<script type="text/javascript">
$(document).on('click', 'button[data-fontsize]', function() {
    let $lyrics = $($(this).data('target'));
    let size = parseInt($lyrics.css('font-size'));

    if ($(this).data('fontsize') == 'increase') {
        if (size < 28) {
            let newSize = size + 1 + 'px';
            $lyrics.css({'font-size': newSize});
        }
    } else {
        if (size > 16) {
            let newSize = size - 1 + 'px';
            $lyrics.css({'font-size': newSize});
        }
    }
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $(document).on('click', '#toggle-waiting-list', function() {
        let $btn = $(this);
        $($btn.data('target')).slideToggle('fast', function() {
            $btn.toggleIcon('chevron-up', 'chevron-down');
        });
    });
});
</script>

<script type="text/javascript">
// $(document).on('click', '[data-action="sing"] button[type="submit"]', function(e) {
//     e.preventDefault();

//     let $form = $(this).closest('form');
//     let url = $form.attr('action');
    
//     axios.post(url)
//          .then(function(response) {
//             log(response);
//          })
//          .catch(function(error) {
//             log(error);
//          });
// });
</script>
<script type="text/javascript">
$(document).on('click', 'button[name="show_password_container"]', function(event) {
    $(this).closest('.join-content').hide();
    $($(this).data('target')).fadeIn('fast');
});

$(document).on('keyup', '.password-digits input[name="digit"]', function(event) {
    let $input = $(this);
    let $container = $input.closest('.password-digits');
    let $inputs = $container.find('input[name="digit"]');
    let $next = $($input.data('next'));
    let $password = $($(this).data('target'));

    if (! isNumber(event.keyCode)) {
        $input.val('');
        return;
    }

    setTimeout(function() {
    $input.prop('disabled', true);

    if ($next.length) {
        $next.focus();
    } else {
        if (verifyPassword($inputs, $password.data('real'))) {
            $inputs.each(function(i) {
                let $input = $(this);
                setTimeout(function() {
                    $input.toggleClass('alert-green bg-transparent').animateCSS('bounceIn', 'slower');  
                }, i*100);
            });
            
            setTimeout(function() {
                $container.find('form').submit();
            }, ($inputs.length * 100) * 3);
        } else {
            $inputs.toggleClass('alert-red bg-transparent').animateCSS('shakeX', 'slow');

            setTimeout(function() {
                $inputs.val('').prop('disabled', false).toggleClass('alert-red bg-transparent animate__shakeX');
                $inputs.first().focus();
            }, 400);
        }
    }
    }, 100);
});

function isNumber(code) {
    return code >= 48 && code <= 57;
}

function verifyPassword($inputs, password)
{
    let input = '';

    $inputs.each(function() {
        input = input + $(this).val();
    });

    return password == input;
}
</script>
        @stack('scripts')
    </body>
</html>
