<?php

namespace App\Tools\Cropper;

use Illuminate\Http\Request;

class Cropper
{
	protected $request, $file, $image, $filename, $crop, $name;

	public function __construct(Request $request, bool $crop)
	{
		$this->request = $request;
		$this->crop = $crop;
	}

	public function make($name)
	{
		$this->file = $this->request->file($name);

        $this->image = \Image::make($this->file);

        if ($this->crop) {
        	$this->image = $this->image->crop(
	            intval($this->request->cropped_width),
	            intval($this->request->cropped_height), 
	            intval($this->request->cropped_x), 
	            intval($this->request->cropped_y)
	        );
        }

        return $this;
	}

	public function getPath($folder)
	{
		$filename = md5(auth()->user()->id.now()->timestamp);
		$ext = str_replace('image/', '.', $this->image->mime());

		return $folder.'/'.$filename.$ext;
	}

	public function store($folder)
	{
		$this->image->resize(200,200);
		
		$path = $this->getPath($folder);

		\Storage::disk('public')->put($path, (string) $this->image->encode());

		return $path;
	}
}
