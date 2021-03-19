@extends('layouts.dashboards', ['menu' => 'wallpapers'])


@section('content')
    
    @if(session('flash'))
        <div class="alert alert-primary">
            {{ session('flash') }}
        </div>
    @endif
                
    <div class="card">
        <div class="card-body" style="padding: 5%;">
            <div class="row">
                <a href="{{ route('wallpapers.create') }}" class="btn btn-primary"> Create New wallpaper</a>
            </div>
            <br>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Image</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($wallpapers as $wallpaper)
                                    <tr>
                                        <td>{{ $wallpaper->id }}</td>
                                        <td>
                                            <img src="{{ asset('uploads/'.$wallpaper->texture_url) }}" class="img-responsive" alt="Wallpaper Thumbnail Photo" />
                                        </td>
                                        <td>{{ $wallpaper->sign_date }}</td>
                                        <td>
                                            <a href="{{ route('wallpapers.show', $wallpaper->id) }}" class="btn btn-primary btn-sm btn-flat">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="" onclick="event.preventDefault();
                                                 document.getElementById('delete-form-{{$wallpaper->id}}').submit();" class="btn btn-danger btn-sm btn-flat">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <form id="delete-form-{{$wallpaper->id}}" action="{{ route('wallpapers.destroy', $wallpaper->id) }}" method="POST" style="display: none;">
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