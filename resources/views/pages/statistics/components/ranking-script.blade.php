<script type="text/javascript">
const statisticsRequest = new LatestRequest(axios);
let statisticsLoaded = false;

$(".datepicker").datepicker({
    changeMonth: true,
    changeYear: true,
    minDate: new Date('{!! $initialDate !!}'),
    maxDate: new Date('{!! $lastDate !!}'),
    onSelect: function() {
        const $inputs = $(this).parent().find('.datepicker');
        reloadTable($inputs.eq(0).val(), $inputs.eq(1).val());
    }
});

// Send the same localized dates displayed in the existing controls.
const $statisticsDates = $('#table-container').closest('section').find('.datepicker');
reloadTable($statisticsDates.eq(0).val(), $statisticsDates.eq(1).val());

function reloadTable(from, to)
{
    if (! from || ! to)
        return Promise.resolve();

    const $container = $('#table-container');
    $container.addClass('opacity-6');

    return statisticsRequest.get(@json($rankingUrl), {
        params: {from: from, to: to},
        headers: {Accept: 'application/json'},
        timeout: 30000
    }).then(function(response) {
        if (! response)
            return;

        statisticsLoaded = true;
        $container.removeClass('opacity-6').html(response.data);
    }).catch(function(error) {
        $container.removeClass('opacity-6');
        if (! statisticsLoaded)
            $container.empty();

        log(error);
        popup('error', 'Não foi possível carregar as estatísticas. Tente novamente.');
    });
}
</script>
