<?php

namespace App;

use App\Screenshots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Screenshots extends Model
{
    public $table = 'screenshots';
	
    public $fillable = ['orderNumber', 'screenshot'];

    /**
    * @return file name
    * @author Nemanja
    * @since 2021-04-17
    * This is a feature to upload a screen shot image
    */
    public static function upload_file($file) 
    {
        $image = $file;

        $location = "uploads/";

        $image_parts = explode(";base64,", $image);

        $image_base64 = base64_decode($image_parts[1]);

        $filename = "screenshot_".uniqid().'.png';

        $file = $location . $filename;

        if (file_put_contents($file, $image_base64)) {
            $result = $filename;
        }else{
            $result = "";
        }

        return $result;
    }
}
