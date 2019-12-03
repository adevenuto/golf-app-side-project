<?php 
namespace App\Traits;

use ImageIntervention;

trait ImageHelpers {

    public function getFileComponents($file) {
        
        $filenamewithextension = $file->getClientOriginalName();
        $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
        $getRealPath = $file->getRealPath();
        $extension = $file->getClientOriginalExtension();
        $mimeType = $file->getMimeType();
        
        return array(
            'filenamwWithExtenstion' => $filenamewithextension,
            'filename' => $filename,
            'extension' => $extension,
            'getRealPath' => $getRealPath,
            'mimeType' => $mimeType,
        );
        
    }

    public function resizeImage($image, $width, $height) {

        $img = ImageIntervention::make($image->getRealPath());
        $img->resize($width, $height);
        $img_resized = $img->stream();
        return $img_resized;
        
    }

    public function test() {
        return 'Hello';
    }

}