@extends('layouts.app')

@section('body')
<main class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            {{-- <div class="col-md-8">
                <div class="card"> --}}
                   <app-guest></app-guest>
                {{-- </div>
            </div> --}}
        </div>
    </div>
</main>
@endsection
