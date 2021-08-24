<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Vitaly Kasymov">
        <meta name="description" content="">

        <title>{{ config('app.name') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
        <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAu2LdngQaedWU8hJx3L80WS_hqEYbDw7A&libraries=places"></script>

        <script>
            window.Laravel = {!! json_encode([
                'siteName' => config('app.name'),
                'siteUrl' => config('app.url'),
                'apiUrl' => config('app.url') . '/api'
            ]) !!};
        </script>
    </head>
    <body>
        <div id="app"></div>

        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
