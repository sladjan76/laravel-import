@extends('layouts.auth')

@section('content')
        <section class="reset-lp" style="background-color: #fff;">
            <div class="row">
                <div class="col-md-3">
                &nbsp;
                </div>
                <div class="col-md-6">
                    <div>
                        <h1><font color="fff">Password Reset</font></h1>

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

                        <form method="post" action="/api/resetPassword" id="form_u" data-parsley-validate>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $id }}">

                            <div class="form-group">
                                <label for="current_password">New Password</label>
                                <input type="password" class="form-control" name="new_password" data-parsley-required="true" data-parsley-error-message="Please enter new password" placeholder="*********"/>
                            </div>
                            <button type="submit" name="button" class="btn btn-download blue-btn">Save</button>
                        </form>
                    </div>
                    <br>
                </div>
                <div class="col-md-3">
                &nbsp;
                </div>
            </div>
        </section>

@endsection