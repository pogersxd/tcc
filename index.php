 <?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  require_once __DIR__ . "/components/leftBar.php";
  require_once __DIR__ . "/components/header.php";
  require_once __DIR__ . "/components/mainMenu.php";
  require_once __DIR__ . "/components/player.php";
  ?>
 <!DOCTYPE html>
 <html lang="pt-br">

 <head>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="icon" href="assets/james.png">
   <link rel="stylesheet" href="styles.css">
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>TCC</title>
 </head>

 <body>
   <?= renderHeader(); ?>
   <div class="leftbar-mainmenu">
     <?= renderLeftBar(); ?>
     <?= renderMainMenu(); ?>
   </div>
   <?= renderPlayer(); ?>
   <script src="app.js"></script>
 </body>

 </html>