@extends('layouts.app')
@section('content')

{{-- <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center"> --}}
<div class="row pt-5">
    <div class="col-lg-6 offset-lg-3">
        <h1 id="headingmain" class="mb-3 text-center">Laravel + Vue Todo App</h1>
        <todo-component></todo-component>
    </div>
</div>

@endsection