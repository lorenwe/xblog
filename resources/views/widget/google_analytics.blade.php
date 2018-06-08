@if(isset($google_analytics) && $google_analytics == 'true')
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $google_trace_id or '' }}"></script>
    <script>window.dataLayer = window.dataLayer || [];function gtag(){dataLayer.push(arguments);}gtag('js', new Date());gtag('config', "{{ $google_trace_id or '' }}");</script>
@endif