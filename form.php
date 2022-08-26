<!DOCTYPE html>
<html>
  <head>
    <title>Get Redirect Destination</title>
    <style>
      input[type="text"] {
        width: 70rem;
        max-width: 90%;
      }
      #result {
        padding: .5rem;
        border: 1px solid #ccc;
        background: #eeffff;
        display: none;
      }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
        $('#get-redirect').on('submit', function(e) {
          e.preventDefault();
          var url = $('#url').val();
          $('#result').html('Loading...').show();
          $.post('new-url.php', {url:url}, function(result) {
            $('#result').html(result);
          });
          return false;
        });
      });
    </script>
  </head>
  <body>
    <h1>Get Redirect Destination</h1>
    <p>Enter the old Primo link with your new CNAME domain.</p>
    <form name="get-redirect" id="get-redirect" method="get" action="new-url.php">
      <p>
        <label for="url">Primo URL: </label>
        <input type="text" name="url" id="url" />
      </p>
      <p>
        <input type="submit" value="Get Destination" />
      </p>
    </form>
    <div id="result"></div>
  </body>
<html>