<!DOCTYPE HTML>
<html lang=en>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login/Register</title>
    <meta content="" name="description">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"/>

    <link rel="stylesheet" href="<?= base_url(); ?>/public/main.css">
</head>
<body>
  <?php
      $err_up = validation_errors('<li>', '</li>');
      if( $err_up ) {?>
      <ul class="list-unstyled alert alert-danger">
      <?php echo $err_up; ?>
      </ul>
    <?php } ?>
  <form action =" <?='admin/update/answer'; ?>" method="post">
        <textarea rows="5" cols="50" name="updated_a">
            <?= $answer_id; ?>

        </textarea>
        <input type="hidden" name="a_id" value="<?= $a_id; ?>" >
        <input type="submit" value="update" class="btn btn-primary">
  </form>







    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
