<?php
require "config.php";
require "functions.php";

// kill($urls, $paths);

$url = "https://www..net";
$urlSocialImg = $url. "/assets/images/----card.jpg";
$pageTitle = "Mayors Dialogue on Growth and Solidarity";
$desc = "City-led initiative to deliver innovative and practical solutions for human mobility in African and European cities.";
?>

<!DOCTYPE html><html><head>

  <title><?= $pageTitle ?></title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="description" content="<?= $desc ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=3.0">

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

  $contentFolder = "1-beta";
  $defaultTitle = "Mayors Dialogue on&nbsp;Growth and&nbsp;Solidarity";
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
                <div class="order-md-3 col-12 mb-5">
                  <div class="city-detail-map pt-4 pt-md-2">
                    <img class="img-fluid" src="<?= $mapUrl ?>" />
                    <p class="scale font-sans-s <?= $palette ?>-color-map"><?= $cityData["map-scale"] ?></p>
                  </div>
                </div>
                <div class="order-md-1 col-sm-6 col-md-12 col-lg-6 mb-5">
                  <p class="description font-sans-m font-bold <?= $palette ?>-color-texts-upper">Mayor</p>
                  <hr class="<?= $palette ?>-color-hr" />
                  <p class="font-display-l font-bold <?= $palette ?>-color-texts-large"><?= $cityData["mayor"] ?></p>
                  <?php if ($cityData["mayor-note"]): ?>
                    <p class="font-sans-s <?= $palette ?>-color-texts mt-2"><?= $cityData["mayor-note"] ?></p>
                  <?php endif ?>
                </div>
                <div class="order-md-2 col-sm-6 col-md-12 col-lg-6 mb-5">
                  <p class="description font-sans-m font-bold <?= $palette ?>-color-texts-upper">Next election</p>
                  <hr class="<?= $palette ?>-color-hr" />
                  <p class="font-display-l font-bold <?= $palette ?>-color-texts-large"><?= $cityData["nextelection"] ?></p>
                  <?php if ($cityData["nextelection-note"]): ?>
                    <p class="font-sans-s <?= $palette ?>-color-texts mt-2"><?= $cityData["nextelection-note"] ?></p>
                  <?php endif ?>
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
                    <div class="col-sm-6 col-md-12 col-lg-6 col-xl-4">
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
            <p class="stat-text-home font-sans-m font-bold <?= $palette ?>-color-texts"><?= $d["stats"]["population"]["text"] ?> people</p>
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
          <h1 class="font-serif-l landing-title mb-1"><?= $headerTitle ?></h1>
          <p class="text font-serif-m">African and European cities taking action on human mobility</p>
        </div>
      </div>
      <div class="bottom">
        <div>
          <p class="mb-4"><a class="btn" onclick="a.landing(false);">Explore &rarr;</a></p>
          <!--  
          <p class="text font-serif-m">The Mayors Dialogue on Growth and Solidarity: African and European cities taking action on human mobility</p>
          -->
        </div>
      </div>
    </div>

  </main>

  <!--  
  <section id="about" class="footer-1 adjust-margin <?= $palette ?>-color-footer">
    <div class="container-fluid">
      <div class="row pb-4">
        <div class="col-md-8 col-lg-6 pt-4">
          <h1 class="title font-serif-l pt-5"><a class="color-black" href="<?= $urls["site"] ?>">About</a></h1>
          <p class="font-serif-m mt-5 mb-4">
            The Mayors Dialogue is a city-led initiative to deliver innovative and practical solutions for human mobility in African and European cities. It aims to improve the lives of all urban residents, including migrants, and help redress the power imbalances that persist between the two continents.
          </p>
        </div>
      </div>
    </div>
  </section>
  -->
  <section class="footer-2 adjust-margin">
    <div class="container-fluid">
      <div class="row py-5">
        <div class="col-12 text-center my-2">
          <img class="partners" src="<?= $urls["assets"] ?>/images/partners.png" />
        </div>
      </div>
    </div>
  </section>

  <div id="legend-overlay">
    <div class="bg <?= $palette ?>-bg"></div>
    <div class="content-wrapper-scroll">
      <div class="container-fluid mb-5">
        <div class="row">
          <div class="col-lg-6 order-lg-2 align-items-start">
            <div class="text-center">
              <img class="d-none d-sm-inline-block" src="<?= $urls["assets"] ?>/images/legend.svg" />
              <img class="d-sm-none" src="<?= $urls["assets"] ?>/images/legend_mobile.svg" />
            </div>
          </div>
          <div class="col-lg-6 order-lg-1 align-self-stretch align-items-center">
            <div>
              <h2 class="font-serif-l mb-2">How to explore</h2>
              <p class="font-serif-m">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris sed turpis sed ipsum vehicula bibendum imperdiet in orci. In non vestibulum dui, at malesuada quam. Phasellus fermentum tempor purus ac tincidunt.</p>
              <div class="spacer py-3"></div>
              <h2 class="font-serif-l mb-2">About</h2>
              <p class="font-serif-m">In <a class="u" href="https://www.odi.org/" target="_blank">ODI</a>'s latest collaboration with designers <a class="u" href="https://twitter.com/fedfragapane" target="_blank">Federica Fragapane</a> and <a class="u" href="https://www.alexpiacentini.com/" target="_blank">Alex Piacentini</a>, explore the cities participating in the Mayors Dialogue on Growth and Solidarity in this data visualisation. Find out more about the Dialogue here.

                <!-- <a class="u" href="https://www.odi.org/projects/16889-mayors-dialogue-on-growth-and-solidarity-reimagining-human-mobility-in-africa-and-europe" target="_blank">here</a>.</p> -->
               
              <div class="spacer py-3"></div>
              <p class="mb-5"><a class="btn" href="https://www.odi.org/publications/17420-mayors-dialogue-growth-and-solidarity-overview-cities-priorities-and-emerging-partnerships" target="_blank">Find out more &rarr;</a></p>
             
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="close-x" onclick="a.toggleLegend();">&times;</a>
  </div>

  <nav id="header" class="<?= ($cityDetailId ? "" : "hide ") ?><?= $palette ?>-bg">
    
    <?php if ($cityDetailId === null): ?>
      <!-- xs, sm -->
      <a class="d-md-none color-black" href="<?= $urls["site"] ?>">
        <img class="title-xs" src="<?= $urls["assets"] ?>/images/logo-xs.svg" />
      </a>

      <!-- md up -->
      
      <h1 class="d-none d-md-block title font-serif-l"><a class="color-black" href="<?= $urls["site"] ?>"><?= $headerTitle ?></a></h1>

      <!-- V2 
      <h1 class="d-none d-md-block title pt-2"><a class="color-black" href="<?= $urls["site"] ?>">
        <span class="font-serif-l">Mayors Dialogue</span><br />
        <span class="font-serif-s" style="position: relative; top: -13px;">on Growth and Solidarity</span>
      </a></h1>
      -->
    <?php else: ?>
      <a class="font-sans-m font-bold color-black" href="<?= $urls["site"] ?>">&larr; BACK</a>
    <?php endif ?>
    
    <div class="text-right">
      <a class="ml-3 font-sans-m font-bold color-black" onclick="a.toggleLegend();">How to explore</a>
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

