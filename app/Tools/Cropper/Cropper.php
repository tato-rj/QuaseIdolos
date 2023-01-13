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
		$this->image = \Image::make($this->request->file($name));

        if ($this->crop)
	        $this->crop();

        $this->resize(400);

	    $this->convertTo('jpg', 75);

        return $this;
	}

	public function getPath($folder)
	{
		$filename = md5(auth()->user()->id.now()->timestamp);
		$ext = str_replace('image/', '.', $this->image->mime());

		return $folder.'/'.$filename.$ext;
	}

	public function convertTo($ext, $quality)
	{
		$this->image = $this->image->encode($ext, $quality);
	}

	public function crop()
	{
    	$this->image = $this->image->crop(
            intval($this->request->cropped_width),
            intval($this->request->cropped_height), 
            intval($this->request->cropped_x), 
            intval($this->request->cropped_y)
        );
	}

	public function resize($size)
	{
		if ($this->image->width() > $size)
			$this->image = $this->image->resize($size,$size);
	}

	public function store($folder)
	{
		$path = $this->getPath($folder);

		\Storage::disk('public')->put($path, (string) $this->image);

		return $path;
	}
}
