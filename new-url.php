<?php
require('orbis_destination.php');
$url = filter_var($_POST['url'], FILTER_SANITIZE_URL);
$redirect = new Orbis_Destination($url);
if ($result = $redirect->get_result()) {
  echo $result;
}
else {
  echo 'Redirect test failed.';
}
?>