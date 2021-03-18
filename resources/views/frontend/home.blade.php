@extends('layouts.front')

@section('content')

<div class="container-fluid">
      <div class="row main-row">
        <!-- Left Column -->
        <div class="col-xs-2 sidebar">
          <div>
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo1.png') }}" style="width: 100%; padding-bottom: 10%;" /></a>
          </div>
          
          <!-- Main Navigation -->
          <ul class="nav nav-sidebar">
            <!-- <li id="floorplan_tab"><a href="#">
              Edit Floorplan
              <span class="glyphicon glyphicon-chevron-right pull-right"></span>
            </a></li> -->

            <li id="design_tab"><a href="#">
              Design
              <span class="glyphicon glyphicon-chevron-right pull-right"></span>
            </a></li>
            <li id="items_tab"><a href="#">
              Add Items
              <span class="glyphicon glyphicon-chevron-right pull-right"></span>
            </a></li>
            <li id="checkout_tab"><a href="#">
              Checkouts
              <span class="glyphicon glyphicon-chevron-right pull-right"></span>
            </a></li>
          </ul>

          <!-- Context Menu -->
          <div id="context-menu">
            <div style="margin: 0 20px">
              <span id="context-menu-name" class="lead"></span>
              <br /><br />
              <button class="btn btn-block btn-danger" id="context-menu-delete">
                <span class="glyphicon glyphicon-trash"></span> 
                Delete Item
              </button>
            <br />
            <div class="panel panel-default">
              <div class="panel-heading">Adjust Size</div>
              <div class="panel-body" style="color: #333333">

                <div class="form form-horizontal" class="lead">
                  <div class="form-group">
                    <label class="col-sm-5 control-label">
                       Width
                    </label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="item-width">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label">
                      Depth 
                    </label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="item-depth">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label">
                      Height
                    </label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control" id="item-height">
                    </div>
                  </div>
                </div>
                <small><span class="text-muted">Measurements in inches.</span></small>
              </div>
            </div>

            <label><input type="checkbox" id="fixed" /> Lock in place</label>
            <br /><br />
            </div>
          </div>

          <!-- Floor textures -->
          <div id="floorTexturesDiv" style="display:none; padding: 0 20px">
            <div class="panel panel-default">
              <div class="panel-heading">Adjust Floor</div>
              <div class="panel-body" style="color: #333333">

                <div class="col-sm-6" style="padding: 3px">
                  <a href="#" class="thumbnail texture-select-thumbnail" texture-url="{{ asset('3d/rooms/textures/light_fine_wood.jpg') }}" texture-stretch="false" texture-scale="300">
                    <img alt="Thumbnail light fine wood" src="{{ asset('3d/rooms/thumbnails/thumbnail_light_fine_wood.jpg') }}" />
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Wall Textures -->
          <div id="wallTextures" style="display:none; padding: 0 20px">
            <div class="panel panel-default">
              <div class="panel-heading">Adjust Wall</div>
              <div class="panel-body" style="color: #333333">
                <div class="" style="padding: 3px">
                  <a href="#" class="thumbnail texture-select-thumbnail" texture-url="{{ asset('3d/rooms/textures/uae.jpg') }}" texture-stretch="false" texture-scale="400">
                    <img alt="Thumbnail marbletiles" src="{{ asset('3d/rooms/thumbnails/uae.jpg') }}" />
                  </a>
                </div>
                <div class="" style="padding: 3px">
                  <a href="#" class="thumbnail texture-select-thumbnail" texture-url="{{ asset('3d/rooms/textures/burjkalifatower.jpg') }}" texture-stretch="false" texture-scale="400">
                    <img alt="Thumbnail marbletiles" src="{{ asset('3d/rooms/thumbnails/burjkalifatower.jpg') }}" />
                  </a>
                </div>
                <div class="" style="padding: 3px">
                  <a href="#" class="thumbnail texture-select-thumbnail" texture-url="{{ asset('3d/rooms/textures/marbletiles.jpg') }}" texture-stretch="false" texture-scale="300">
                    <img alt="Thumbnail marbletiles" src="{{ asset('3d/rooms/thumbnails/thumbnail_marbletiles.jpg') }}" />
                  </a>
                </div>
                <div class="" style="padding: 3px">
                  <a href="#" class="thumbnail texture-select-thumbnail" texture-url="{{ asset('3d/rooms/textures/wallmap_yellow.png') }}" texture-stretch="true" texture-scale="">
                    <img alt="Thumbnail wallmap yellow" src="{{ asset('3d/rooms/thumbnails/thumbnail_wallmap_yellow.png') }}" />
                  </a>
                </div>
                <div class="" style="padding: 3px">
                  <a href="#" class="thumbnail texture-select-thumbnail" texture-url="{{ asset('3d/rooms/textures/light_brick.jpg') }}" texture-stretch="false" texture-scale="100">
                    <img alt="Thumbnail light brick" src="{{ asset('3d/rooms/thumbnails/thumbnail_light_brick.jpg') }}" />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column -->
        <div class="col-xs-10 main">

          <!-- 3D Viewer -->
          <div id="viewer">

            <div id="main-controls">
              	<a href="#" class="btn btn-default btn-sm" id="new">
              	  	New Plan
              	</a>
              	<a href="#" class="btn btn-default btn-sm" id="saveFile">
              	  	Save Plan
              	</a>
              	<a class="btn btn-sm btn-default btn-file">
              	 	<input type="file" class="hidden-input" id="loadFile">
              	 	Load Plan
              	</a>
              	<a class="btn btn-sm btn-default btn-file screenshot">
              	  	Screenshot
              	</a>

	          	@guest
	            @else
	                <a class="btn btn-sm btn-danger dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
	                    <i class="dropdown-item-icon icon-power text-primary"></i>
	                    {{ __('Logout') }}({{ Auth::user()->username }})
	                </a>
	                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                    @csrf
	                </form>
	            @endguest
            </div>

            <div id="right_top_panel">
              <div class="row">
                <table class="form-control table table-scroll">
                  <thead>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Count</td>
                    <td>Price</td>
                    <td>All Price</td>
                  </thead>
                  <tbody id="shopping_cart_table">
                    
                  </tbody>
                </table>
              </div>

              <h4 class="total_price"><button class="btn btn-default btn-medium checkout">Checkout</button> &nbsp; &nbsp; <span class="price">0 </span> AED</h4>
            </div>

            <div id="camera-controls">
              <a href="#" class="btn btn-default bottom" id="zoom-out">
                <span class="glyphicon glyphicon-zoom-out"></span>
              </a>
              <a href="#" class="btn btn-default bottom" id="reset-view">
                <span class="glyphicon glyphicon glyphicon-home"></span>
              </a>
              <a href="#" class="btn btn-default bottom" id="zoom-in">
                <span class="glyphicon glyphicon-zoom-in"></span>
              </a>
              
              <span>&nbsp;</span>

              <a class="btn btn-default bottom" href="#" id="move-left" >
                <span class="glyphicon glyphicon-arrow-left"></span>
              </a>
              <span class="btn-group-vertical">
                <a class="btn btn-default" href="#" id="move-up">
                  <span class="glyphicon glyphicon-arrow-up"></span>
                </a>
                <a class="btn btn-default" href="#" id="move-down">
                  <span class="glyphicon glyphicon-arrow-down"></span>
                </a>
              </span>
              <a class="btn btn-default bottom" href="#" id="move-right" >
                <span class="glyphicon glyphicon-arrow-right"></span>
              </a>
            </div>

            <div id="loading-modal">
              <h1>Loading...</h1>  
            </div>
          </div>

          <!-- 2D Floorplanner -->
          <div id="floorplanner">
            <canvas id="floorplanner-canvas"></canvas>
            <div id="floorplanner-controls">

              <button id="move" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-move"></span>
                Move Walls
              </button>
              <button id="draw" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-pencil"></span>
                Draw Walls
              </button>
              <button id="delete" class="btn btn-sm btn-default">
                <span class="glyphicon glyphicon-remove"></span>
                Delete Walls
              </button>
              <span class="pull-right">
                <button class="btn btn-primary btn-sm" id="update-floorplan">Done &raquo;</button>
              </span>

            </div>
            <div id="draw-walls-hint">
              Press the "Esc" key to stop drawing walls
            </div>
          </div>

          <!-- Add Items -->
          <div id="add-items">
            <div class="row" id="items-wrapper">
            	<div class="col-sm-4">
            		<a class="thumbnail add-item" model-name="Bar Stool" model-url="{{ asset('3d/models/js/chair_1-2.js') }}" model-type="1" model-price="1000" model-image="{{ asset('3d/models/thumbnails/chair-red.png') }}">
            			<img class="add_model" src="{{ asset('3d/models/thumbnails/chair-red.png') }}" alt="Add Item">Bar Stool&nbsp; /&nbsp;  AED
        			</a>
            	</div>

            	<div class="col-sm-4">
            		<a class="thumbnail add-item" model-name="TV" model-url="{{ asset('3d/models/js/led_1-2.js') }}" model-type="2" model-price="2000" model-image="{{ asset('3d/models/thumbnails/TV.png') }}">
            			<img class="add_model" src="{{ asset('3d/models/thumbnails/TV.png') }}" alt="Add Item">TV&nbsp; /&nbsp; 2000 AED
        			</a>
            	</div>

            	<div class="col-sm-4">
            		<a class="thumbnail add-item" model-name="Round Table" model-url="{{ asset('3d/models/js/table_round.js') }}" model-type="1" model-price="500" model-image="{{ asset('3d/models/thumbnails/roundtable.png') }}">
            			<img class="add_model" src="{{ asset('3d/models/thumbnails/roundtable.png') }}" alt="Add Item">Round Table&nbsp; /&nbsp; 500 AED
        			</a>
            	</div>

            	<div class="col-sm-4">
            		<a class="thumbnail add-item" model-name="Box" model-url="{{ asset('3d/models/js/table4_1-2.js') }}" model-type="1" model-price="3000" model-image="{{ asset('3d/models/thumbnails/box.png') }}">
            			<img class="add_model" src="{{ asset('3d/models/thumbnails/box.png') }}" alt="Add Item">Box&nbsp; /&nbsp; 3000 AED
        			</a>
            	</div>

            	<div class="col-sm-4">
            		<a class="thumbnail add-item" model-name="Structure" model-url="{{ asset('3d/models/js/structure.js') }}" model-type="2" model-price="3300" model-image="{{ asset('3d/models/thumbnails/structure.png') }}">
            			<img class="add_model" src="{{ asset('3d/models/thumbnails/structure.png') }}" alt="Add Item">Structure&nbsp; /&nbsp; 3300 AED
        			</a>
            	</div>

            	<div class="col-sm-4">
            		<a class="thumbnail add-item" model-name="Wall Closet" model-url="{{ asset('3d/models/js/cobord.js') }}" model-type="1" model-price="5000" model-image="{{ asset('3d/models/thumbnails/wallpaper.png') }}">
            			<img class="add_model" src="{{ asset('3d/models/thumbnails/wallpaper.png') }}" alt="Add Item">Wall Closet&nbsp; /&nbsp; 5000 AED
        			</a>
            	</div>
            </div>
          </div>
          <!-- end items -->

          <!-- Add check out -->
          <div id="add-checkout">
            <div class="row">
              <div class="col-md-6">
                <table class="form-control table table-scroll">
                  <thead>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Photo</td>
                    <td>Count</td>
                    <td>Price</td>
                    <td>All Price</td>
                  </thead>
                  <tbody id="checkout_tbody">
                    
                  </tbody>
                </table>
                <br>
                <div class="row">
                  <div class="col-md-6"></div>
                  <div class="col-md-6 alignRight">
                    <button class="btn btn-primary inline-flex exportCSV">Export CSV</button>
                    <h4 class="total_price_checkout inline-flex"><span class="checkout_price">0 </span> AED</h4>
                  </div>
                </div>                
              </div>
            </div>
          </div>
          <!-- end check out -->
        </div>
        <!-- End Right Column -->
      </div>
    </div>

@stop
