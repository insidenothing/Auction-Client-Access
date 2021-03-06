<?php

class Line
{
	var $width = 20000;
	var $height = 250;
	var $bgCol;

	var $title = "Bar Graph - 123ashish.com";
	var $titleCol;

	var $dataValues = array();
	var $dataXLabels = array();
	var $dataSeriesLabels = array();
	var $barCol = array();
	var $axesCol;
	var $image;
	
	function InitializeColors()
	{
		$this->bgCol = ImageColorAllocate($this->image, 255, 255, 255);
		$this->titleCol = ImageColorAllocate($this->image, 0, 0, 0);

		$this->barCol[0] = ImageColorAllocate($this->image, 0, 0, 255);
		$this->barCol[1] = ImageColorAllocate($this->image, 0, 255, 0);
		$this->barCol[2] = ImageColorAllocate($this->image, 255, 0, 0);
		$this->barCol[3] = ImageColorAllocate($this->image, 0, 255, 255);
		$this->barCol[4] = ImageColorAllocate($this->image, 255, 0, 255);
		$this->barCol[5] = ImageColorAllocate($this->image, 255, 255, 0);
		$this->barCol[6] = ImageColorAllocate($this->image, 100, 100, 55);
		$this->barCol[7] = ImageColorAllocate($this->image, 55, 100, 100);
		$this->barCol[8] = ImageColorAllocate($this->image, 100, 55, 100);

		$this->axesCol = ImageColorAllocate($this->image, 200, 200, 200);
	}

	function Line()
	{
		$this->image = ImageCreate($this->width, $this->height);
		$this->InitializeColors();
		ImageFill($this->image, 0, 0, $this->bgCol);		
	}

	function SetDimensions($width, $height)
	{
		ImageDestroy($this->image);
		$this->height = $height;
		$this->width = $width;

		$this->image = ImageCreate($this->width, $this->height);
		InitializeColors();
		ImageFill($this->image, 0, 0, $this->bgCol);
	}

	function SetBGJPEGImage($file)
	{
		// SetBGJPEGImage() and SetDimensions() cannot be used together
		ImageDestroy($this->image);
		$this->image = ImageCreateFromJPEG($file);
		$this->width = ImageSX($this->image);
		$this->height = ImageSY($this->image);
		$this->InitializeColors();
	}
	function SetBGPngImage($file)
	{
		// SetBGPngImage() and SetDimensions() cannot be used together
		ImageDestroy($this->image);
		$this->image = ImageCreateFromPng($file);
		$this->width = ImageSX($this->image);
		$this->height = ImageSY($this->image);
		$this->InitializeColors();
	}
	function SetBGGifImage($file)
	{
		// SetBGGifImage() and SetDimensions() cannot be used together
		ImageDestroy($this->image);
		$this->image = ImageCreateFromGif($file);
		$this->width = ImageSX($this->image);
		$this->height = ImageSY($this->image);
		$this->InitializeColors();
	}
	function SetBGColor($bgR, $bgG, $bgB)
	{
		ImageColorDeallocate($this->image, $this->bgCol);
		$this->bgCol = ImagecolorAllocate($this->image, $bgR, $bgG, $bgB);
	}

	function SetTitle($title)
	{
		$this->title = $title;
	}

	function SetTitleColor($bgR, $bgG, $bgB)
	{
		ImageColorDeallocate($this->image, $this->titleCol);
		$this->titleCol = ImagecolorAllocate($this->image, $bgR, $bgG, $bgB);
	}

	function AddValue($xVal, $yVal)
	{
		// $yVal is an array of y values
		$this->dataValues[] = $yVal;
		$this->dataXLabels[] = $xVal;
	}

	function SetSeriesLabels($labels)
	{
		$this->dataSeriesLabels = $labels;
	}

	function SetBarColor($bgR, $bgG, $bgB)
	{
//		ImageColorDeallocate($this->image, $this->barCol);
//		$this->barCol = ImagecolorAllocate($this->image, $bgR, $bgG, $bgB);
	}

	function SetAxesColor($bgR, $bgG, $bgB)
	{
		ImageColorDeallocate($this->image, $this->axesCol);
		$this->axesCol = ImagecolorAllocate($this->image, $bgR, $bgG, $bgB);
	}

