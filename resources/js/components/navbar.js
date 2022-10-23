$('.offcanvas').on('hide.bs.offcanvas', function() {
	let id = $(this).attr('id');
	$('.hamburger[data-bs-target="#'+id+'"]').get(0).click();
});

$('.navbar .dropdown-toggle').on('show.bs.dropdown', function() {
    $('.dropdown-toggle').not(this).dropdown('hide');
    $(this).parent().find('.dropdown-caret').rotate(180);
});

$('.navbar .dropdown-toggle').on('hide.bs.dropdown', function() {
    $(this).parent().find('.dropdown-caret').rotate(0);
});

$('#navbar-vertical button[data-toggle="collapse"]').click(function() {
    let $navbar = $('#navbar-vertical');
    let $button = $(this);

    $button.find('i').toggleClass('fa-chevron-left fa-chevron-right');

    if ($navbar.find('.nav-link-icon').length)
        $navbar.find('span').toggle();

    $navbar.find('.navbar').toggleClass('navbar-open');

    $('#page-content').css('padding-left', $('#navbar-vertical').width());
});

$('#navbar-vertical .nav-link').on('shown.bs.dropdown', function() {
    $('#page-content').css('padding-left', $('#navbar-vertical').width());
});

$('#navbar-vertical .nav-link').on('hidden.bs.dropdown', function() {
    setTimeout(function() {
        $('#page-content').css('padding-left', $('#navbar-vertical').width());
    }, 300);
});

if ($('#navbar-vertical').length) {
    $('#navbar-vertical .navbar').css({'max-width': $('#navbar-vertical').width()});
    $('#page-content').css({'padding-left': $('#navbar-vertical').width()});
}

if ($('#navbar-horizontal').length) {
    $('#navbar-vertical .navbar').css({
        'padding-top': $('#navbar-horizontal').height() + 'px',
    });
}

if ($('#navbar-horizontal.navbar-fixed')) {
    $('#page-content').css({
        'padding-top': $('#navbar-horizontal').height() + 'px'
    });
}

$('.navbar .dropdown.slide').on('show.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideDown('fast');
});

$('.navbar .dropdown.slide').on('hide.bs.dropdown', function() {
    $(this).find('.dropdown-menu').first().stop(true, true).slideUp('fast');
});