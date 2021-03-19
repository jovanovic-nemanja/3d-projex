@extends('layouts.dashboards', ['menu' => 'add_model'])

@section('content')
    @if(session('flash'))
        <div class="alert alert-primary">
            {{ session('flash') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body" style="padding: 5%;">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('models.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="box">
                            <div class="box-body">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label>Name</label>
                                    <input required type="text" name="name" class="form-control" placeholder="Name" />

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                                    <label>Image</label>
                                    <div class="controls">
                                        <span>
                                            <input type="file" name="image" id="file" onchange="loadPreview(this, 'preview_img');" class="inputfile image" required accept="image/*">
                                            <label for="file" @click="onClick" inputId="1" style="" id='preview_img'><i class="fa fa-plus-circle"></i></label>
                                        </span>
                                    </div>

                                    @if ($errors->has('image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('texture_image') ? 'has-error' : '' }}">
                                    <label>Texture Image</label>
                                    <div class="controls">
                                        <span>
                                            <input type="file" name="texture_image" id="texture_image" class="form-control texture_image" accept="image/*">
                                        </span>
                                    </div>

                                    @if ($errors->has('texture_image'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('texture_image') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('model') ? 'has-error' : '' }}">
                                    <label>Model</label>
                                    <div class="controls">
                                        <span>
                                            <input type="file" name="model" id="file" class="form-control model" required accept=".js">
                                        </span>
                                    </div>

                                    @if ($errors->has('model'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('model') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                    <label>Price</label>
                                    <input required type="number" name="price" class="form-control" placeholder="Price" />

                                    @if ($errors->has('price'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('price') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
                                    <label>Type</label>
                                    <select required class="form-control" name="type">
                                        <option>Choose</option>
                                        <option value="1">FloorItem</option>
                                        <option value="2">WallItem</option>
                                        <option value="3">InWallItem</option>
                                        <option value="7">InWallFloorItem</option>
                                        <option value="8">OnFloorItem</option>
                                        <option value="9">WallFloorItem</option>
                                    </select>

                                    @if ($errors->has('type'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('type') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="box-footer">
                                <button type="submit" class="btn btn-success pull-right">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

<style type="text/css">
    .inputfile {
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .inputfile + label {
        font-size: 1.25em;
        font-weight: 700;
        color: white;
        background-color: #E9ECEF;
        padding: 50px;
        display: inline-block;
        cursor: pointer;
        background-size: contain;
        width: 100%;
        background-repeat: no-repeat;
    }

    .inputfile:focus + label,
    .inputfile + label:hover {
        /*background-color: #38C172ed;*/
    }

    .hidden {
        display: none !important;
    }
</style>

@section('script')
    <script>
        function loadPreview(input, id) {
            id = "#" + id;
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var path = "background-image: " + "url('" + e.target.result + "')";
                    $(id).attr('style', path);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection