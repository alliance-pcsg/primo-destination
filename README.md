# primo-destination
This self-contained application follows the responses from a Primo Classic URL until it either:

1. Finds a redirect location starting with /discovery, and prints out the complete VE URL.
2. Ends on a response with a status other than 302 or 301 (such as 200 OK or 404 Not Found), and prints "No redirect URL found."

Entered URLs must first be updated to use a VE CNAME or custom domain, or they will land on the Orbis Cascade Alliance website with a 200 response. The permalink redirection tables must also be set up and working properly, or the URLs won't land at the correct destination.

## Files
- **form.php** is an example webpage that checks the destination of an entered URL asynchronously and displays the results.
- **new-url.php** is an example script that returns the destination of the posted URL to the form page.
- **orbis_destination.php** contains the class that performs the cURL checks and finds the destination.

## Customization
To customize these scripts for local use, you can download orbis_destination.php and include it in another PHP application. On construction, Orbis_Destination will find the destination and set it as a public property.

For example, the script below will check an array of URLs and print the results in a table. You could also parse the contents of a file with a URL on each line with [fgets](https://www.php.net/manual/en/function.fgets.php). Note that for a very large batch of URLs, an asynchronous solution might be needed to prevent your script from timing out.
```
<?php
  require('orbis_destination.php');
  $urls = array('https://CNAME.primo.exlibrisgroup.com/primo-explore/etc.', 'https://CNAME.primo.exlibrisgroup.com/pemalink/etc.');
  echo '<table><thead><tr><th>Classic URL</th><th>VE Destination</th></tr></thead><tbody>';
  foreach ($urls as $url) {
    echo '<tr><td>' . $url . '</td><td>';
    $dest = new Orbis_Destination($url);
    if ($new_url = $dest->destination) {
      echo $dest->destination;
    }
    else {
      echo 'No redirect URL found.';
    }
    echo '</td></tr>';
  }
  echo '</tbody></table>';
?>
```
