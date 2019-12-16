@extends('layouts.frontLayout.front_design')

@section('content')
    <section id="form" style="margin-top: 20px;"><!--form-->
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Check Out</li>
                </ol>
            </div>
            @if(Session::has('flash_message_error'))
                {{--{!! session('flash_message_error')!!}--}}
                <div class="alert alert-warning alert-block">
                    <button type="button" class="close" data-dismiss="alert">x</button>
                    <strong> {!! session('flash_message_error') !!} </strong>
                </div>
            @endif
            <form action="{{ url('/checkout') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-1">
                        <div class="login-form"><!--login form-->
                            <h2>Bill To</h2>
                            <div class="form-group">
                                <input name="billing_name" class="form-control" id="billing_name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif type="text" placeholder="Billing Name" />
                            </div>

                            <div class="form-group">
                                <input name="billing_address" class="form-control" id="billing_address" @if(!empty($userDetails->address)) value="{{ $userDetails->address }}" @endif type="text" placeholder="Billing Address" />
                            </div>

                            <div class="form-group">
                                <input name="billing_city" class="form-control" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif type="text" placeholder="Billing City" />
                            </div>

                            <div class="form-group">
                                <input name="billing_state" class="form-control" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif type="text" placeholder="Billing State" />
                            </div>


                            <div class="form-group">
                                <select id="billing_country" name="billing_country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name== $userDetails->country) selected @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input name="billing_pincode" class="form-control" id="billing_pincode" @if(!empty($userDetails->pincode)) value="{{ $userDetails->pincode }}" @endif type="text" placeholder="Billing Pincode" />
                            </div>

                            <div class="form-group">
                                <input name="billing_mobile" class="form-control" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif type="text" placeholder="Billing Mobile" />
                            </div>

                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="copyAddress">
                                <label class="form-check-label" for="copyAddress">Shipping Address same as Billing Address</label>
                            </div>
                        </div><!--/login form-->
                    </div>
                    <div class="col-sm-1">
                        <h2></h2>
                    </div>
                    <div class="col-sm-4">
                        <div class="signup-form"><!--sign up form-->
                            <h2>Ship To</h2>

                            <div class="form-group">
                                <input name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif class="form-control" type="text" placeholder="Shipping Name" />
                            </div>

                            <div class="form-group">
                                <input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif class="form-control" type="text" placeholder="Shipping Address" />
                            </div>

                            <div class="form-group">
                                <input name="shipping_city" id="shipping_city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif class="form-control" type="text" placeholder="Shipping City" />
                            </div>


                            <div class="form-group">
                                <input name="shipping_state" id="shipping_state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}"  @endif class="form-control" type="text" placeholder="Shipping State" />
                            </div>

                            <div class="form-group">
                                <select id="shipping_country" name="shipping_country" class="form-control">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->country_name }}" @if(!empty($shippingDetails->country) && $country->country_name== $shippingDetails->country) selected @endif>{{ $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif class="form-control" type="text" placeholder="Shipping Pincode" />
                            </div>

                            <div class="form-group">
                                <input id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif name="shipping_mobile" class="form-control" type="text" placeholder="Shipping Mobile" />
                            </div>
                            <button type="submit" class="btn btn-success">Checkout</button>
                        </div><!--/sign up form-->
                    </div>
                </div>
            </form>
        </div>
    </section><!--/form-->



@endsection