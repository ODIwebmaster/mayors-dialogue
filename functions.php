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


function statMarkup ($stat, $statData, $svg) {
  // $statData["stat"]: 16
  // $statData["text"]: "16.00%"
  ?>

  <div class="stat mb-5 pb-3">
    <p class="font-sans-m font-bold color-a"><?= $statData["description"] ?></p>
    <hr class="border-top-color-c my-1" />
    <p class="font-sans-l font-bold color-a"><?= $statData["text"] ?></p>

    <div class="stat-shape my-3" data-stat-id="<?= $stat ?>"><?= $svg ?></div>
    
    <hr class="border-top-color-c my-1" />

    <?php if ($statData["year"]): ?>
      <div class="stat-meta-row font-sans-s color-a">
        <p class="label">Year</p><p class="info"><?= $statData["year"] ?></p>
      </div>
      <hr class="border-top-color-c my-1" />
    <?php endif ?>

    <?php if ($statData["source"]): ?>
      <div class="stat-meta-row font-sans-s color-a">
        <p class="label">Source</p><p class="info"><?= $statData["source"] ?></p>
      </div>
      <hr class="border-top-color-c my-1" />
    <?php endif ?>

    <?php if ($statData["link"]): ?>
      <div class="stat-meta-row font-sans-s color-a">
        <p class="label">Weblink</p><p class="info weblink"><?= $statData["link"] ?></p>
      </div>
      <hr class="border-top-color-c my-1" />
    <?php endif ?>

    <?php if ($statData["note"]): ?>
      <div class="stat-meta-row font-sans-s color-a">
        <p class="label">Notes</p><p class="info"><?= $statData["note"] ?></p>
      </div>
      <hr class="border-top-color-c my-1" />
    <?php endif ?>

  </div>

  <?php
}





