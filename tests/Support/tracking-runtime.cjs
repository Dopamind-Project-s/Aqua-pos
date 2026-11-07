// Execute the actual server-rendered tracking scripts with a stub DOM.
// This checks queues and bootstrap behavior without sending real analytics events.
const assert = require('node:assert/strict');
const vm = require('node:vm');
const fs = require('node:fs');

const pages = JSON.parse(fs.readFileSync(0, 'utf8'));
const withoutPixel = pages.withoutPixel;
delete pages.withoutPixel;
for (const [mode, html] of Object.entries(pages)) {
    const inserted = [];
    const document = {
        createElement: () => ({}),
        getElementsByTagName: () => [{ parentNode: { insertBefore: node => inserted.push(node.src) } }],
    };
    const context = vm.createContext({ document });
    context.window = context;
    const head = html.slice(0, html.indexOf('</head>'));
    const scripts = [...head.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/g)]
        .map(match => match[1])
        .filter(code => /AQUA_TRACKING_METHOD|window\.gtag|gtm\.start|f\.fbq|clarity\.ms|page_context/.test(code));
    for (const code of scripts) vm.runInContext(code, context);

    assert.equal(context.AQUA_TRACKING_METHOD, mode);
    assert.equal(inserted.filter(url => url.includes('fbevents.js')).length, 1);
    assert.equal(inserted.filter(url => url.includes('clarity.ms/tag/abc123xyz')).length, 1);
    assert.deepEqual(Array.from(context.fbq.queue, args => Array.from(args)), [
        ['init', '123456789012345'],
        ['trackSingle', '123456789012345', 'PageView'],
    ]);
    const fbq = context.fbq;
    vm.runInContext(scripts.find(code => code.includes('f.fbq')), context);
    assert.equal(context.fbq, fbq);
    assert.equal(context.fbq.queue.length, 2);
    assert.equal(inserted.filter(url => url.includes('fbevents.js')).length, 1);

    const successScripts = [...html.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/g)]
        .map(match => match[1]).filter(code => /window\.aquaTrackEvent\("generate_lead",/.test(code));
    if (successScripts.length) {
        assert.equal(successScripts.length, 1);
        vm.runInContext(successScripts[0], context);
    } else {
        context.aquaTrackEvent('generate_lead', { form_type: 'demo_request', event_id: 'service_request_test' });
    }
    const leads = () => Array.from(context.fbq.queue, args => Array.from(args)).filter(entry =>
        entry[0] === 'trackSingle' && entry[1] === '123456789012345' && entry[2] === 'Lead'
    );
    assert.equal(leads().length, 1);
    const leadId = leads()[0][4].eventID;
    // Repeated execution of the same success callback must not enqueue another Meta Lead.
    context.aquaTrackEvent('generate_lead', { form_type: 'demo_request', event_id: leadId });
    context.aquaTrackEvent('generate_lead', { form_type: 'support_request', event_id: 'support_test' });
    context.aquaTrackEvent('generate_lead', { form_type: 'demo_request' });
    assert.equal(leads().length, 1);
    const events = Array.from(context.dataLayer, entry => entry.length ? Array.from(entry) : { ...entry });
    if (mode === 'ga4') {
        assert.equal(events.filter(entry => entry[0] === 'config' && entry[1] === 'G-DIRECT123').length, 1);
        assert.equal(events.filter(entry => entry[0] === 'event' && entry[1] === 'generate_lead').length, 4);
        assert.equal(events.filter(entry => entry[0] === 'event' && entry[1] === 'page_view').length, 0);
        assert.equal(inserted.some(url => url.includes('gtm.js')), false);
    } else if (mode === 'gtm') {
        assert.equal(events.filter(entry => entry.event === 'gtm.js').length, 1);
        assert.equal(events.filter(entry => entry.event === 'generate_lead').length, 4);
        assert.equal(typeof context.gtag, 'undefined');
    } else {
        assert.equal(events.length, 0);
        assert.equal(typeof context.gtag, 'undefined');
    }
}
if (withoutPixel) {
    const calls = [];
    const context = vm.createContext({ fbq: (...args) => calls.push(args) });
    context.window = context;
    const helper = [...withoutPixel.matchAll(/<script\b[^>]*>([\s\S]*?)<\/script>/g)]
        .map(match => match[1]).find(code => code.includes('window.AQUA_TRACKING_METHOD ='));
    vm.runInContext(helper, context);
    context.aquaTrackEvent('generate_lead', { form_type: 'demo_request', event_id: 'service_request_99' });
    assert.equal(calls.length, 0, 'An externally managed fbq must not receive a native Lead when the native Pixel field is empty.');
}
console.log('Tracking JavaScript queues and repeat-bootstrap checks passed in all three modes.');
