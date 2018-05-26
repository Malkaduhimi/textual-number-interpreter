<?php

require_once("vendor/autoload.php");

use NumberInterpreter\TextualNumberInterpreter;
use NumberInterpreter\Setup;

Setup::init();

if ( ! empty($_POST['textual_number']))
    $foundNumber = (new TextualNumberInterpreter)->interpret($_POST['textual_number']);
else
    $foundNumber = false;
?>
<html>
  <head>
    <title>Number Interpreter</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css" />
  </head>
  <body>
    <div class="container">
      <div class="row">
	<div class="col-md-12">
	  <h1>Number Interpreter</h1>
	</div>
      </div>
      <?php if ($foundNumber !== false ): ?>
      <div class="row">
	<div class="col-md-12">
          <div class="jumbotron">
            <h2>Recognized number "<?= $foundNumber ?>"</h2> 
          </div>
	</div>
      </div>
      <?php endif; ?>
      <div class="row">
	<div class="col-md-12">
	  <div class="card">
            <div class="card-body">
              <form action="/index.php" method="post">
		<div class="form-group">
		  <label for="textual_number">Textual Number:</label>
		  <input type="text" class="form-control" id="textual_number" name="textual_number">
		</div>
		<button type="submit" class="btn btn-default">Submit</button>
              </form>
            </div>
	  </div>
	</div>
      </div>
    </div>
  </body>
</html>
