<?php

namespace App;

use App\Wallpapers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Wallpapers extends Model
{
    public $table = 'wallpapers';
	
    public $fillable = ['texture_url', 'created_by', 'sign_date'];

    /**
    * @param wallpaper id
    * @since 2021-03-19
    * @author Nemanja
    * This is a feature to upload a wallpaper image
    */
    public static function upload_texture_image($wallpaper_id, $existings = null) {
        if(!request()->hasFile('texture_url')) {
            return false;
        }

        Storage::disk('public_local')->put('uploads/', request()->file('texture_url'));

        self::save_img($wallpaper_id, request()->file('texture_url'));
    }

    /**
    * file upload
    * @param wallpaper_id and image file
    * @return boolean true or false
    * @since 2021-03-19
    * @author Nemanja
    */
    public static function save_img($wallpaper_id, $image) {
        $wallpaper = Wallpapers::where('id', $wallpaper_id)->first();

        if($wallpaper) {
            Storage::disk('public_local')->delete('uploads/', $wallpaper->texture_url);
            $wallpaper->texture_url = $image->hashName();
            $wallpaper->update();
        }
    }

    /**
    * delete the uploaded file
    * @param model_id and js file
    * @return boolean true or false
    * @since 2021-03-19
    * @author Nemanja
    */
    public static function delete_file($wallpaper_id) {
        $wallpaper = Wallpapers::where('id', $wallpaper_id)->first();
        $path = "uploads";

        if ($wallpaper->texture_url) {
        	unlink($path . "/" . $wallpaper->texture_url) or die("Failed to <strong class='highlight'>delete</strong> file");
        }

		return true;
    }
}
