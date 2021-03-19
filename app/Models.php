<?php

namespace App;

use App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    public $table = 'models';
	
    public $fillable = ['name', 'image', 'texture_image', 'model', 'price', 'type', 'sign_date'];

    /**
    * @param type as integer
    * @author Nemanja
    * @return type as string
    * @since 2021-03-19
    */
    public static function getType($type) {
    	switch ($type) {
    		case '1':
    			$type = "FloorItem";
    			break;

    		case '2':
    			$type = "WallItem";
    			break;

    		case '3':
    			$type = "InWallItem";
    			break;

    		case '7':
    			$type = "InWallFloorItem";
    			break;

    		case '8':
    			$type = "OnFloorItem";
    			break;

    		case '9':
    			$type = "WallFloorItem";
    			break;
    		
    		default:
    			$type = "FloorItem";
    			break;
    	}

    	return $type;
    }

    /**
    * @param model_id
    * @since 2021-03-19
    * @author Nemanja
    * This is a feature to upload a model image
    */
    public static function upload_model_image($model_id, $existings = null) {
        if(!request()->hasFile('image')) {
            return false;
        }

        Storage::disk('public_local')->put('uploads/', request()->file('image'));

        self::save_img($model_id, request()->file('image'));
    }

    /**
    * file upload
    * @param model_id and image file
    * @return boolean true or false
    * @since 2021-03-19
    * @author Nemanja
    */
    public static function save_img($model_id, $image) {
        $model = Models::where('id', $model_id)->first();

        if($model) {
            Storage::disk('public_local')->delete('uploads/', $model->image);
            $model->image = $image->hashName();
            $model->update();
        }
    }

    /**
    * @param model_id
    * @since 2021-03-19
    * @author Nemanja
    * This is a feature to upload a model texture image
    */
    public static function upload_model_texture_image($file) {
        $target_dir = "uploads/";
        $filename = $_FILES["texture_image"]["name"];
        $target_file = $target_dir . basename($_FILES["texture_image"]["name"]);

        if (move_uploaded_file($_FILES["texture_image"]["tmp_name"], $target_file)) {
            $result = $filename;
        }else{
            $result = "";
        }

        return $result;
    }

    /**
    * @param model id file
    * @since 2021-03-19
    * @author Nemanja
    * This is a feature to upload a model js file
    */
    public static function upload_model_js($model_id, $existings = null) {
        $target_dir = "uploads/";
        $filename = $_FILES["model"]["name"];
        $target_file = $target_dir . basename($_FILES["model"]["name"]);

        if (move_uploaded_file($_FILES["model"]["tmp_name"], $target_file)) {
            $result = $filename;
        }else{
            $result = "";
        }

        return $result;
    }

    /**
    * delete the uploaded file
    * @param model_id and js file
    * @return boolean true or false
    * @since 2021-03-19
    * @author Nemanja
    */
    public static function delete_file($model_id) {
        $model = Models::where('id', $model_id)->first();
        $path = "uploads";

        if ($model->model) {
        	unlink($path . "/" . $model->model) or die("Failed to <strong class='highlight'>delete</strong> file");
        }
        if ($model->image) {
        	unlink($path . "/" . $model->image) or die("Failed to <strong class='highlight'>delete</strong> file");
        }
        if ($model->texture_image) {
        	unlink($path . "/" . $model->texture_image) or die("Failed to <strong class='highlight'>delete</strong> file");
        }

		return true;
    }
}
