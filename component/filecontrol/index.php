<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<html>
  <head>
    <script>
      $(document).ready(function(){
        $('.add_more').click(function(e){
          e.preventDefault();
          $(this).before("<input name='option[]' type='text'/><br />");
        });
        $('.close-div').on('click', function(){
    $(this).parent().parent().remove();
});
      });
    </script>
  </head>
  <body>
    <form enctype="multipart/form-data" action="process.php" method="post">
     <div><input name='option[]' type='text'/><span class="close-div">X</span><br /></div>
      <button type='button' class="add_more">+ Option</button>
      <input type="submit" value="Submit" id="upload"/>
    </form>
  </body>
</html>
