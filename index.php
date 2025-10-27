 <?php
  session_start();
  require_once "./components/leftBar.php";
  require_once "./components/header.php";
  require_once "./components/mainMenu.php";
  require_once "./components/player.php";
  require_once "./conect.php";
  require_once "./functions.php";
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
   <script src="./components/playerScript.js"></script>
   <script src="app.js"></script>
 </body>

 </html>