(() => {
    const scriptEl = document.currentScript;
    const endpoint =
        (scriptEl && scriptEl.dataset && scriptEl.dataset.endpoint) ||
        window.VISIT_TRACKER_ENDPOINT ||
        '/api/track';

    const detectDevice = () => {
        const ua = navigator.userAgent.toLowerCase();
        const width = Math.min(window.screen.width, window.screen.height);
        if (ua.includes('ipad') || ua.includes('tablet') || width >= 600 && width <= 1024) {
            return 'tablet';
        }
        if (ua.includes('mobi') || width < 600) {
            return 'mobile';
        }
        return 'desktop';
    };

    const send = async () => {
        let ip = null;
        let city = null;

        try {
            const res = await fetch('https://ipapi.co/json/');
            if (res.ok) {
                const data = await res.json();
                ip = data.ip || null;
                city = data.city || null;
            }
        } catch (_) {
            // ignore geo lookup errors
        }

        const payload = {
            ip,
            city,
            device: detectDevice()
        };

        try {
            await fetch(endpoint, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });
        } catch (_) {
            // ignore send errors
        }
    };

    if (document.readyState === 'complete') {
        send();
    } else {
        window.addEventListener('load', send, { once: true });
    }
})();
