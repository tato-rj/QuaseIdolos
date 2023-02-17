<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <title>{{$title ?? 'Bem vindo'}} | {{config('app.name')}} - Rio de Janeiro</title>

        @include('layouts.components.favicon')
        @include('layouts.components.seo')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        <style type="text/css">

u {
    text-decoration-color: white;
}
* {
  touch-action: manipulation;
}

.btn-padding {
    padding: 0.391rem 1rem !important;
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

      @keyframes example {
  0%   {opacity: .4;}
  50%  {opacity: .1;}
  100% {opacity: .4;}
}

.status-icon-backdrop {
  animation-name: example;
  animation-duration: 1.5s;
  animation-iteration-count: infinite;
  animation-timing-function: ease-in-out;
}

        </style>
<script>
    window.app = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'url' => \Request::root(),
        'user' => auth()->check() ? auth()->user() : null,
        'gig' => auth()->check() ? auth()->user()->liveGig : null,
        'chatUrls' => [
            'unreadCount' => route('chat.unread-count'),
            'showUser' => route('chat.user'),
            'showParticipants' => route('chat.participants')
        ]
    ]); ?>
</script>

        @stack('header')
    </head>
    <body class="bg-primary">

        @unless(isset($raw))
            @auth
                @include('pages.gigs.banner')

                @if(auth()->user()->invitations()->unconfirmed()->exists())
                @include('pages.participants.modals.confirm')
                @endif
        
                @if(session('invite-confirmed'))
                @include('pages.participants.splashscreen')
                @endif

                @include('components.floatingMenu')
            @endauth
        @endunless
        
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

        @unless(isset($raw))
            @include('layouts.components.alerts')

            @if($modal = session('modal'))
            @include($modal)
            @php(session()->forget('modal'))
            @endif

            @unless(auth()->check())
            @include('auth.login.modal')
            @endunless
        @endunless

        <script src="{{ mix('js/app.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
        <script src="{{mix('js/vendor/datepicker-pt-BR.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/vendor/jquery.jscroll.min.js')}}"></script>

<script type="text/javascript">
let invitationVideo = document.getElementById('participant-video-confirmed')

if (invitationVideo) {
    invitationVideo.play();

    invitationVideo.addEventListener('ended',hideOnEnd,false);

    function hideOnEnd(e) {
        $(this).css('width', '400%');
        $($(this).data('target')).fadeOut('fast', 'linear', function() {
            $(this).remove();
        });
    }
}
</script>

<script>
$('input[name="has_password"]').change(function() {
    let $customPass = $(this).closest('.has-password-container').find('.custom-password');
    
    if ($(this).prop('checked')) {
        $customPass.show();
    } else {
        $customPass.val('').hide();
    }
});
</script>

<script type="text/javascript">
$('.table-container select[name="order_by"]').on('change', function() {
    $(this).closest('form').submit();
});
</script>

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

var chat = new Chat;

if (app.user && app.gig) {
    if (app.user.admin) {
        listenToAdminEvents();
    } else {
        getUserAlert();
    }

    if (app.user.participates_in_chat)
        listenToUserEvents();
}

function listenToAdminEvents()
{
    try {
    window.Echo
          .channel('setlist')
          .listen('SongRequested', function(event) {
                getEventTable();
          })
          .listen('SongCancelled', function(event) {
                getEventTable();
          });
    } catch (error) {
        log(error);
    }
}

function listenToUserEvents()
{
    try {
        window.Echo
              .channel('chat.'+app.gig.id)
              .listen('ChatSent', function(event) {
                chat.load(event);
              })
              .listen('ChatRead', function(event) {
                chat.markAsRead(event);
              });

        window.Echo
              .private('chat.'+app.gig.id)
              .listenForWhisper('typing', function(event) {
                chat.typing(event);
              });
    } catch (error) {
        log(error);
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

            if (response.data)
                $('#chat-badge').animate({bottom: $('#setlist-banner').height()}, 200, 'linear');
         })
         .catch(function(error) {
            alert(error);
         });
}

