<?php

namespace App\Tools\Cropper;

use Illuminate\Http\Request;
use App\Models\User;

abstract class Uploader
{
	protected $request, $input;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function take($input)
	{
		$this->input = $input;

		return $this;
	}

	public function upload()
	{
		return $this->update();
	}

	public function update()
	{
		\Storage::disk('public')->delete(auth()->user()->avatar_url);
		
		return $this->save();
	}
}
