<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Goodreads: Ricard Torres</title>
</head>
<body>
<?php

https://www.goodreads.com/api
include ('api.php');

$shelves = ['currently-reading', 'to-read', 'read'];

$profile_rss = 'https://www.goodreads.com/review/list_rss/104159625?key=&shelf=';

foreach ($shelves as $shelf) {
  $feed = simplexml_load_file($profile_rss.$shelf);

    echo "<h1>" . $shelf . "</h1>";

    $years = [];

    foreach ($feed->channel->item as $item) {
      $years[date('Y', strtotime($item->pubDate))][] = $item;
    }

    foreach ($years as $key => $year) {
      if ($shelf === 'read') {
        echo "<h3>" . $key . "</h3>";
      }

      echo "<ul>";
      foreach ($year as $item) {
        $link = $item->link;
        $rating = $item->user_rating;
        ?>
        <li><a href="<?=$link?>" rel="nofollow" title="Goodreads: <?=$item->title?>"><?=$item->title?> <?php
            if ($shelf === 'read' && $rating) {
              for ($i=0; $i < intval($rating); $i++) {
                echo "⭐️";
              }
            } ?></a>
        </li>
      <?php
      } // end item loop
      sleep(1);
    ?>
    </ul>
    <?php
      } // end year loop
} // end foreach shelves

?>

</body>
</html>