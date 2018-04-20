@extends("layouts.${SKIN_NAME}.app")
@section('title', 'welcome!')

@section('content')
    <div class="row">
        <div class="col-sm-12">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="description">newest pilots</h2>
        </div>
        @foreach($users as $user)
        <div class="col-sm-3 ">
            <div class="card card-signup blue-bg">
                {{--<div class="card-bg">--}}
                    {{--<i class="fa fa-user-o" style="opacity: .1;"></i>--}}
                {{--</div>--}}
                <div class="header header-primary text-center blue-bg">
                    <h3 class="title title-up text-white">
                        <a href="{!! route('frontend.profile.show', ['id' => $user->id]) !!}" class="text-white">{!! $user->name !!}</a>
                    </h3>
                    <div class="photo-container">
                        <img class="rounded-circle"
                             src="{!! $user->gravatar(123) !!}">
                    </div>
                </div>
                <div class="content content-center">
                    <div class="social-description text-center text-white">
                        <h2 class="description text-white">
                            @if(filled($user->home_airport))
                            {!! $user->home_airport->icao !!}
                            @endif
                        </h2>
                    </div>
                </div>
                <div class="footer text-center">
                    <a href="{!! route('frontend.profile.show', ['id' => $user->id]) !!}" class="btn btn-neutral btn-sm">Profile</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