	function spit($type)
	{
		// spit out the graph

		$black = ImageColorAllocate($this->image, 0, 0, 0);

		// draw the box
		ImageLine($this->image, 0, 0, $this->width - 1, 0, $black);
		ImageLine($this->image, $this->width - 1, 0, $this->width - 1, $this->height - 1, $black);
		ImageLine($this->image, $this->width - 1, $this->height - 1, 0, $this->height - 1, $black);
		ImageLine($this->image, 0, $this->height - 1, 0, 0, $black);

		// draw the axes
		// Y
		for($i = 0; $i <= 4; $i++)
		{
			$tmpVal = 4 - $i;
			$y1 = 40 + (($tmpVal * ($this->height - 80)) / 4);
			ImageLine($this->image, 40, $y1, $this->width - 80, $y1, $this->axesCol);
		}
		// X
		ImageLine($this->image, 40, $this->height - 40, 40, 40, $this->axesCol);
		ImageLine($this->image, $this->width - 80, $this->height - 40, $this->width - 80, 40, $this->axesCol);

		// calculate the max of each range
		$tmpArray = Array();
		$maxValues = Array();
		$numSequences = sizeof($this->dataValues[0]);

		for($i = 0; $i < $numSequences; $i++)
		{
			$tmpArray[$i] = Array();
			for($j = 0; $j < sizeof($this->dataValues); $j++)
			{
				$tmpArray[$i][] = $this->dataValues[$j][$i];
			}
		}

		for($i = 0; $i < $numSequences; $i++)
		{
			$maxValues[$i] = max($tmpArray[$i]);
		}

		// put the y axis values
		for($i = 0; $i <= 4; $i++)
		{
			$tmpVal = 4 - $i;
			$y1 = 40 + (($i * ($this->height - 80)) / 4);
			
			for($j = 0; $j < $numSequences; $j++)
			{
				$str = sprintf("%.2f", ($maxValues[$j] * (4 - $i) / 4));
				$strHeight = ImageFontHeight(2);
				ImageString($this->image, 2, 5, $y1 + (($j - $numSequences / 2) * $strHeight), $str, $this->barCol[$j % 9]);
			}
		}
		
		// put the title
		$titleWidth = ImageFontWidth(3) * strlen($this->title);
		ImageString($this->image, 3, ($this->width - $titleWidth) / 2, 10, $this->title, $this->titleCol);

		// put the series legend
		$legendWidth = ImageFontWidth(3) * strlen("Legend");
		ImageString($this->image, 3, $this->width - $legendWidth - 5, 40, "Legend", $this->titleCol);
		for($i = 0; $i < sizeof($this->dataSeriesLabels); $i++)
		{
			$legendWidth = ImageFontWidth(3) * strlen($this->dataSeriesLabels[$i]);
			ImageString($this->image, 3, $this->width - $legendWidth - 5, 60 + $i * ImageFontWidth(2) * 2, $this->dataSeriesLabels[$i], $this->barCol[$i % 9]);
		}

		// divide the area for the values
		$xUnit = ($this->width - 120) / sizeof($this->dataValues);

		// finally draw the graphs
		$x2 = Array();
		$y2 = Array();		
		for($i = 0; $i < sizeof($this->dataValues); $i++)
		{
			$labelWidth = ImageFontWidth(1) * strlen($this->dataXLabels[$i]);
			$labelHeight = ImageFontHeight(1);

			ImageString($this->image, 1, 
				40 + $xUnit * ($i + 0.5) - $labelWidth / 2, 
				$this->height - 35 + ($i % 2) * $labelHeight, 
				$this->dataXLabels[$i], $this->titleCol);

			for($j = 0; $j < sizeof($this->dataValues[$i]); $j++)
			{
				$x1 = 40 + ($xUnit * ($i + 0.5));

				// $maxValues[$j] corresponds to $this->height - 80
				$tmpVal = $maxValues[$j] - $this->dataValues[$i][$j];
				// $tmpVal corresponds to ($tmpVal * ($this->height - 80)) / $maxValues[$j];
				$y1 = 40 + (($tmpVal * ($this->height - 80)) / $maxValues[$j]);
				ImageFilledRectangle($this->image, $x1 - 2, $y1 - 2, $x1 + 2, $y1 + 2, $this->barCol[$j % 9]);
				if($i != 0)
				{
					ImageLine($this->image, $x1, $y1, $x2[$j], $y2[$j], $this->barCol[$j % 9]);
				}
				$x2[$j] = $x1;
				$y2[$j] = $y1;
			}
		}


		if($type == "jpg")
		{
			Header("Content-type: image/jpeg");
			ImageJpeg($this->image);
		}
		if($type == "png")
		{
			Header("Content-type: image/png");
			ImagePng($this->image);
		}
		if($type == "gif")
		{
			Header("Content-type: image/gif");
			ImageGif($this->image);
		}
		
		ImageDestroy($this->image);

	}
}


?>
