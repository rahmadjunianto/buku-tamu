/**
 * HTTPS Helper
 * Ensures all AJAX requests use HTTPS when the page is loaded over HTTPS
 */
(function() {
    'use strict';

    // Function to convert HTTP URLs to HTTPS
    function ensureHttps(url) {
        if (window.location.protocol === 'https:' && url.startsWith('http:')) {
            return url.replace('http:', 'https:');
        }
        return url;
    }

    // Override jQuery AJAX to ensure HTTPS
    if (typeof $ !== 'undefined' && $.ajaxPrefilter) {
        $.ajaxPrefilter(function(options, originalOptions, jqXHR) {
            if (options.url) {
                options.url = ensureHttps(options.url);
            }
        });
    }

    // Override fetch API if available
    if (typeof window.fetch !== 'undefined') {
        const originalFetch = window.fetch;
        window.fetch = function(url, options) {
            if (typeof url === 'string') {
                url = ensureHttps(url);
            } else if (url instanceof Request) {
                // Create new request with HTTPS URL
                const httpsUrl = ensureHttps(url.url);
                if (httpsUrl !== url.url) {
                    url = new Request(httpsUrl, url);
                }
            }
            return originalFetch.call(this, url, options);
        };
    }

    // Override XMLHttpRequest
    if (typeof XMLHttpRequest !== 'undefined') {
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
            url = ensureHttps(url);
            return originalOpen.call(this, method, url, async, user, password);
        };
    }

    // Add helper function to global scope
    window.ensureHttps = ensureHttps;

    // Add CSRF setup for Laravel
    if (typeof $ !== 'undefined') {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    // Add security headers helper
    window.addSecurityHeaders = function(xhr) {
        if (window.location.protocol === 'https:') {
            xhr.setRequestHeader('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }
    };

})();

// Console log for debugging (remove in production)
if (window.location.protocol === 'https:') {
    console.log('HTTPS Helper loaded - all HTTP requests will be upgraded to HTTPS');
}
