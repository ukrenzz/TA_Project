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

    // Color Descriptor
    // Imagick untuk dapat Mean dan STDV 
    $imagick = new Imagick('D:\New Neko Code\TA_Project\public\assets\image\Godfrey Gao.jpg');

    // Mean and Std method from Imagick
    $IR = $imagick->getImageChannelMean(1); // Red
    $IG = $imagick->getImageChannelMean(4); // Green
    $IB = $imagick->getImageChannelMean(2); // Blue 
    // Mean, perlu direturn untuk citra dari DB
    $mean_IR =  $IR["mean"];
    $mean_IG =  $IG["mean"];
    $mean_IB =  $IB["mean"];

    // LT dan HT 
    $lt_IR =  $IR["mean"] - $IR["standardDeviation"];
    $ht_IR =  $IR["mean"] + $IR["standardDeviation"];

    $lt_IG =  $IG["mean"] - $IG["standardDeviation"];
    $ht_IG =  $IG["mean"] + $IG["standardDeviation"];

    $lt_IB =  $IB["mean"] - $IB["standardDeviation"];
    $ht_IB =  $IB["mean"] + $IB["standardDeviation"];

    class colorInfo
    {
      public $mean_IR;
      public $mean_IG;
      public $mean_IB;

      public $lt_IR;
      public $ht_IR;
      public $lt_IG;
      public $ht_IG;
      public $lt_IB;
      public $ht_IB;
    }

    $colorObj = new colorInfo();

    $colorObj->mean_IR = $mean_IR;
    $colorObj->mean_IG = $mean_IG;
    $colorObj->mean_IB = $mean_IB;

    $colorObj->lt_IR = $lt_IR;
    $colorObj->ht_IR = $ht_IR;
    $colorObj->lt_IG = $lt_IG;
    $colorObj->ht_IG = $ht_IG;
    $colorObj->lt_IB = $lt_IB;
    $colorObj->ht_IB = $ht_IB;
    dd($colorObj);

    // dd($IR, $IG, $IB, $lt_IR, $ht_IR, $lt_IG, $ht_IG, $lt_IB, $ht_IB);

    // https://www.php.net/manual/en/imagick.getimagechannelmean.php
    // https://www.php.net/manual/en/imagick.constants.php#imagick.constants.channel
    // https://www.geeksforgeeks.org/php-imagick-getimagechannelmean-function/

    ?>
  </div>
</body>

</html>

<script>

</script>