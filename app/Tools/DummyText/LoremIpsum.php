<?php

namespace App\Tools\DummyText;

use App\Tools\DummyText\{Paragraphs, Words};

class LoremIpsum
{
	use Paragraphs, Words;

	public function getWords($count)
	{
		$array = explode(' ', $this->words);
		$data = [];

		for ($i=0; $i < $count; $i++) { 
			shuffle($array);
			array_push($data, ucFirst($array[0]));
		}

		return implode(' ', $data);
	}

	public function getParagraphs($count)
	{
		$data = [];

		for ($i=0; $i < $count; $i++) { 
			shuffle($this->strophes);
			array_push($data, $this->strophes[0]);
		}

		return implode(PHP_EOL, $data);
	}

	public function wordsBetween($min, $max)
	{
		return $this->getWords(rand($min, $max));
	}

	public function paragraphsBetween($min, $max)
	{
		return $this->getParagraphs(rand($min, $max));
	}
}