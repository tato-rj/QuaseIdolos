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
    const state = {html: 'placeholder', loading: false, notices: [], dates: ['19/10/2025', '19/10/2026']};
    const pending = [];
    const controls = {
        datepicker(options) { state.datepicker = options; },
        eq(index) { return {val: () => state.dates[index]}; },
    };
    const container = {
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
    return {state, pending, reload: context.reloadTable};
}

test('the initial ranking request uses the dates displayed in the controls', async () => {
    const h = harness();
    assert.equal(h.pending[0].config.params.from, '19/10/2025');
    assert.equal(h.pending[0].config.params.to, '19/10/2026');
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
