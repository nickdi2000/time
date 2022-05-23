<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Webfly.io">
        <meta name="description" content="Asynchronous Racing -- race your peers at any time. Get the best score. Bicycle or on foot.">

        <title>{{ config('app.name') }}</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/shakrmedia/tuesday@v1.1.0/build/tuesday.min.css" />

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">

        <meta property="og:title" content="Async Racing!" />
        <meta property="og:description" content="Asynchronous Racing -- race your peers at any time. Get the best score. Bicycle or on foot." />
        <meta property="og:image" content="{{config('app.url')}}/images/beer-and-golf.jpg" />

        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons" rel="stylesheet">
    		<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdhcVHiGS_-Ez-Sxj9-aBUKYi8oYlgHts&libraries=places"></script>
        -->
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="https://bootswatch.com/5/darkly/bootstrap.css" rel="stylesheet">

        <script>
            window.Laravel = {!! json_encode([
                'siteName' => config('app.name'),
                'siteUrl' => config('app.url'),
                'apiUrl' => config('app.url') . '/api'
            ]) !!};
        </script>
    </head>
    <body>

  <div class="Absolute-Center Center-Block animated tdFadeInUp">
       @yield('content')
  </div>


    </body>
</html>

<style>

body {
  height: 100vh;
  margin: 0;
  background-image: radial-gradient(circle farthest-corner, #060A33, #000000);
  background-repeat: no-repeat;
}


#Test {
  font-size: 0.1px;
  line-height: 0.1px;
  width: 100px;
  height: 100px;
  width: -moz-fit-content;
  width: -webkit-fit-content;
  width: fit-content;
  height: -moz-fit-content;
  height: -webkit-fit-content;
  height: fit-content;
  background: red;
  opacity: 0.5;
  overflow: hidden;
}
/*
////////////////////////////////////////
 Absolute Centering
////////////////////////////////////////
*/
.Absolute-Center {
  animation-duration: 1.5s;
  width: 60%;
  /* Fallback */
  width: -moz-fit-content;
  width: -webkit-fit-content;
  width: fit-content;
  height: 50%;
  /* Fallback */
  height: -moz-fit-content;
  height: -webkit-fit-content;
  height: fit-content;
  overflow: auto;
  /* Recommended in case content is larger than the container */
  margin: auto;
  /* Center the item vertically & horizontally */
  position: absolute;
  /* Break it out of the regular flow */
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
  /* Set the bounds in which to center it, relative to its parent/container */
}


/* PARTICLES START */

/* ---- tsparticles container ---- */
#tsparticles {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: #000;
  background-image: url("");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 50% 50%;
}

.github {
  bottom: 10px;
  right: 10px;
  position: fixed;
  border-radius: 10px;
  background: #fff;
  padding: 0 12px 6px 12px;
  border: 1px solid #000;
}

.github a:hover,
.github a:link,
.github a:visited,
.github a:active {
  color: #000;
  text-decoration: none;
}

.github img {
  height: 30px;
}

.github #gh-project {
  font-size: 20px;
  padding-left: 5px;
  font-weight: bold;
  vertical-align: bottom;
}



</style>
