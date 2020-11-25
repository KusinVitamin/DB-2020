<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(function(){
    var includes = $('[data-include]');
    jQuery.each(includes, function(){
      var file = '/~erisal-8/php1/' + $(this).data('include') + '.php';
      $(this).load(file);
    });
  });
</script>
</head>
<body>
<div data-include="Header"></div>
<form method="get" action="/~erisal-8/php1/CreateAccount.php">
    <button type="submit">Create account</button>
</form>
<form method="get" action="/~erisal-8/php1/Login.php">
    <button type="submit">Log in</button>
</form>
</body>

</html>