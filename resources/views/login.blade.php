<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Inventory System | Login</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
  <br /><br /><br /><br /><br /><br />
  <div class="container">
    <section id="content">

      @if ($message = session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      @endif

      <p class="login-box-msg" style="color : red; font-weight: bold;"></p>
      <form action="/login" method="post">
        @csrf
        <h1>Inventory App</h1>
        <div>
          <input type="text" name="username" id="username" placeholder="Username" required id="username"
            autocomplete="off" />
        </div>
        <div>
          <input type="password" name="password" id="password" placeholder="Password" required id="password"
            autocomplete="off" />
        </div>
        <div>
          <button type="submit">Login</button>
      </form><!-- form -->

    </section><!-- content -->
  </div><!-- container -->
</body>

</html>
