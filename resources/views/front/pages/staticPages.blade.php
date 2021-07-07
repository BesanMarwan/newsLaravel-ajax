@extends('front.layouts.site')
@section('content')
<div class="container">
    @if($Page)
        <div class="bredcrumb mar-60 ">
            <nav aria-label="breadcrumb ">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('front.home')}}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$Page->title}}</li>
                </ol>
            </nav>
        </div>
        <div class="row d-flex ">
            {!! $Page->content !!}
        </div>
        @endif
    </div>

@endsection
