<?php

namespace App\Tools\Cropper;

class ImageUpload extends Uploader
{
	protected $cropped = false;

	public function cropped()
	{
		$this->cropped = true;

		return $this;
	}

	public function save()
	{
		$cropper = (new Cropper($this->request, $this->cropped));

		return $cropper->make($this->input)->store('users/avatars');
	}
}
