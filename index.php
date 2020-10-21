<?php
require "config.php";
require "functions.php";

// kill($urls, $paths);

$url = "https://www..net";
$urlSocialImg = $url. "/assets/images/----card.jpg";
$pageTitle = "Page title";
$desc = "Lorem ipsum dolor sit amet.";
?>

<!DOCTYPE html><html><head>

  <title><?= $pageTitle ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="<?= $desc ?>">
  <meta name="viewport" content="width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86">

  <!-- TWITTER -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@matilde_muozz" />
  <meta name="twitter:title" content="<?= $pageTitle ?>" />
  <meta name="twitter:description" content="<?= $desc ?>" />
  <meta name="twitter:image" content="<?= $urlSocialImg ?>" />

  <!-- OG -->
  <meta property="og:url" content="<?= $url ?>" />
  <meta property="og:image" content="<?= $urlSocialImg ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= $pageTitle ?>" />
  <meta property="og:description" content="<?= $desc ?>" />

  <!-- Vendor -->
  <script src="<?= $urls['assets'] ?>/lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>

  <!-- Style -->
  <link rel="stylesheet" type="text/css" href="<?= $urls["assets"] ?>/css/bootstrap-custom.css">
  <link rel="stylesheet" type="text/css" href="<?= $urls["assets"] ?>/css/index.css">

</head>
<body>

  <?php

  // --- settings

  $defaultTitle = "Mayors Dialogue on Growth and Solidarity";
  $contentFolder = "0-test";
  $stats = ["population", "gdp", "migrantspercent", "additional1", "additional2"];

  // --- vars

  $contentFolderUrl = $urls["content"] ."/". $contentFolder;
  $jsonFileUrl = $contentFolderUrl ."/data.json";
  $jsonFilePath = $paths["content"] ."/". $contentFolder ."/data.json";

  // --- load json

  $jsonStr = file_get_contents($jsonFilePath);
  $rawDataset = json_decode($jsonStr, true);
  shuffle($rawDataset);
  $dataById = formatById($rawDataset, $stats);

  // --- preview spacing

  $newlines = [
    "3"   => "md",
    "4"   => "lg",
    "5"   => "md xl",
    "7"   => "lg",
    "8"   => "md",
    "9"   => "xl",
    "10"  => "md",
    "11"  => "lg",
    "13"  => "md",
    "14"  => "lg xl",
    "15"  => "md",
    "18"  => "md lg xl",
    "20"  => "md",
    "21"  => "lg",
    "23"  => "md xl",
    "25"  => "md lg",
    "27"  => "xl",
  ];



  /*

  load svg file contents
  test ids & css

  */


  ?>

  <!-------------------------------->  
  <!-- MARKUP -->
  <!-------------------------------->  

  <main class="bg-color-b">

    <?php
    $cityId = isset($_GET["c"]) ? $_GET["c"] : null;
    if ($cityId) {
      $cityId = isset($_GET["c"]) ? $_GET["c"] : null;
      $cityData = $dataById[$cityId];
      $pathToSvg = $paths["content"] ."/". $contentFolder ."/data-lines/". $cityId .".svg";
      $svg = file_get_contents($pathToSvg);
      $mapUrl = $contentFolderUrl ."/maps-landing-parts/". $cityId ."-map.png";
      ?>

      <section class="city-detail my-5">
        <div class="cols-container">
          <div class="left">
             
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6">
                  <p class="font-sans-m font-bold color-a">Mayor</p>
                  <hr class="border-top-color-a my-1" />
                  <p class="font-sans-l font-bold color-a"><?= $cityData["mayor"] ?></p>
                </div>
                <div class="col-sm-6">
                  <p class="font-sans-m font-bold color-a">Next election</p>
                  <hr class="border-top-color-a my-1" />
                  <p class="font-sans-l font-bold color-a"><?= $cityData["nextelection"] ?></p>
                </div>
                <div class="col-12">
                  <div class="city-detail-map"><img class="img-fluid" src="<?= $mapUrl ?>" /></div>
                </div>
              </div>
            </div>
           
          </div>
          <div class="right">
             
            <div class="container-fluid">
              <div class="row">

                <?php foreach ($cityData["stats"] as $stat => $statData): ?>
                    
                  <?php if ($statData["stat"]): ?>
                    <div class="col-sm-6 col-xl-4">
                      <?php statMarkup($stat, $statData, $svg); ?>
                    </div>
                  <?php endif ?>
                <?php endforeach ?>

              </div>
            </div>
           
          </div>
        </div>
      </section>

    <?php } ?>

    <div class="cols-container mt-5">
      <div class="col-1-on-1">
        <div class="d-flex justify-content-between align-items-baseline">
          <p class="font-serif-l">All cities</p>
          <p><a class="font-sans-m font-bold color-black" onclick="shuffleCities();">SHUFFLE</a></p>
        </div>
        <hr class="my-1" />
      </div>
    </div>

    <section class="all-cities">
      <?php $i = 0; ?>
      <?php foreach ($dataById as $cityId => $d): ?>

        <?php if (array_key_exists("$i", $newlines)): ?>
          <div class="wrap-line <?= $newlines["$i"] ?>"></div>
        <?php endif ?>

        <div class="city-prev">
          <div class="thumb-wrapper" data-url="<?= $urls["site"] ."?c=". $cityId ?>">
            <img class="lines" src="<?= "$contentFolderUrl/maps-landing-parts/$cityId" ?>-lines-population.svg" />
            <img class="map" src="<?= "$contentFolderUrl/maps-landing-parts/$cityId" ?>-map.png" />
          </div>
          <div class="texts text-center">
            <p class="city font-serif-m"><?= $d["city"] ?></p>
            <p class="stat-text-home font-sans-m font-bold color-a"><?= $d["stats"]["population"]["text"] ?></p>
            <p class="source font-sans-s color-a"><?= $d["stats"]["population"]["source"] ?></p>
          </div>
        </div>
        <?php $i++; ?>
      <?php endforeach ?>
    </section>

  </main>

  <nav id="header" class="bg-color-white">
    <h1 class="title"><a class="color-black" href="<?= $urls["site"] ?>"><?= $defaultTitle ?></a></h1>
    <div>
      <a class="font-sans-m font-bold color-black" href="about">ABOUT</a>
    </div>
  </nav>

  <!-------------------------------->  
  <!-- JAVASCRIPT -->
  <!-------------------------------->  

  <script>
    var formattedDataset = <?= json_encode($dataById) ?>;
    var baseUrl = '<?= $urls["site"] ?>';
    var a;
  </script>
  <script type="text/javascript" src="<?= $urls["assets"] ?>/js/index.js"></script>

</body>
</html>

