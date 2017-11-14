<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('layouts.head_include')


  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


  <link rel="stylesheet" href="{{ route('root_path') }}/plugins/vegas/vegas.min.css">
  <script src="{{ route('root_path') }}/plugins/vegas/vegas.js"></script>
  <script>
  $(function() {
      $('#login').click(function(){
        location.href = '{{ route('root_path') }}';
      });
      
      $('body').vegas({
          slides: [
              @foreach(explode(',' , ConfigHelper::getConfigValueByKey('login_pictures')) as $picture)
                { src: '{{UrlHelper::getLoginPictureUrl($picture)}}' },
              @endforeach
          ],
          //transition: 'zoomOut',
          animation: 'random',
          overlay: '{{ route('root_path') }}/plugins/vegas/overlays/07.png',
          shuffle: true,
          loop: true,
      });
  });
  </script>
</head>
<body class="hold-transition login-page">
  <section class="content">
      <div class="error-page" style=" margin-top: 210px; ">
        <h2 class="headline text-yellow"> 500</h2>

        <div class="error-content" style="color: white; text-shadow: black 0.1em 0.1em 0.2em">
          <h3><i class="fa fa-warning text-yellow"></i> Oh! 找不到頁面</h3>

          <p>
            你似乎因為一連串美麗的錯誤<br>
            來到了這個奇怪的頁面<br>
            想回到首頁頁面請點回到首頁
          </p>
          <button type="button" name="login" id="login" class="btn btn-block btn-warning btn-lg"><i class="fa fa-sign-in"></i> 回到首頁</button>
            <!-- /.input-group -->
          </form>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section>
</body>
</html>