function getEventTable(newOrder = null)
{
    if ($('#setlist-container').length) {
    axios.get($('#setlist-container').data('url'), {params: {newOrder: newOrder}})
        .then(function(response) {
            $('#setlist-container').html(response.data);
            
            enableDraggable();

            if (newOrder) {
                listenToAdminEvents();
                popup('success', 'A ordem foi alterada com sucesso');
            }
        })
        .catch(function(error) {
            popup('error', 'Não foi! ('+error.message+')');
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
        handle: ".my-handle",
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

function popup($type, $message)
{
    let $popup = $('#popup-'+$type+'>div').clone();

    $popup.find('span.popup-message').text($message);

    $('body').append($popup);
    $popup.show();

    setTimeout(function() {
        $popup.find('>div').addClass('animate__fadeOutDown');
        setTimeout(function() {
            $popup.remove();
        }, 800);
    }, 2000);
}

</script>

<script type="text/javascript">
// CHAT LISTENERS

$(document).on('submit', '.chat-user form', function(e) {
    e.preventDefault();

    if ($(this).find('[name="message"]').val())
        chat.send(this);
});

$(document).on('click', '#chat-list button', function() {
    chat.getUser(this);
});

$(document).on('click', '#chat-back button', function() {
    chat.reset();
});

$('#chat-modal').on('hidden.bs.modal', function() {
    $('#chat-back button').click();
});

$('#chat-modal').on('show.bs.modal', function() {
    chat.getParticipants();
});
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
$(document).on('click', 'button[name="change-song"], button[name="invite-user"], button[name="cancel-invite-user"]', function() {
    $($(this).data('target-hide')).toggle();
    $($(this).data('target-show')).toggle();
});
</script>

<script type="text/javascript">
$(document).on('click', '[name="participant-avatar"]', function() {
    selectParticipant(this);

    let $modal = $(this).closest('.modal');
    let $selectedParticipants = $(this).parent().find('[name="participant-avatar"].participant-selected');
    let $otherParticipants = $(this).parent().find('[name="participant-avatar"]').not(this).not('.participant-selected');
    
    if (! $(this).hasClass('participant-selected')) {
        $(this).addClass('opacity-4');
        $(this).find('input[name="participants[]"]').prop('checked', false);
    }

    if ($selectedParticipants.length) {
        $otherParticipants.addClass('opacity-4');
    } else {
        resetParticipants();
    }
})

function selectParticipant(element)
{
    $(element).find('input[name="participants[]"]').prop('checked', true);
    $(element).removeClass('opacity-4');
    $(element).toggleClass('participant-selected');
    $(element).find('p').toggleClass('text-secondary opacity-8');
    $(element).find('.avatar-img').toggleClass('border border-lg');
    $(element).find('.checkmark').toggle(); 
}

function resetParticipants()
{
    $('[name="participant-avatar"]').find('input[name="participants[]"]').prop('checked', false);
    $('[name="participant-avatar"]').removeClass('opacity-4');
    $('[name="participant-avatar"]').removeClass('participant-selected');
    $('[name="participant-avatar"]').find('p').removeClass('text-secondary');
    $('[name="participant-avatar"]').find('p').addClass('opacity-8');
    $('[name="participant-avatar"]').find('.avatar-img').removeClass('border border-lg');
    $('[name="participant-avatar"]').find('.checkmark').hide(); 
}

$(document).on('click', 'button[name="cancel-invite-user"]', function() {
    resetParticipants();
});
</script>
<script type="text/javascript">
$(document).on('keyup', 'input[name="search_participant"]', function() {
    let $container = $(this).closest('.participants-container');
    let input = $(this).val().toLowerCase();

    if (input.length > 0 && input.length < 3) {
        $container.find('.participant').show();
        return;
    }

    $container.find('.participant').each(function() {
        if (! $(this).data('search').includes(input)) {
            $(this).hide();
        }
    });
});
</script>

        @stack('scripts')
    </body>
</html>
