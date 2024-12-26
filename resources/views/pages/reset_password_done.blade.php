@extends('layouts.auth')

@section('content')
        <section class="reset-lp" style="background-color: #fff;">
            <div class="row">
                <div class="col-md-3">
                &nbsp;
                </div>
                <div class="col-md-6">
                    <div class="reset-lp-form frm-block">
                        <h1>Password Reset</h1>
                        
                        @if(Session::has('update_failure'))
                            <div class="alert alert-danger">
                                <em> {!! session('update_failure') !!}</em>
                            </div>
                        @endif

                        @if(Session::has('update_success'))
                            <div class="alert alert-success" id="successMessage">
                                <em> {!! session('update_success') !!}</em>
                            </div>
                        @endif
                    </div>
                    <br>
                </div>
                <div class="col-md-3">
                &nbsp;
                </div>
            </div>
        </section>

@endsection