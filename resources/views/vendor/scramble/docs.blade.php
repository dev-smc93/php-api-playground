<!doctype html>
<html lang="en" data-theme="{{ $config->get('ui.theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="color-scheme" content="{{ $config->get('ui.theme', 'light') }}">
    <title>{{ $config->get('ui.title') ?? config('app.name') . ' - API Docs' }}</title>

    <script src="https://unpkg.com/@stoplight/elements@8.4.2/web-components.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@stoplight/elements@8.4.2/styles.min.css">

    <script>
        const originalFetch = window.fetch;

        // Loading overlay for long-running API calls (e.g. 권리분석)
        let overlay = null;
        let spinnerAnimationId = null;
        const ensureOverlay = () => {
            if (!overlay && document.body) {
                overlay = document.createElement('div');
                overlay.id = 'api-loading-overlay';
                overlay.innerHTML = '<div id="api-loading-spinner" class="api-loading-spinner"></div><p class="api-loading-text">권리분석 중입니다. 잠시만 기다려주세요...</p>';
                overlay.style.cssText = 'display:none;position:fixed;inset:0;background:rgba(0,0,0,0.6);z-index:99999;align-items:center;justify-content:center;flex-direction:column';
                document.body.appendChild(overlay);
            }
            return overlay;
        };
        const startSpinnerRotation = () => {
            const spinner = document.getElementById('api-loading-spinner');
            if (!spinner || spinnerAnimationId) return;
            let deg = 0;
            const step = () => {
                deg = (deg + 8) % 360;
                spinner.style.transform = 'rotate(' + deg + 'deg)';
                spinnerAnimationId = requestAnimationFrame(step);
            };
            spinnerAnimationId = requestAnimationFrame(step);
        };
        const stopSpinnerRotation = () => {
            if (spinnerAnimationId) {
                cancelAnimationFrame(spinnerAnimationId);
                spinnerAnimationId = null;
            }
        };
        const showOverlay = () => {
            const el = ensureOverlay();
            if (el) {
                el.style.display = 'flex';
                startSpinnerRotation();
            }
        };
        const hideOverlay = () => {
            stopSpinnerRotation();
            if (overlay) overlay.style.display = 'none';
        };

        // intercept TryIt requests and add the XSRF-TOKEN header,
        // which is necessary for Sanctum cookie-based authentication to work correctly
        window.fetch = (url, options) => {
            const urlStr = typeof url === 'string' ? url : (url?.url || '');
            const isAnalyzeRequest = urlStr.includes('/analyze');
            if (isAnalyzeRequest) showOverlay();

            const CSRF_TOKEN_COOKIE_KEY = "XSRF-TOKEN";
            const CSRF_TOKEN_HEADER_KEY = "X-XSRF-TOKEN";
            const getCookieValue = (key) => {
                const cookie = document.cookie.split(';').find((cookie) => cookie.trim().startsWith(key));
                return cookie?.split("=")[1];
            };

            const updateFetchHeaders = (
                headers,
                headerKey,
                headerValue,
            ) => {
                if (headers instanceof Headers) {
                    headers.set(headerKey, headerValue);
                } else if (Array.isArray(headers)) {
                    headers.push([headerKey, headerValue]);
                } else if (headers) {
                    headers[headerKey] = headerValue;
                }
            };
            const csrfToken = getCookieValue(CSRF_TOKEN_COOKIE_KEY);
            let promise;
            if (csrfToken) {
                const { headers = new Headers() } = options || {};
                updateFetchHeaders(headers, CSRF_TOKEN_HEADER_KEY, decodeURIComponent(csrfToken));
                promise = originalFetch(url, { ...options, headers });
            } else {
                promise = originalFetch(url, options);
            }
            return promise.finally(() => {
                if (isAnalyzeRequest) hideOverlay();
            });
        };
    </script>

    <style>
        html, body { margin:0; height:100%; }
        body { background-color: var(--color-canvas); }
        /* issues about the dark theme of stoplight/mosaic-code-viewer using web component:
         * https://github.com/stoplightio/elements/issues/2188#issuecomment-1485461965
         */
        [data-theme="dark"] .token.property {
            color: rgb(128, 203, 196) !important;
        }
        [data-theme="dark"] .token.operator {
            color: rgb(255, 123, 114) !important;
        }
        [data-theme="dark"] .token.number {
            color: rgb(247, 140, 108) !important;
        }
        [data-theme="dark"] .token.string {
            color: rgb(165, 214, 255) !important;
        }
        [data-theme="dark"] .token.boolean {
            color: rgb(121, 192, 255) !important;
        }
        [data-theme="dark"] .token.punctuation {
            color: #dbdbdb !important;
        }
        /* API loading overlay */
        #api-loading-overlay {
            color: #fff;
            font-family: system-ui, sans-serif;
        }
        .api-loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            margin-bottom: 16px;
        }
        .api-loading-text {
            margin: 0;
            font-size: 1rem;
        }
    </style>
</head>
<body style="height: 100vh; overflow-y: hidden; display: flex; flex-direction: column">
@if($config->get('ui.git_url'))
<div style="flex-shrink:0;padding:8px 16px;background:var(--color-canvas);border-bottom:1px solid var(--color-border);font-size:0.875rem;text-align:right">
    <a href="{{ $config->get('ui.git_url') }}" target="_blank" rel="noopener" style="color:var(--color-accent)">View on Git ↗</a>
</div>
@endif
<div style="flex:1;min-height:0">
<elements-api
    id="docs"
    tryItCredentialsPolicy="{{ $config->get('ui.try_it_credentials_policy', 'include') }}"
    router="hash"
    @if($config->get('ui.hide_try_it')) hideTryIt="true" @endif
    @if($config->get('ui.hide_schemas')) hideSchemas="true" @endif
    @if($config->get('ui.logo')) logo="{{ $config->get('ui.logo') }}" @endif
    @if($config->get('ui.layout')) layout="{{ $config->get('ui.layout') }}" @endif
/>
<script>
    (async () => {
        const docs = document.getElementById('docs');
        docs.apiDescriptionDocument = @json($spec);

    })();
</script>
</div>

@if($config->get('ui.theme', 'light') === 'system')
    <script>
        var mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        function updateTheme(e) {
            if (e.matches) {
                window.document.documentElement.setAttribute('data-theme', 'dark');
                window.document.getElementsByName('color-scheme')[0].setAttribute('content', 'dark');
            } else {
                window.document.documentElement.setAttribute('data-theme', 'light');
                window.document.getElementsByName('color-scheme')[0].setAttribute('content', 'light');
            }
        }

        mediaQuery.addEventListener('change', updateTheme);
        updateTheme(mediaQuery);
    </script>
@endif
</body>
</html>
