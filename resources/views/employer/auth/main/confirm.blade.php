@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">本会員登録確認</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('employer.main.register') }}">
                        @csrf
                        <input type="hidden" name="email_token" value="{{ $email_token }}">
                        <div class="form-group row">
                            <label for="cname" class="col-md-4 col-form-label text-md-right"> 会社名</label>
                            <div class="col-md-6">
                                <span class="">{{$company->cname}}</span>
                                <input type="hidden" name="cname" value="{{$company->cname}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-md-4 col-form-label text-md-right"> ご担当者様</label>
                            <div class="col-md-6">
                                <span class="">{{$employer->last_name}}</span>
                                <input type="hidden" name="last_name" value="{{$employer->last_name}}">
                            </div>
                            <div class="col-md-6">
                                <span class="">{{$employer->first_name}}</span>
                                <input type="hidden" name="first_name" value="{{$employer->first_name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ceo" class="col-md-4 col-form-label text-md-right">代表者様</label>
                            <div class="col-md-6">
                                <span class="">{{$company->ceo}}</span>
                                <input type="hidden" name="ceo" value="{{$company->ceo}}">
                            </div>
                        </div>

                      

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    本登録
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
