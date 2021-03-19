@extends('layouts.dashboards', ['menu' => 'add_wallpaper'])

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
                    <form action="{{ route('wallpapers.update', $wallpaper->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="_method" value="put">

                        <div class="box">
                            <div class="box-body">
                                <?php 
                                    if(@$wallpaper->texture_url) {
                                        $texture_url = asset('uploads/') . "/" . $wallpaper->texture_url;
                                    }else{
                                        $texture_url = "";
                                    }
                                ?>

                                <div class="form-group {{ $errors->has('texture_url') ? 'has-error' : '' }}">
                                    <label>Image</label>
                                    <div class="controls">
                                        <span>
                                            <input type="file" name="texture_url" id="file" onchange="loadPreview(this, 'preview_img');" class="inputfile texture_url" accept="image/*">
                                            <label for="file" @click="onClick" inputId="1" style="background-image: url(<?= $texture_url ?>);" id='preview_img'><i class="fa fa-plus-circle"></i></label>
                                        </span>
                                    </div>

                                    @if ($errors->has('texture_url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('texture_url') }}</strong>
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