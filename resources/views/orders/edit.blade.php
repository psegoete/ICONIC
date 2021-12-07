@extends('admin.layouts.default')
@section('content')
    <div class="clearfix">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Update order status</strong> 
                        <span class="center"> </span>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card-body">
                        <form method="POST" action="{{ route('orders.update', $order->id) }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }} ">
                                <label class="col-form-label" for="status">Status </label>
                                    <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }} " required="required" id="status" name="status">
                                        <option value="new" @if($order->status == 'new') selected @endif>Open</option>
                                        <option value="Cancelled" @if($order->status == 'Cancelled') selected @endif>Cancelled</option>
                                        <option value="Completed"  @if($order->status == 'Completed') selected @endif>Completed</option>
                                    </select>
            
                                        @if ($errors->has('status'))
                                            <span class="text-danger">{{ $errors->first('status') }}</span>
                                        @endif
                            </div>
                            
        
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-primary" onclick="this.disabled=true;this.form.submit();">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Order information</strong> 
                        <span class="center"> </span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Customer</strong>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Order description</strong>
                            </div>
                            <div class="col-md-6">
                                <p>	{{$order->description }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Order reference</strong>
                            </div>
                            <div class="col-md-6">
                                <p>	{{$order->order_reference }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Subtotal</strong>
                            </div>
                            <div class="col-md-6">
                                <p>{{$order->amount }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Total</strong>
                            </div>
                            <div class="col-md-6">
                                <p>{{$order->amount }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Order status</strong>
                            </div>
                            <div class="col-md-6">
                                <p>{{$order->status }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Invoice</strong>
                            </div>
                            <div class="col-md-6">
                                <p>
                                    <a href="{{ URL::to('/download/invoices/'. $order->id) }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary mb-2" data-original-title="Edit"><i class="fa fa-download "></i></a>
                                </p>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Items in this order
                        {{--  <a href="{{ route('transactions.create') }}" class="float-right"><i class="fas fa-plus-square"></i> Transaction</a>  --}}
                        
                    </div>
                    <div class="card-body">
                            
                        <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$order->description }}</td>
                                    <td>{{$order->amount }}</td>
                                    <td>1</td>
                                    <td>{{$order->amount }}</td>
                                    
                                </tr>
                            </tbody>
                            
                            
                        </table>
                        <div class="row">
                            <div class="col-12">
                                <div class="float-right" >

                                </div>
                            </div>
                         
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection