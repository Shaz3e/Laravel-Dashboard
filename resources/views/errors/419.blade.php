@extends('layouts.other-app')
@section('body_class')
    error
@endsection

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 419</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page Expired.</h3>
                <p>We could not find the page you were looking for. Meanwhile, you may
                    <a href="javascript:void(0)" onclick="history.go(-1)" class="text-theme">return back</a>.
                </p>
            </div>
        </div>
    </section>
@endsection