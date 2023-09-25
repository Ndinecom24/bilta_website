<div>

    <body>
    <div class="section-title mt-4">
        <div class="container">
            <h1 class="text-center text-uppercase mb-5">Weekly Prayer Points</h1>
            <div class="row">
                <div class="col-12">
                    <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="col-12">
                            <form >
                                <div class="row">
                                    <div class="col-md-2 form-group " >
                                        <input type="date" name="start_date" class="form-control" id="start_date" required>
                                    </div>
                                    <div class="col-md-2 form-group ">
                                        <input type="date" class="form-control" name="end_date" id="end_date"  required>
                                    </div>
                                    <div class="col-md-2 form-group ">
                                        <button wire:click="search()" class="form-control" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <br>
            <div class="row flex-center">
                <div class="col-sm-12 col-md-8">

                    <div class="accordion" id="accordionOne">
                        @foreach($dataset as $key=>$item)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading{{$key}}">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                    <div class="circle-icon"><i class="fa fa-question"></i></div>
                                    <span>{{$item->title}}</span></button>
                            </h2>
                            <div id="collapse{{$key}}" class="accordion-collapse collapse @if( $key==0) show @endif" aria-labelledby="heading{{$key}}"
                                 data-bs-parent="#accordion{{$key}}">
                                <div class="accordion-body">
                                    {{$item->details}}
                                    <br>
                                    <strong>{{$item->scriptures}}</strong>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 "
                     data-aos="fade-right">
                    <img src="{{asset('assets/img/project-translation.jpg')}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
    </body>

    {{--    <div class="section-title mt-4">--}}
    {{--        <h2 data-aos="fade-up">Weekly Prayer Points</h2>--}}
    {{--        </div>--}}

    {{--        <div class="row m-3">--}}
    {{--        <div class="col-lg-12 text-center">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}
    {{--                    <div class="card-title">--}}
    {{--                        <h2> Today's Prayer Point</h2>--}}
    {{--                    </div>--}}
    {{--                    <hr>--}}
    {{--                    <h3 class="card-text">Prayer Point</h3>--}}
    {{--                    <p class="card-text">Guidance and Direction</p>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}

    {{--            <div class="col-lg-12 text-center">--}}
    {{--                <div class="card">--}}
    {{--                    <div class="card-body">--}}
    {{--                        <div class="card-title">--}}
    {{--                            <h2> Today's Prayer Point</h2>--}}
    {{--                        </div>--}}
    {{--                        <hr>--}}
    {{--                        <h3 class="card-text">Prayer Point</h3>--}}
    {{--                        <p class="card-text">Guidance and Direction</p>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</div>
