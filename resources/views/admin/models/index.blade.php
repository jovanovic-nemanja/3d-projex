@extends('layouts.dashboards', ['menu' => 'models'])


@section('content')
    
    @if(session('flash'))
        <div class="alert alert-primary">
            {{ session('flash') }}
        </div>
    @endif
                
    <div class="card">
        <div class="card-body" style="padding: 5%;">
            <div class="row">
                <a href="{{ route('models.create') }}" class="btn btn-primary"> Create New model</a>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Texture Image</th>
                                    <th>Model link</th>
                                    <th>Price</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->id }}</td>
                                        <td>{{ $model->name }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/'.$model->image) }}" class="img-responsive" alt="Model Thumbnail Photo" />
                                        </td>
                                        <td>
                                            <img src="{{ asset('uploads/'.$model->texture_image) }}" class="img-responsive" alt="Model Texture Photo" />
                                        </td>
                                        <td>{{ $model->model }}</td>
                                        <td>{{ $model->price }}</td>
                                        <td>{{ App\Models::getType($model->type) }}</td>
                                        <td>{{ $model->sign_date }}</td>
                                        <td>
                                            <a href="{{ route('models.show', $model->id) }}" class="btn btn-primary btn-sm btn-flat">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="" onclick="event.preventDefault();
                                                 document.getElementById('delete-form-{{$model->id}}').submit();" class="btn btn-danger btn-sm btn-flat">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <form id="delete-form-{{$model->id}}" action="{{ route('models.destroy', $model->id) }}" method="POST" style="display: none;">
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