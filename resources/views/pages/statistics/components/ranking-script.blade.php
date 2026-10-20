<script type="text/javascript">
const statisticsRequest = new LatestRequest(axios);
let statisticsLoaded = false;
let statisticsLimit = 10;
let statisticsLoadedLimit = 10;

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
$('#table-container').on('change', 'select[name="limit"]', function() {
    statisticsLimit = Number(this.value);
    return reloadTable($statisticsDates.eq(0).val(), $statisticsDates.eq(1).val());
});
reloadTable($statisticsDates.eq(0).val(), $statisticsDates.eq(1).val());

function reloadTable(from, to)
{
    if (! from || ! to)
        return Promise.resolve();

    const $container = $('#table-container');
    const limit = statisticsLimit;
    $container.addClass('opacity-6');

    return statisticsRequest.get(@json($rankingUrl), {
        params: {from: from, to: to, limit: limit},
        headers: {Accept: 'application/json'},
        timeout: 30000
    }).then(function(response) {
        if (! response)
            return;

        statisticsLoaded = true;
        statisticsLoadedLimit = limit;
        $container.removeClass('opacity-6').html(response.data);
    }).catch(function(error) {
        $container.removeClass('opacity-6');
        if (! statisticsLoaded)
            $container.empty();
        else {
            statisticsLimit = statisticsLoadedLimit;
            $container.find('select[name="limit"]').val(statisticsLoadedLimit);
        }

        log(error);
        popup('error', 'Não foi possível carregar as estatísticas. Tente novamente.');
    });
}
</script>
