const {test} = require('node:test');
const assert = require('node:assert/strict');
const LatestRequest = require('../../resources/js/utilities/LatestRequest');

function client()
{
    const requests = [];
    return {
        requests,
        CancelToken: {source() { return {token: {}, cancel() {}}; }},
        isCancel: error => error.cancelled === true,
        get() {
            // Simulate a transport that can still deliver responses after cancellation.
            return new Promise((resolve, reject) => requests.push({resolve, reject}));
        },
    };
}

test('a late search response cannot replace newer results', async () => {
    const http = client();
    const request = new LatestRequest(http);
    const old = request.get('/search?input=old');
    const current = request.get('/search?input=current');
    http.requests[1].resolve({data: 'current'});
    assert.deepEqual(await current, {data: 'current'});
    http.requests[0].resolve({data: 'old'});
    assert.equal(await old, null);
});

test('closing a modal or clearing search ignores an in-flight response', async () => {
    const http = client();
    const request = new LatestRequest(http);
    const pending = request.get('/modal');
    request.cancel();
    http.requests[0].resolve({data: 'closed modal'});
    assert.equal(await pending, null);
});

test('a real network failure remains observable and the next request works', async () => {
    const http = client();
    const request = new LatestRequest(http);
    const pending = request.get('/search');
    http.requests[0].reject(new Error('offline'));
    await assert.rejects(pending, /offline/);
    const retry = request.get('/search');
    http.requests[1].resolve({data: 'reconnected'});
    assert.deepEqual(await retry, {data: 'reconnected'});
});

test('independent targets do not cancel each other', async () => {
    const http = client();
    const first = new LatestRequest(http).get('/modal/1');
    const second = new LatestRequest(http).get('/modal/2');
    http.requests[1].resolve({data: 2});
    http.requests[0].resolve({data: 1});
    assert.deepEqual(await first, {data: 1});
    assert.deepEqual(await second, {data: 2});
});
