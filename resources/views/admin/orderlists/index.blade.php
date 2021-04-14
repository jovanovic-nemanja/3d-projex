@extends('layouts.dashboards', ['menu' => 'orders'])


@section('content')
    
    @if(session('flash'))
        <div class="alert alert-primary">
            {{ session('flash') }}
        </div>
    @endif
                
    <div class="card">
        <div class="card-body" style="padding: 5%;">
            <div class="row">
                
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Order Number</th>
                                    <th>Model Name</th>
                                    <th>User Name</th>
                                    <th>Model Photo</th>
                                    <th>Model Price</th>
                                    <th>Order Count</th>
                                    <th>Order Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderlists as $orderlist)
                                <tr>
                                    <td>{{ $orderlist->id }}</td>
                                    <td>{{ $orderlist->order_number }}</td>
                                    <td>{{ $orderlist->model_name }}</td>
                                    <td>{{ App\User::getUsername($orderlist->userid) }}</td>
                                    <td>
                                        <img src="{{ $orderlist->model_photo }}" alt="Model Photo" />
                                    </td>
                                    <td>{{ $orderlist->model_price }}</td>
                                    <td>{{ $orderlist->order_count }}</td>
                                    <td>{{ $orderlist->order_date }}</td>
                                    <td>
                                        <a href="" onclick="event.preventDefault();
                                             document.getElementById('delete-form-{{$orderlist->id}}').submit();" class="btn btn-danger btn-sm btn-flat">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        <form id="delete-form-{{$orderlist->id}}" action="{{ route('orderlists.destroy', $orderlist->id) }}" method="POST" style="display: none;">
                                              <input type="hidden" name="_method" value="delete">
                                              @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop