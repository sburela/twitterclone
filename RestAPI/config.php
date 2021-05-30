<?php

date_default_timezone_set("Canada/Eastern");
$timezone = new DateTimeZone("Canada/Eastern");
$datetime = new DateTime();
$datetime->setTimezone($timezone);

define('TIMEX',  $datetime->format("h:i:s"));
define('DATEX',  $datetime->format("Y-m-d"));
define('YEAR',  $datetime->format("Y"));

define('FROM', 'no-reply@twitter.com');
define('DEBUG', 0);

?>