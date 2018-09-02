<?php status_header(200); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>
<body>
  <div id="app"></div>
  <?php wp_footer(); ?>
  <script src="https://unpkg.com/@ionic/core@latest/dist/ionic.js"></script>
</body>
</html>