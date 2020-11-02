<?php
require "config.php";
require "functions.php";

// kill($urls, $paths);

$url = $urls["site"];
$urlSocialImg = $urls["assets"] ."/images/mayors-dialogue.jpg";
$pageTitle = "Mayors Dialogue on Growth and Solidarity";
$desc = "African and European cities taking action on human mobility";
?>

<!DOCTYPE html><html><head>

  <title><?= $pageTitle ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="<?= $desc ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3.0">

  <!-- TWITTER -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@ODIdev" />
  <meta name="twitter:title" content="<?= $pageTitle ?>" />
  <meta name="twitter:description" content="<?= $desc ?>" />
  <meta name="twitter:image" content="<?= $urlSocialImg ?>" />

  <!-- OG -->
  <meta property="og:url" content="<?= $url ?>" />
  <meta property="og:image" content="<?= $urlSocialImg ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= $pageTitle ?>" />
  <meta property="og:description" content="<?= $desc ?>" />

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="57x57" href="<?= $urls["assets"] ?>/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?= $urls["assets"] ?>/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?= $urls["assets"] ?>/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= $urls["assets"] ?>/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?= $urls["assets"] ?>/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?= $urls["assets"] ?>/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?= $urls["assets"] ?>/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?= $urls["assets"] ?>/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $urls["assets"] ?>/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?= $urls["assets"] ?>/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?= $urls["assets"] ?>/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?= $urls["assets"] ?>/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?= $urls["assets"] ?>/favicon/favicon-16x16.png">
  <link rel="manifest" href="<?= $urls["assets"] ?>/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?= $urls["assets"] ?>/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">  

  <!-- Vendor -->
  <script src="<?= $urls['assets'] ?>/lib/jquery-3.5.1/jquery-3.5.1.min.js"></script>

  <!-- Style -->
  <link rel="stylesheet" type="text/css" href="<?= $urls["assets"] ?>/css/bootstrap-custom.css">
  <link rel="stylesheet" type="text/css" href="<?= $urls["assets"] ?>/css/index.css">

  <!-- Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-TYR970NTDF"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-TYR970NTDF');
  </script>

