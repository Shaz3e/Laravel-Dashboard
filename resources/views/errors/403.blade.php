@extends('layouts.other-app')
@section('body_class')
    error
@endsection

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 403</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Unauthorized Action.</h3>
                <p>You are not authorized to perform this action.
                    <a href="javascript:void(0)" onclick="history.go(-1)" class="text-theme">return back</a>.
                </p>
            </div>
        </div>
    </section>
@endsection