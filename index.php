<?php

//======================================================================
// Output preference?
//======================================================================

// Comment out this line if you want to have rendered HTML
// Leaving this line will make it easier for you to copy and paste the resulting HTML
header("Content-Type: text/plain");

//======================================================================
// Define shelves and customization
//======================================================================

// Possible options: currently-reading, to-read, read
$shelves_ids = ['currently-reading'];

// To be used as section title output
$shelves_title = ['📖 Currently Reading'];

//======================================================================
// Define your user profile
//======================================================================

$user_profile_id = "33604217";

//======================================================================
// RSS lists
//======================================================================
// Note: it seems API key might not be necessary if you're logged in on the site.
$profile_rss = 'https://www.goodreads.com/review/list_rss/' . $user_profile_id .'?key=&shelf=';

//======================================================================
// The danger zone
//======================================================================
$shelf_count = 0;
foreach ($shelves_ids as $shelf) {

  // Construct the shelf feed and fetch it
  $feed = simplexml_load_file($profile_rss . $shelf);

  // Print the shelf heading
  echo "## " . $shelves_title[$shelf_count] . "\n";
  $shelf_count++;

  // No books are currently being read
  if (count($feed->channel->item) === 0) {
    echo "Nothing right now.\n";
    continue;
  }

  foreach ($feed->channel->item as $item) {

    // Access the RSS object
    $link = substr($item->link, 0, strpos($item->link, '?'));
    $title = $item->title;

    echo "* [" . $title . "](" . $link . ")\n";

  } // end item loop

  // I read in the API docs to not do more than 1 request per second
  // Just in case, we'll wait 1 second in between shelves.
  sleep(1);

} // end foreach shelves