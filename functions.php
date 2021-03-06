<?php

/**
 * Die and inspect variable
 */
function kill($var){
  die("<pre>". print_r($var, true));
}


function formatByCity ($rawDataset) {
  $formatted = [];
  foreach ($rawDataset as $row) {
    $city = $row["city"];
    $formatted[$city] = $row;
  }
  return $formatted;
}


function formatById ($rawDataset, $stats) {
  $formattedDataset = [];
  foreach ($rawDataset as $row) {
    $id = $row["id"];
    $formattedRow = [
      "stats" => [],
    ];
    foreach ($stats as $stat) {
      $formattedRow["stats"][$stat] = [];
      $thisStatKeys = array_filter(array_keys($row), function ($key) use ($stat) { 
        return substr($key, 0, strlen($stat)) === $stat; 
      });
      foreach ($thisStatKeys as $key) {
        $subKey = substr($key, strlen($stat)+1);
        $formattedRow["stats"][$stat][$subKey] = $row[$key];
        unset($row[$key]);
      }
    }
    $formattedRow = array_merge($row, $formattedRow);
    $formattedDataset[$id] = $formattedRow;
  }
  return $formattedDataset;
}


function statMarkup ($stat, $statData, $svg, $palette) {
  // $statData["stat"]: 16
  // $statData["text"]: "16.00%"
  ?>

  <div class="stat mb-5 pb-3">
    <p class="description font-sans-m font-bold <?= $palette ?>-color-texts-upper"><?= $statData["description"] ?></p>
    <hr class="<?= $palette ?>-color-hr" />
    <p class="font-display-l font-bold <?= $palette ?>-color-texts-large"><?= $statData["text"] ?></p>
    <!-- <hr class="<?= $palette ?>-color-hr" /> -->
    <!-- <p class="mt-1 font-sans-s <?= $palette ?>-color-texts"><?= $statData["linescomment"] ?></p> -->

    <div class="stat-shape" data-stat-id="<?= $stat ?>"><?= $svg ?></div>
    
    <div class="stat-meta-row font-sans-s <?= $palette ?>-color-texts">
      <p class="label">Key</p><p class="info"><?= $statData["linescomment"] ?></p>
    </div>
    <!-- <hr class="<?= $palette ?>-color-hr" /> -->

    <?php if ($statData["year"]): ?>
      <hr class="<?= $palette ?>-color-hr" />
      <div class="stat-meta-row font-sans-s <?= $palette ?>-color-texts">
        <p class="label">Year</p><p class="info"><?= $statData["year"] ?></p>
      </div>
    <?php endif ?>

    <?php /*
    <?php if ($statData["source"]): ?>
      <div class="stat-meta-row font-sans-s <?= $palette ?>-color-texts">
        <p class="label">Source</p><p class="info"><?= $statData["source"] ?></p>
      </div>
      <hr class="<?= $palette ?>-color-hr" />
    <?php endif ?>

    <?php if ($statData["link"]): ?>
      <div class="stat-meta-row font-sans-s <?= $palette ?>-color-texts">
        <p class="label">Weblink</p><p class="info weblink"><a class="<?= $palette ?>-color-texts hover-u" href="<?= $statData["link"] ?>" target="_blank"><?= $statData["link"] ?></a></p>
      </div>
      <hr class="<?= $palette ?>-color-hr" />
    <?php endif ?>
    */
    ?>

    <?php if ($statData["source"]): ?>
      <?php
      $sourceText = $statData["source"];
      if (!$statData["link"]) {
        $sourceMarkup = $sourceText;
      } 
      else {
        $urls = explode(" and ", $statData["link"]);
        if (count($urls) == 1) {
          $sourceMarkup = '<a class="'. $palette .'-color-texts hover-u" href="'. $urls[0] .'" target="_blank">'. $sourceText .'</a>';
        } else {
          $sourceMarkup = '<p class="'. $palette .'-color-texts mb-1">'. $sourceText .'</p>';
          foreach ($urls as $i => $url) {
            $sourceMarkup .= '<p class="weblink">'. ($i+1) .'. <a class="'. $palette .'-color-texts hover-u" href="'. $url .'" target="_blank">'. $url .'</a></p>';
          }
        }
      }
      ?>
      <hr class="<?= $palette ?>-color-hr" />
      <div class="stat-meta-row font-sans-s <?= $palette ?>-color-texts">
        <p class="label">Source</p><div class="info"><div><?= $sourceMarkup ?></div></div>
      </div>
    <?php endif ?>

    <?php if ($statData["note"]): ?>
      <hr class="<?= $palette ?>-color-hr" />
      <div class="stat-meta-row font-sans-s <?= $palette ?>-color-texts">
        <p class="label">Notes</p><p class="info"><?= $statData["note"] ?></p>
      </div>
    <?php endif ?>

  </div>

  <?php
}





