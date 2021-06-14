<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CTEBIR Playground</title>
</head>

<body>
  <div>
    <?php
    $img = imagecreatefromjpeg('D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg');

    function RGBtoHSV($r, $g, $b)
    {
      $r = $r / 255.; // convert to range 0..1
      $g = $g / 255.;
      $b = $b / 255.;
      $cols = array("r" => $r, "g" => $g, "b" => $b);
      asort($cols, SORT_NUMERIC);
      $min = key(array_slice($cols, 1)); // "r", "g" or "b"
      $max = key(array_slice($cols, -1)); // "r", "g" or "b"
      
      // hue
      if ($cols[$min] == $cols[$max]) {
        $h = 0;
      } else {
        if ($max == "r") {
          $h = 60. * (0 + (($cols["g"] - $cols["b"]) / ($cols[$max] - $cols[$min])));
        } elseif ($max == "g") {
          $h = 60. * (2 + (($cols["b"] - $cols["r"]) / ($cols[$max] - $cols[$min])));
        } elseif ($max == "b") {
          $h = 60. * (4 + (($cols["r"] - $cols["g"]) / ($cols[$max] - $cols[$min])));
        }
        if ($h < 0) {
          $h += 360;
        }
      }
      
      // saturation
      if ($cols[$max] == 0) {
        $s = 0;
      } else {
        $s = (($cols[$max] - $cols[$min]) / $cols[$max]);
        $s = $s * 255;
      }
      
      // lightness
      $v = $cols[$max];
      $v = $v * 255;

      return(array($h, $s, $v));
    }



    $filename = "D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg";
    $dimensions = getimagesize($filename);
    $w = $dimensions[0]; // width
    $h = $dimensions[1]; // height

    $im = imagecreatefromjpeg($filename);

    for ($hi = 0; $hi < $h; $hi++) {
      for ($wi = 0; $wi < $w; $wi++) {
        $rgb = imagecolorat($im, $wi, $hi);
        
        
        $r = ($rgb >> 16) & 0xFF;
        $g = ($rgb >> 8) & 0xFF;
        $b = $rgb & 0xFF;
        $hsv = RGBtoHSV($r, $g, $b);
        
        if ($hi < $h - 1) {
          // compare pixel below with current pixel
          $brgb = imagecolorat($im, $wi, $hi + 1);
          $br = ($brgb >> 16) & 0xFF;
          $bg = ($brgb >> 8) & 0xFF;
          $bb = $brgb & 0xFF;
          $bhsv = RGBtoHSV($br, $bg, $bb);
          
          // if difference in hue is bigger than 20, make this pixel white (edge), otherwise black
          if ($bhsv[2] - $hsv[2] > 20) {
            imagesetpixel($im, $wi, $hi, imagecolorallocate($im, 255, 255, 255));
          } else {
            imagesetpixel($im, $wi, $hi, imagecolorallocate($im, 0, 0, 0));
          }
        }
      }
    }
    
    header('Content-Type: image/jpeg');
    // TODO : Bagaimana cara memanfaatkan hasil ini ? 
    imagejpeg($im);
    imagedestroy($im);

    // // Color Descriptor
    // // Imagick untuk dapat Mean dan STDV 
    // $imagick = new Imagick('D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg');

    // // Mean and Std method from Imagick
    // $IR = $imagick->getImageChannelMean(1); // Red
    // $IG = $imagick->getImageChannelMean(4); // Green
    // $IB = $imagick->getImageChannelMean(2); // Blue 
    // // Mean, perlu direturn untuk citra dari DB
    // $mean_IR =  $IR["mean"];
    // $mean_IG =  $IG["mean"];
    // $mean_IB =  $IB["mean"];

    // // LT dan HT 
    // $lt_IR =  $IR["mean"] - $IR["standardDeviation"];
    // $ht_IR =  $IR["mean"] + $IR["standardDeviation"];

    // $lt_IG =  $IG["mean"] - $IG["standardDeviation"];
    // $ht_IG =  $IG["mean"] + $IG["standardDeviation"];

    // $lt_IB =  $IB["mean"] - $IB["standardDeviation"];
    // $ht_IB =  $IB["mean"] + $IB["standardDeviation"];

    // class colorInfo
    // {
    //   public $mean_IR;
    //   public $mean_IG;
    //   public $mean_IB;

    //   public $lt_IR;
    //   public $ht_IR;
    //   public $lt_IG;
    //   public $ht_IG;
    //   public $lt_IB;
    //   public $ht_IB;
    // }

    // $colorObj = new colorInfo();

    // $colorObj->mean_IR = $mean_IR;
    // $colorObj->mean_IG = $mean_IG;
    // $colorObj->mean_IB = $mean_IB;

    // $colorObj->lt_IR = $lt_IR;
    // $colorObj->ht_IR = $ht_IR;
    // $colorObj->lt_IG = $lt_IG;
    // $colorObj->ht_IG = $ht_IG;
    // $colorObj->lt_IB = $lt_IB;
    // $colorObj->ht_IB = $ht_IB;
    // dd($colorObj);

    // // dd($IR, $IG, $IB, $lt_IR, $ht_IR, $lt_IG, $ht_IG, $lt_IB, $ht_IB);

    // // https://www.php.net/manual/en/imagick.getimagechannelmean.php
    // // https://www.php.net/manual/en/imagick.constants.php#imagick.constants.channel
    // // https://www.geeksforgeeks.org/php-imagick-getimagechannelmean-function/

    ?>
  </div>
</body>

</html>

<script>

</script>