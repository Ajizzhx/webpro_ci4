<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Perpustakaan Berbasis web</title>

  <link href="/Assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="/Assets/css/datepicker3.css" rel="stylesheet">
  <link href="/Assets/css/bootstrap-table.css" rel="stylesheet">
  <link href="/Assets/css/styles.css" rel="stylesheet">
  <link href="/Assets/css/sweetalert2.min.css" rel="stylesheet">
  <!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->
  <script type="text/javascript">
    function getkey(e) {
      if (window.event)
        return window.event.keyCode;
      else if (e)
        return e.which;
      else
        return null;
    }

    function goodchars(e, goods, field) {
      var key, keychar;
      key = getkey(e);
      if (key == null) return true;

      keychar = String.fromCharCode(key);
      //keychar = keychar.toLowerCase(); 
      //goods = goods.toLowerCase(); 

      // check goodkeys 
      if (goods.indexOf(keychar) != -1)
        return true;
      // control keys 
      if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
        return true;

      if (key == 13) {
        var i;
        for (i = 0; i < field.form.elements.length; i++)
          if (field == field.form.elements[i])
            break;
        i = (i + 1) % field.form.elements.length;
        field.form.elements[i].focus();
        return false;
      };
      // else return false 
      return false;
    }
  </script>
</head>

<body>
  <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><span>Lumino</span>Admin</a>
        <ul class="user-menu">
          <li class="dropdown pull-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span> User <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#"><span class="glyphicon glyphicon-user"></span> Profile</a></li>
              <li><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
              <li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>

    </div><!-- /.container-fluid -->
  </nav>