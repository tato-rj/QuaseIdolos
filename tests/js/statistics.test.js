const {test} = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const path = require('node:path');
const vm = require('node:vm');
const LatestRequest = require('../../resources/js/utilities/LatestRequest');

const source = fs.readFileSync(path.join(__dirname, '../../resources/views/pages/statistics/components/ranking-script.blade.php'), 'utf8')
    .replace(/<\/?script[^>]*>/g, '')
    .replace(/\{!!.*?!!\}/g, '2026-10-19')
    .replace('@json($rankingUrl)', '"/statistics/artists"');

function harness()
{
    const state = {html: 'placeholder', loading: false, notices: [], dates: ['19/10/2025', '19/10/2026'], limit: 10};
    const pending = [];
    let onLimitChange;
    const controls = {
        datepicker(options) { state.datepicker = options; },
        eq(index) { return {val: () => state.dates[index]}; },
    };
    const container = {
        on(event, selector, handler) {
            assert.equal(event, 'change');
            assert.equal(selector, 'select[name="limit"]');
            onLimitChange = handler;
            return this;
        },
        find(selector) {
            assert.equal(selector, 'select[name="limit"]');
            return {val: value => { state.limit = value; }};
        },
        closest() { return {find: () => controls}; },
        addClass() { state.loading = true; return this; },
        removeClass() { state.loading = false; return this; },
        html(value) { state.html = value; return this; },
        empty() { state.html = ''; return this; },
    };
    const client = {
        CancelToken: {source: () => ({token: {}, cancel() {}})},
        isCancel: error => error.cancelled === true,
        get(url, config) { return new Promise((resolve, reject) => pending.push({url, config, resolve, reject})); },
    };
    const context = vm.createContext({
        LatestRequest,
        axios: client,
        $: selector => selector === '.datepicker' ? controls : container,
        log() {},
        popup(type, message) { state.notices.push({type, message}); },
    });
    vm.runInContext(source, context);
    return {
        state, pending, reload: context.reloadTable,
        changeLimit(value) {
            state.limit = value;
            return onLimitChange.call({value: String(value)});
        },
    };
}

test('the initial ranking request uses the dates displayed in the controls', async () => {
    const h = harness();
    assert.equal(h.pending[0].config.params.from, '19/10/2025');
    assert.equal(h.pending[0].config.params.to, '19/10/2026');
    assert.equal(h.pending[0].config.params.limit, 10);
    assert.equal(h.pending[0].config.headers.Accept, 'application/json');
    assert.equal(h.pending[0].config.timeout, 30000);
    h.pending[0].resolve({data: 'ranking'});
    await new Promise(setImmediate);
    assert.equal(h.state.html, 'ranking');
    assert.equal(h.state.loading, false);
});

test('failed initial loads remove the indefinite placeholder and show the existing error popup', async () => {
    const h = harness();
    h.pending[0].reject(new Error('request timed out'));
    await new Promise(setImmediate);
    assert.equal(h.state.loading, false);
    assert.equal(h.state.html, '');
    assert.equal(h.state.notices.length, 1);
    assert.equal(h.state.notices[0].type, 'error');
    const retry = h.reload('01/10/2026', '19/10/2026');
    h.pending[1].resolve({data: 'recovered'});
    await retry;
    assert.equal(h.state.html, 'recovered');
});

test('rapid date changes cannot render a delayed ranking from an older range', async () => {
    const h = harness();
    const latest = h.reload('19/10/2026', '19/10/2026');
    h.pending[1].resolve({data: 'today'});
    await latest;
    h.pending[0].resolve({data: 'all history'});
    await new Promise(setImmediate);
    assert.equal(h.state.html, 'today');
    assert.equal(h.state.notices.length, 0);
});

test('a failed later refresh retains the last successful ranking', async () => {
    const h = harness();
    h.pending[0].resolve({data: 'previous ranking'});
    await new Promise(setImmediate);
    const next = h.reload('19/10/2026', '19/10/2026');
    h.pending[1].reject(new Error('offline'));
    await next;
    assert.equal(h.state.html, 'previous ranking');
    assert.equal(h.state.loading, false);
    assert.equal(h.state.notices.length, 1);
});

test('changing the ranking size preserves dates and subsequent date changes preserve the size', async () => {
    const h = harness();
    h.pending[0].resolve({data: 'top 10'});
    await new Promise(setImmediate);
    h.state.dates = ['01/01/2026', '01/10/2026'];

    const changed = h.changeLimit(50);
    assert.equal(h.pending[1].config.params.limit, 50);
    assert.equal(h.pending[1].config.params.from, '01/01/2026');
    assert.equal(h.pending[1].config.params.to, '01/10/2026');
    h.pending[1].resolve({data: 'top 50'});
    await changed;

    const dated = h.reload('01/09/2026', '19/10/2026');
    assert.equal(h.pending[2].config.params.limit, 50);
    h.pending[2].resolve({data: 'top 50 in September and October'});
    await dated;
    assert.equal(h.state.html, 'top 50 in September and October');

    // The delegated handler survives replacing the table and its select element.
    const smaller = h.changeLimit(20);
    assert.equal(h.pending[3].config.params.limit, 20);
    h.pending[3].resolve({data: 'top 20'});
    await smaller;
    assert.equal(h.state.html, 'top 20');
});

test('rapid size changes ignore older rankings and older failures', async () => {
    const h = harness();
    const twenty = h.changeLimit(20);
    const hundred = h.changeLimit(100);
    h.pending[2].resolve({data: 'top 100'});
    await hundred;
    h.pending[1].resolve({data: 'top 20'});
    await twenty;
    h.pending[0].reject(new Error('old request timed out'));
    await new Promise(setImmediate);

    assert.equal(h.state.html, 'top 100');
    assert.equal(h.state.limit, 100);
    assert.equal(h.state.notices.length, 0);
});

test('a failed size change restores the selector to the displayed ranking size', async () => {
    const h = harness();
    h.pending[0].resolve({data: 'top 10'});
    await new Promise(setImmediate);
    const changed = h.changeLimit(100);
    h.pending[1].reject(new Error('offline'));
    await changed;

    assert.equal(h.state.html, 'top 10');
    assert.equal(h.state.limit, 10);
    assert.equal(h.state.loading, false);
    assert.equal(h.state.notices.length, 1);

    const retry = h.reload('01/10/2026', '19/10/2026');
    assert.equal(h.pending[2].config.params.limit, 10);
    h.pending[2].resolve({data: 'top 10 again'});
    await retry;
});
