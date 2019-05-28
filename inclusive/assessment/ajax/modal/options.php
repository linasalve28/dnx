
    <div class="opt_container">
      <div class="opt">
        <input name="option[]" class="opt-value" type="text"><span class="close-div">X</span>
      </div>
    </div>
        <button type="button" class="add_more">+ Option</button>
<!--    <input type="submit" value="Submit" id="upload">-->

    <script>
        $('.add_more').click(function(e) {
          e.preventDefault();
          $('.opt_container').append('<div class="opt"><input name="option[]" type="text"/><span class="close-div">X</span></div>');
        });
        $('.opt_container').on('click', '.close-div', function() {
          $(this).parent().remove();
        });
        $('.opt_container').on('keydown','.opt:last-child  input', function(e) {
          if($('.opt:last-child  input').val()!="") {
            if (e.keyCode === 13) {
              e.preventDefault();
              $('.opt_container').append('<div class="opt"><input name="option[]" type="text"/><span class="close-div">X</span></div>');
              $('.opt > input').last().focus();
            }
          }
        });
    </script>
