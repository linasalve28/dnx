$(function() {

    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });

    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });


});

$(document).ready(function() {

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }


// X1 Experimental

   


    // F1 Function: Submit form using POST and AJAX

    $("#bodytag").on("submit", ".f1", function(e) {

        //Old version: $('.f1').on('submit', function(e) {
        e.preventDefault();

        // Remove existing error message from form
        $(".highlightform").removeClass("highlightform");
        $(".form_error_message").text('');

        var name = $(this).attr('id');
        var action = $(this).attr('action');

        $.post(action, $('#' + $(this).attr('name')).serialize(),
            function(data, status, xhr) {
	        

 if(xhr.status == '200') {

            
                response = JSON.parse(data);
              

                if (response["outcome"] == "success") {

                    toastr.success(response["lmessage"], response["smessage"]);

                    if (response["refresh-div"]) {
                        $("#" + response["refresh-div"]).load(response["refresh-url"]);
                        setTimeout(function() {
                            $('.ajax_refreshed_highlight').addClass('ajax_refreshed_no_highlight');
                        }, 1000);

                    }



                    // Clears the form, clears validation messages, hides modals
                    $("#" + name)[0].reset();
                    $(".form_error_message").text('');
                    $('.modal').modal('hide');

                    if (response["force-refresh"] == "yes") {
	     
	                    setTimeout(function() {
                             window.location.reload();
                        }, 500);

	                   
                    }

                } else if (response["outcome"] == "fail") {
                    toastr.error(response["lmessage"], response["smessage"]);


                    for (var key in response['validate']) {
                        $('input[name=' + key + ']').addClass('highlightform');
                        $('#' + key + '_error').text(' (' + response['validate'][key] + ')');
                    }


                } else {
                    toastr.warning("An error prevented processing your request", "Error");
                }
}
            });
    });


$('.messenger_input').keypress(function (e) {
  if (e.which == 13) {
    $('.messenger').submit();
    return false;    //<---- Add this line
  }
});

$("#bodytag").on("submit", ".messenger", function(e) {

        //Old version: $('.f1').on('submit', function(e) {
        e.preventDefault();

        // Remove existing error message from form
        $(".highlightform").removeClass("highlightform");
        $(".form_error_message").text('');

        var name = $(this).attr('id');
        var action = $(this).attr('action');
        $.post(action, $('#' + $(this).attr('name')).serialize());
        
        $('.messenger_input').val('');

        
    });




    $('#focus').click(function() {
        window.open($(this).attr('href'),'title', 'width=700, height=600');
        return false;
    });   


    // Any link with this class will trigger an ajax call

   //$(".f2").click(function(e) {

$("#bodytag").on("click", ".f2", function(e) {

        e.preventDefault();

        var linkdest = $(this).attr('href');



        $.get(linkdest,
            function(data, status, xhr) {

                response = JSON.parse(data);

                if (response["outcome"] == "success") {


if (response["smessage"]) {
                    toastr.success(response["lmessage"], response["smessage"]);
}
                    if (response["refresh-div"]) {
                        
                        if (response["refresh-content"]) {
  
	                        $("#"+response["refresh-div"]).html(response["refresh-content"]);
                        } else {
                        
                        $("#" + response["refresh-div"]).load(response["refresh-url"]);
                        setTimeout(function() {
                            $('.ajax_refreshed_highlight').addClass('ajax_refreshed_no_highlight');
                        }, 1000);
						
						
						}



                    }
                    
                    if (response["force_refresh"] == "yes") {
	     
	                    setTimeout(function() {
                             window.location.reload();
                        }, 500);

	                   
                    }

                } else if (response["outcome"] == "fail") {
                    toastr.error(response["lmessage"], response["smessage"]);

                } else {
                    toastr.warning("An error prevented processing your request", "Error");
                }

            });


    });


    // Launch a modal window and load AJAX content into it

    $(".f3").click(function() {
	    
        $(".modal-body").load($(this).attr('href'));

    });



// Experimental design only trigger if something is empty

$("#bodytag").on("click", ".x6", function(e) {

        e.preventDefault();

        var linkdest = $(this).attr('href');
        
            });


// Experimental Function : Allows for easier opening of a modal window, including different sizes. Default is large.
 //$(".f4").click(function(e) {

$("#bodytag").on("click", ".f4", function(e) {
	 
    e.preventDefault();
    if ($(this).data("modal-size")) {
        var modal_size = $(this).data("modal-size");
    } else {
        var modal_size = "large";
    }

    if (modal_size == "large") {
        $("#modal-lg-content").load($(this).attr('href'));
        $("#modal-large").modal('toggle');
        document.getElementById("description").focus();

    } else if (modal_size == "small") {
        $("#modal-sm-content").load($(this).attr('href'));
        $("#modal-small").modal('toggle');
    }

});





$("#modal-large").on("show.bs.modal", function () {

        $("#modal-lg-content").html('');


});



$("#modal-large").on("hidden.bs.modal", function () {

});

$("#modal-small").on("hidden.bs.modal", function () {
 
});


// Enables filtering of results etc
	
	//
	
	$( document ).ready(function() {
		
		 $("#bodytag").delegate(".filter","keyup",function(e){
//$(".filter").keyup(function() {

target=$(this).data("filter-target");

      // Retrieve the input field text and reset the count to zero
      var filter = $(this).val(),
        count = 0;

      // Loop through the comment list
      $('#'+target).each(function() {


        // If the list item does not contain the text phrase fade it out
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).hide();

          // Show the list item if the phrase matches and increase the count by 1
        } else {
          $(this).show();
          count++;
        }

      });

    });

});


	  $(".filter").focusout(function() {

  	if ($(this).val().length > 0)
    {
    	$(this).addClass('expanded');
    }
    else
    {
    	$(this).removeClass('expanded');
    }
  });

// Document Ready ending



});