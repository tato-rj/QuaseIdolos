const {test} = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs/promises');
const os = require('node:os');
const path = require('node:path');
const vm = require('node:vm');
const webpack = require('webpack');

test('the browser dependency bundle exposes the Sortable constructor', async () => {
    const output = await fs.mkdtemp(path.join(os.tmpdir(), 'quaseidolos-sortable-'));
    const compiler = webpack({
        mode: 'production',
        target: 'web',
        entry: path.resolve(__dirname, '../../resources/js/_dependencies.js'),
        output: {path: output, filename: 'dependencies.js'},
        devtool: false,
        plugins: [new webpack.IgnorePlugin({resourceRegExp: /^\.\/locale$/, contextRegExp: /moment$/})],
    });

    try {
        await new Promise((resolve, reject) => compiler.run((error, stats) => {
            if (error) return reject(error);
            if (stats.hasErrors()) return reject(new Error(stats.toString({all: false, errors: true})));
            resolve();
        }));

        // Node's require('sortablejs') uses its CommonJS entry. Webpack uses the
        // browser module entry instead, which is where the regression occurred.
        const context = vm.createContext({window: {}});
        vm.runInContext(await fs.readFile(path.join(output, 'dependencies.js'), 'utf8'), context);
        const Sortable = context.window.Sortable;
        assert.equal(typeof Sortable, 'function');
        assert.equal(typeof Sortable.prototype.destroy, 'function');
        assert.equal(typeof Sortable.prototype.option, 'function');
    } finally {
        await new Promise((resolve, reject) => compiler.close(error => error ? reject(error) : resolve()));
        await fs.rm(output, {recursive: true, force: true});
    }
});
