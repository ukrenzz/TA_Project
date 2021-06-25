<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CtebirController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('ctebir');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$target_dir = "Controllers/";
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
		// Check if image file is a actual image or fake image
		if (isset($_POST["submit"])) {
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			if ($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}
		}


		// Check if file already exists
		if (file_exists($target_file)) {
			echo "Sorry, file already exists.";
			$uploadOk = 0;
		}

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		}

		// Allow certain file formats
		if (
			$imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif"
		) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$uploadOk = 0;
		}

		// // Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
		} else {
			// if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			// echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			// } else {
			// echo "Sorry, there was an error uploading your file.";
			// }
			echo 'Ok';
		}



		// Load an image from jpeg URL
		$im = imagecreatefromjpeg(
			'https://media.geeksforgeeks.org/wp-content/uploads/20200123100652/geeksforgeeks12.jpg'
		);

		// View the loaded image in browser using imagejpeg() function
		header('Content-type: image/jpg');
		imagejpeg($im);
		dd($im);
		imagedestroy($im);

		// $this->averageRGB($target_file);
		return redirect()->to('/ctebir');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}

	// -------------------------
	// CTEBIR Algo 

	// Mean (Ic), Get Mean Value of an Image
	function averageRGB($img)
	{
		// Mean 
		$w = imagesx($img);
		$h = imagesy($img);
		$r = $g = $b = 0;
		for ($y = 0; $y < $h; $y++) {
			for ($x = 0; $x < $w; $x++) {
				$rgb = imagecolorat($img, $x, $y);
				$r += $rgb >> 16;
				$g += $rgb >> 8 & 255;
				$b += $rgb & 255;
			}
		};
		$pxls = $w * $h;
		$mean_r = dechex(round($r / $pxls));
		$mean_g = dechex(round($g / $pxls));
		$mean_b = dechex(round($b / $pxls));
		dd($pxls);

		// // Stdv 
		// for($y = 0; $y < $h; $y++) {
		//   for($x = 0; $x < $w; $x++) {

		//   }
	}

	function colorDescriptor($image)
	{
		// Separate RGB 

		// Open an image
		$image = imagecreatefromjpeg('image.jpg'); // imagecreatefromjpeg/png/

		// Imagick::getImageChannelMean ( int $channel );
		// Mean 
		$meanRGB = $this->averageRGB($image);
		$mean_IR = $meanRGB[0];
		$mean_IG = $meanRGB[1];
		$mean_IB = $meanRGB[2];


		// HT 
		// LT 
	}

	// // Function CTEBIR 
	function ctebir($query, $dbImage)
	{
		// Color Descriptor Func 

	}
}
