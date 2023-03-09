<!DOCTYPE html>
<!--
Template Name: Chillaid
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Copyright: OS-Templates.com
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms
-->
<html lang="">
<head>
    <title>Bilta</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{asset('layout/styles/layout.css')}}" rel="stylesheet" type="text/css" media="all">

    @stack('custom-styles')
    @livewireStyles

</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
{{--<div class="wrapper row1">--}}
{{--    <header id="header" class="hoc clear">--}}
{{--        <div id="logo" class="fl_left">--}}
{{--            <!-- ################################################################################################ -->--}}
{{--            <h1 class="logoname"><a href="{{route('site.home')}}">Bilta</a></h1>--}}
{{--            <!-- ################################################################################################ -->--}}
{{--        </div>--}}
{{--    </header>--}}
{{--</div>--}}

@if(  isset($slot) )
    {{$slot}}
@else
    @yield('content')
@endif

<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>

<!-- JAVASCRIPTS -->
<script src="{{asset('layout/scripts/jquery.min.js')}}"></script>
<script src="{{asset('layout/scripts/jquery.backtotop.js')}}"></script>
<script src="{{asset('layout/scripts/jquery.mobilemenu.js')}}"></script>
<!-- Homepage specific -->
<script src="{{asset('layout/scripts/jquery.easypiechart.min.js')}}"></script>
<!-- / Homepage specific -->


@stack('custom-scripts')

@livewireScripts

</body>
</html>
