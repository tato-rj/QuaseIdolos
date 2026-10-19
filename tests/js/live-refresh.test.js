const {test} = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');
const vm = require('node:vm');
const path = require('node:path');

// Exercise the actual Blade-hosted refresh code without a browser or live socket.
const layout = fs.readFileSync(path.join(__dirname, '../../resources/views/layouts/app.blade.php'), 'utf8');
const refreshCode = layout.slice(layout.indexOf('let eventTableRequest ='), layout.indexOf('function disableDraggable()'));

function harness(present = true)
{
    const pending = [];
    const html = [];
    const popups = [];
    const container = {length: present ? 1 : 0, data: () => '/setlist', html: value => html.push(value)};
    const context = vm.createContext({
        $: () => container,
        axios: {get(url, config) { return new Promise((resolve, reject) => pending.push({config, resolve, reject})); }},
        enableDraggable() {},
        listenToAdminEvents() {},
        popup(type) { popups.push(type); },
        log() {},
    });
    vm.runInContext(refreshCode, context);
    return {refresh: context.getEventTable, pending, html, popups};
}

test('broadcast bursts are coalesced and an obsolete read is never rendered', async () => {
    const h = harness();
    const done = h.refresh();
    h.refresh();
    h.refresh();
    assert.equal(h.pending.length, 1);
    h.pending[0].resolve({data: 'old table'});
    await new Promise(setImmediate);
    assert.equal(h.pending.length, 2);
    assert.equal(h.html.length, 0);
    h.pending[1].resolve({data: 'current table'});
    await done;
    assert.deepEqual(h.html, ['current table']);
});

test('a reorder waits behind a read and is not lost when more refreshes arrive', async () => {
    const h = harness();
    const order = [{id: 2, order: 0}, {id: 1, order: 1}];
    const done = h.refresh();
    h.refresh(order);
    h.refresh();
    h.pending[0].resolve({data: 'old order'});
    await new Promise(setImmediate);
    assert.deepEqual(h.pending[1].config.params.newOrder, order);
    h.pending[1].resolve({data: 'saved order'});
    await done;
    assert.deepEqual(h.html, ['saved order']);
    assert.deepEqual(h.popups, ['success']);
});

test('a failed refresh permits a later refresh to recover', async () => {
    const h = harness();
    const first = h.refresh();
    h.pending[0].reject(new Error('offline'));
    await first;
    const retry = h.refresh();
    h.pending[1].resolve({data: 'recovered'});
    await retry;
    assert.deepEqual(h.html, ['recovered']);
});

test('pages without a setlist still return a usable promise to event listeners', async () => {
    const h = harness(false);
    await h.refresh();
    assert.equal(h.pending.length, 0);
});
