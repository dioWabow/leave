<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統 DEMO</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('layouts.head_css')


  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


  <link rel="stylesheet" href="plugins/vegas/vegas.min.css">
  <script src="plugins/vegas/vegas.js"></script>
  <script>
  $(function() {
      $('#login').click(function(){
        location.href = 'index.html';
      });
      
      $('body').vegas({
          slides: [
              { src: 'dist/img/wabow-team2.jpg' },
              { src: 'dist/img/wabow-team3.jpg' },
              { src: 'dist/img/wabow-team4.jpg' },
              { src: 'dist/img/wabow-team5.jpg' },
              { src: 'dist/img/wabow-team6.jpg' },
              { src: 'dist/img/wabow-team7.jpg' },
              { src: 'dist/img/wabow-team8.jpg' },
          ],
          //transition: 'zoomOut',
          animation: 'random',
          overlay: 'plugins/vegas/overlays/07.png',
          shuffle: true,
          loop: true,
      });
  });
  </script>
</head>
<body class="hold-transition login-page">
  <div class="login-box">
  <div class="login-logo">
    <a href="index.html"><img src="dist/img/wabow_logo.png" width="50"> <b>哇寶</b>請假系統</a>
  </div>
  <button type="button" name="login" id="login" class="btn btn-block btn-warning btn-lg"><i class="fa fa-sign-in"></i> 我要登入</button>
</div>
</body>
</html>
