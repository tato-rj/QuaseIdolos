 $(document).on('submit', 'form[data-trigger="loader"]', function() {
    $(this).find('button[type="submit"]').addLoader();
});

$(document).on('click', '.btn[data-trigger="loader"]', function() {
    $(this).addLoader();
});