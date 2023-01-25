require('./bootstrap/setup');
require('./bootstrap/helpers');
require('./bootstrap/extensions');
require('./bootstrap/utilities');
require('./bootstrap/components');

//////////////////////////////////////
//// CUSTOM JS BELOW
//////////////////////////////////////

$(document).on('click', 'button[name="show_password_container"]', function(event) {
    let $passwords = $($(this).data('target'));
    $('.join-content').show();
    $('.join-password').hide();
    $(this).closest('.join-content').hide();
    
    $passwords.fadeIn('fast');
    $passwords.find('input[name="digit"]').first().focus();
});

$(document).on('keyup', '.password-digits input[name="digit"]', function(event) {
    let $input = $(this);
    let $container = $input.closest('.password-digits');
    let $inputs = $container.find('input[name="digit"]');
    let $prev = $($input.data('prev'));
    let $next = $($input.data('next'));
    let $password = $($(this).data('target'));

    if (event.keyCode == 8)
        $prev.prop('disabled', false).focus().val('');

    if (! isNumber(event.keyCode) || ! $input.val().length) {
        $input.val('');
        return;
    }

    $input.prop('disabled', true);
    $next.prop('disabled', false);

    setTimeout(function() {
    if ($next.length) {
        $next.focus();
    } else {
        if (verifyPassword($inputs, $password.data('real'))) {
            $inputs.each(function(i) {
                let $input = $(this);
                setTimeout(function() {
                    $input.toggleClass('text-green bg-transparent').animateCSS('bounceIn');  
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