</head>
<body>

  <?php

  // --- settings

  $contentFolder = "1-beta";
  $defaultTitle = "The Mayors Dialogue on&nbsp;Growth and&nbsp;Solidarity";
  $stats = ["population", "gdp", "migrantspercent", "additional1", "additional2"];
  $palettes = [
    // "palette-1", 
    // "palette-2", 
    "palette-3", 
    "palette-4",
    // "palette-5",
    // "palette-6",
  ];
  // --- vars

  $contentFolderUrl = $urls["content"] ."/". $contentFolder;
  $jsonFileUrl = $contentFolderUrl ."/data.json";
  $jsonFilePath = $paths["content"] ."/". $contentFolder ."/data.json";

  // --- load json

  $jsonStr = file_get_contents($jsonFilePath);
  $rawDataset = json_decode($jsonStr, true);
  shuffle($rawDataset);
  $dataById = formatById($rawDataset, $stats);

  // --- city detail ?
  
  $cityDetailId = isset($_GET["c"]) ? $_GET["c"] : null;
  if ($cityDetailId) {
    $cityData = $dataById[$cityDetailId];
    $pathToSvg = $paths["content"] ."/". $contentFolder ."/data-lines/". $cityDetailId .".svg";
    $svg = file_get_contents($pathToSvg);
    $mapUrl = $contentFolderUrl ."/maps/". $cityDetailId ."-map.png";
  }

  // --- palette choice
  // $palette = $palettes[floor(rand(0, count($palettes)-1))];
  $palette = ($cityDetailId !== null) ? "palette-4" : "palette-3";

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

  // --- header title

  // $headerTitle = ($cityId !== null) ? $defaultTitle ." &rsaquo; ". $cityData["city"] : $defaultTitle;
  $headerTitle = $defaultTitle;

  ?>

  <!-------------------------------->  
  <!-- MARKUP -->
  <!-------------------------------->  

  <main class="<?= $palette ?>-bg">
    
    <!-- City Detail -->

    <?php if ($cityDetailId): ?>

      <section class="city-detail adjust-margin">
        <!--  
        <div class="cols-container my-5">
          <div class="col-1-on-1 no-margin">
        -->
        <div class="container-fluid mb-5">
          <div class="row">
            <div class="col-12">
              <h1 class="font-serif-xl <?= $palette ?>-color-city-name"><?= $cityData["city"] ?></h1>
              <p class="font-sans-m font-bold upper <?= $palette ?>-color-texts-upper"><?= $cityData["country"] ." / ". $cityData["coordinates"] ?></p>
            </div>
          </div>
        </div>

        <div id="compensate-margin"></div>

        <div class="city-contents cols-container">
          <div class="left no-margin">
             
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6 mb-5">
                  <p class="description font-sans-m font-bold <?= $palette ?>-color-texts-upper">Mayor</p>
                  <hr class="<?= $palette ?>-color-hr" />
                  <p class="font-display-l font-bold <?= $palette ?>-color-texts-large"><?= $cityData["mayor"] ?></p>
                  <?php if ($cityData["mayor-note"]): ?>
                    <p class="font-sans-s <?= $palette ?>-color-texts mt-2"><?= $cityData["mayor-note"] ?></p>
                  <?php endif ?>
                </div>
                <div class="col-sm-6 mb-5">
                  <p class="description font-sans-m font-bold <?= $palette ?>-color-texts-upper">Next election</p>
                  <hr class="<?= $palette ?>-color-hr" />
                  <p class="font-display-l font-bold <?= $palette ?>-color-texts-large"><?= $cityData["nextelection"] ?></p>
                  <?php if ($cityData["nextelection-note"]): ?>
                    <p class="font-sans-s <?= $palette ?>-color-texts mt-2"><?= $cityData["nextelection-note"] ?></p>
                  <?php endif ?>
                </div>
                <div class="col-12 mb-5">
                  <div class="city-detail-map pt-4 pt-md-2">
                    <img class="img-fluid" src="<?= $mapUrl ?>" />
                    <p class="scale font-sans-s <?= $palette ?>-color-map"><?= $cityData["map-scale"] ?></p>
                  </div>
                </div>
              </div>
            </div>
           
          </div>
          <div class="right no-margin">
             
            <div class="container-fluid">
              <div class="row">

                <?php foreach ($cityData["stats"] as $stat => $statData): ?>
                    
                  <?php if ($statData["stat"]): ?>
                    <!-- <div class="col-sm-6 col-xl-4"> -->
                    <div class="col-sm-6 col-xl-4">
                      <?php statMarkup($stat, $statData, $svg, $palette); ?>
                    </div>
                  <?php endif ?>
                <?php endforeach ?>

              </div>
            </div>
           
          </div>
        </div>
      </section>

      <div class="cols-container mt-5">
        <div class="col-1-on-1">
          <hr class="my-1" />
          <div class="py-4"></div>
        </div>
      </div>

    <?php endif ?>

    <?php /*
    
    <!-- All cities -->

    <div class="cols-container mt-5">
      <div class="col-1-on-1">
        <div class="d-flex justify-content-between align-items-baseline">
          <p class="font-serif-l">All cities</p>
          <div class="switch">
            <a class="mx-2 font-sans-m font-bold color-black active" 
               data-data-type="population"
               onclick="a.switchDataType('population');">POPULATION</a>
            <a class="mx-2 font-sans-m font-bold color-black" 
               data-data-type="migrantspercent"
               onclick="a.switchDataType('migrantspercent');">% MIGRANTS</a>
            <a class="mx-2 font-sans-m font-bold color-black" 
               data-data-type="gdp"
               onclick="a.switchDataType('gdp');">GDP PER CAPITA</a>
          </div>
          <p><a class="font-sans-m font-bold color-black" onclick="a.shuffleCities();">SHUFFLE</a></p>
        </div>
        <hr class="my-1" />
      </div>
    </div>
    */ ?>

    <!-- <div class="adjust-xs-margin"></div> -->

    <section class="all-cities">

      <?php $i = 0; ?>
      <?php foreach ($dataById as $cityId => $d): ?>

        <?php if (array_key_exists("$i", $newlines)): ?>
          <div class="wrap-line <?= $newlines["$i"] ?>"></div>
        <?php endif ?>

        <div class="city-prev off" data-city-id="<?= $cityId ?>">
          <div class="thumb-wrapper" data-url="<?= $urls["site"] ."?c=". $cityId ?>">
            <img class="lines" src="<?= "$contentFolderUrl/maps-landing-parts/$cityId" ?>-lines-population.svg" />
            <img class="map" src="<?= "$contentFolderUrl/maps-landing-parts/$cityId" ?>-map.png" />
            <div class="legend-landing-text">
              <span class="font-sans-m <?= $palette ?>-color-texts font-bold">Lines: population
              <!-- <br class="d-none d-sm-block" /></span> -->
              <br /></span>
              <span class="font-sans-m <?= $palette ?>-color-texts">1 line = 100,000 people</span>
            </div>
            <div class="legend-landing-line"></div>
          </div>
          <div class="texts text-center">
            <p class="city font-serif-l font-bold"><?= $d["city"] ?></p>
            <p class="stat-text-home font-sans-m font-weight-500 <?= $palette ?>-color-texts"><?= $d["stats"]["population"]["text"] ?> people</p>
            <!--  
            <p class="source font-sans-s <?= $palette ?>-color-texts"><?= $d["stats"]["population"]["source"] ?></p>
            -->
          </div>
        </div>
        <?php $i++; ?>
      <?php endforeach ?>
    </section>

    <div id="comment-landing" class="text-center">
      <div class="top">
        <div class="mb-4">
          <h1 class="font-serif-l landing-title"><?= $headerTitle ?></h1>
          <h2 class="font-serif-l landing-title font-weight-400">African and&nbsp;European cities taking action on&nbsp;human&nbsp;mobility</h2>
        </div>
      </div>
      <div class="bottom">
        <div>
          <p class="mb-4"><a class="btn font-weight-500" onclick="a.landing(false);">Start&nbsp;&nbsp;&rarr;</a></p>
          <!--  
          <p class="text font-serif-m">The Mayors Dialogue on Growth and Solidarity: African and European cities taking action on human mobility</p>
          -->
        </div>
      </div>
    </div>

  </main>

  <section class="footer-2 adjust-margin">
    <div class="container-fluid">
      <div class="row py-5">
        <div class="col-12 text-center my-2">
          <img class="partners" src="<?= $urls["assets"] ?>/images/partners.png" />
        </div>
      </div>
      <div class="row pb-4">
        <div class="col-12">
          <a class="font-sans-m color-black-50 font-weight-500 mr-3" href="https://www.odi.org" target="_blank">Visit odi.org</a>
          <a class="font-sans-m color-black-50 font-weight-500 mr-3" onclick="a.toggleLegend();">About</a>
          <a class="font-sans-m color-black-50 font-weight-500 mr-3" href="https://www.odi.org/about/privacy-policy" target="_blank">Privacy</a>
        </div>
      </div>
    </div>
  </section>

  <div id="legend-overlay">
    <div class="bg <?= $palette ?>-bg"></div>
    <div class="content-wrapper-scroll">
      <div class="container-fluid <?= $palette ?>-bg-lighter">
        <div class="row">
          <div class="col-lg-7 col-xl-8 order-lg-2 align-items-start justify-content-center">
            <div class="text-center">
              <img class="d-none d-sm-inline-block" src="<?= $urls["assets"] ?>/images/legend.svg" />
              <img class="d-sm-none" src="<?= $urls["assets"] ?>/images/legend_mobile.svg" />
            </div>
          </div>
          <div class="col-lg-5 col-xl-4 order-lg-1 align-self-stretch align-items-center">
            <div>
              <h2 class="font-serif-l mb-2">How to explore</h2>
              <p class="font-serif-m">Each city is represented by the red lines, with the silhouette following the unique shape of the city map.<br />
              Each group of lines corresponds to a different data point: population, GDP per capita and percentage of migrants. The number of red lines in each group represents the data.</p>
              <div class="spacer py-3"></div>
              <h2 class="font-serif-l mb-2">About</h2>
              <p class="font-serif-m">In <a class="u" href="https://www.odi.org/" target="_blank">ODI</a>'s latest collaboration with designers <a class="u" href="https://twitter.com/fedfragapane" target="_blank">Federica Fragapane</a> and <a class="u" href="https://www.alexpiacentini.com/" target="_blank">Alex Piacentini</a>, explore the cities participating in the Mayors Dialogue on Growth and Solidarity in this data visualisation.</p>               
              <div class="spacer py-3"></div>
              <p class="mb-5"><a class="btn" href="https://www.odi.org/projects/16889-mayors-dialogue-on-growth-and-solidarity-reimagining-human-mobility-in-africa-and-europe#:~:text=Programmes-,The%20Mayors%20Dialogue%20on%20Growth%20and%20Solidarity%3A%20reimagining%20human%20mobility,in%20African%20and%20European%20cities" target="_blank">Find out more&nbsp;&nbsp;&rarr;</a></p>
            </div>
          </div>
        </div>
        <a class="close-x" onclick="a.toggleLegend();">&times;</a>

      </div>
    </div>
  </div>

  <nav id="header" class="<?= ($cityDetailId ? "" : "hide home ") ?><?= $palette ?>-bg">
    
    <?php if ($cityDetailId === null): ?>
      
      <!-- xs, sm -->
      <a class="d-md-none color-black" href="<?= $urls["site"] ?>">
        <img class="title-xs" src="<?= $urls["assets"] ?>/images/logo-xs.svg" />
      </a>

      <!-- md up -->
      <h1 class="d-none d-md-flex title font-serif-l"><a class="color-black" href="<?= $urls["site"] ?>"><?= $headerTitle ?></a></h1>


    <?php else: ?>
      <a class="font-sans-m font-weight-500 color-black py-3" href="<?= $urls["site"] ?>">&larr;&nbsp;&nbsp;BACK</a>
    <?php endif ?>
    
    <div class="text-right">
      <a class="ml-3 font-sans-m font-weight-500 color-black py-3" onclick="a.toggleLegend();">How to explore</a>
    </div>
  </nav>

  <!-------------------------------->  
  <!-- JAVASCRIPT -->
  <!-------------------------------->  

  <script>
    var a;
    var formattedDataset = <?= json_encode($dataById) ?>;
    var baseUrl = '<?= $urls["site"] ?>';
    var contentFolderUrl = '<?= $contentFolderUrl ?>';
    var cityData = <?= ($cityDetailId !== null && isset($cityData)) ? json_encode($cityData) : "null" ?>;
    var palette = '<?= $palette ?>';
    console.log("palette", palette);
  </script>
  <script type="text/javascript" src="<?= $urls["assets"] ?>/js/index.js"></script>

</body>
</html>

