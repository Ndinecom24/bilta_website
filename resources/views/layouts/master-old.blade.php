<!DOCTYPE html>

<!--

Template Name: dsdd
Author: <a href="https://www.os-templates.com/">OS Templates</a>
Author URI: https://www.os-templates.com/
Copyright: OS-Templates.com
Licence: Free to use under our free template licence terms
Licence URI: https://www.os-templates.com/template-terms

-->


@if(auth()->check())
    @include('layouts.admin.master')
@else
<html lang="">
<head>
    <title>BiLTA</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link href="{{asset('layout/styles/layout.css')}}" rel="stylesheet" type="text/css" media="all">

    @stack('custom-styles')

        <livewire:styles/>
{{--    @livewireStyles--}}

</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- #############                                                                    ############### -->
<!-- ################################################################################################ -->
<div class="wrapper row1">
    <header id="header" class="hoc clear">
        <div id="logo" class="fl_left">
            <div class="row">
             <div class="col-12" style="display: flex ;" >
                 <!-- ################################################################################################ -->
                 <h1 class="logoname ml-1 mr-1"><a href="{{route('site.home')}}"> BiLTA </a></h1>
                 <!-- ################################################################################################ -->
                 <img style="width: 150px;  background-color: #ffffff ; border-radius: 20px; margin-bottom: 4px ; margin-top: -6px ; margin-left: 6px "  src="{{asset('layout/images/bilta_logo_one.png')}}">
             </div>
            </div>

        </div>
        @if(auth()->check())
        @else
            @include('layouts.webpages.nav')
        @endif
    </header>
</div>

@if(  isset($slot) )
    {{$slot}}
@else
    @yield('content')
@endif

@if(auth()->check())
@else
@include('layouts.webpages.footer')
@endif
<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>


<livewire:scripts/>
{{--@livewireScripts--}}


<!-- JAVASCRIPTS -->
<script src="{{asset('layout/scripts/jquery.min.js')}}"></script>
<script src="{{asset('layout/scripts/jquery.backtotop.js')}}"></script>
<script src="{{asset('layout/scripts/jquery.mobilemenu.js')}}"></script>
<!-- Homepage specific -->
<script src="{{asset('layout/scripts/jquery.easypiechart.min.js')}}"></script>
<!-- / Homepage specific -->


@stack('custom-scripts')

</body>
</html>
@endif
