

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



    // F1 Function: Submit form using POST and AJAX

    $("#bodytag").on("submit", ".f1", function(e) {

        //Old version: $('.f1').on('submit', function(e) {
        e.preventDefault();

        // Remove existing error message from form
        $(".highlightform").removeClass("highlightform");
        $( ".errortext" ).remove();
        $(".form_error_message").text('');

        var name = $(this).attr('id');
        var action = $(this).attr('action');

        $.post(action, $('#' + $(this).attr('name')).serialize(),
            function(data, status, xhr) {

                response = JSON.parse(data);

                if (response["outcome"] == "success") {
                    console.log('success');
                    toastr.success(response["lmessage"], response["smessage"]);

                    if (response["refresh-div"]) {
                        console.log('refreshing div');
                        //$(response["refresh-div"]).load( response['refresh-url'] );
                        //$(response["refresh-div"]).load(response['refresh-url'],response['url-data']);
                        setTimeout(function(){
                            $('.ajax_refreshed_highlight').addClass('ajax_refreshed_no_highlight');
                        }, 1000);
                        window.location.reload();
                    }

                    // Clears the form, clears validation messages, hides modals
                    // $($(this).attr('id'))[0].reset();
                    //$(".form_error_message").text('');
                    $('.modal').modal('hide');

                    if (response["force_refresh"] == "yes") {
	                    setTimeout(function() {
                             window.location.reload();
                        }, 500);
                    }

                } else if (response["outcome"] == "fail") {



                    toastr.error(response["lmessage"], response["smessage"]);


                    for (var key in response['validate']) {
                        //$('input[name=' + key + ']').addClass('highlightform');
                        //$( '#' + key ).append( '<span class="error">('+ response['validate'][key] +')</span>' );
                        //  $('#' + key + '_error').text(' (' + response['validate'][key] + ')');
                        $('#'+ key ).addClass('highlightform');
                        $( "<span class='errortext'>"+ response['validate'][key] +"</span>").insertAfter('#' + key );
                    }


                } else {
                    toastr.warning("An error prevented processing your request", "Error");
                }

            });
    });



    // Any link with this class will trigger an ajax call

// Submit data with GET and AJAX
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
  
	                        $(response["refresh-div"]).html(response["refresh-content"]);
                        } else {
                        
                            $(response["refresh-div"]).load(response["refresh-url"]);
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

    } else if (modal_size == "small") {
        $("#modal-sm-content").load($(this).attr('href'));
        $("#modal-small").modal('toggle');
    }

});


// F5 Functions : Confirmation Dialog
$("#bodytag").on("click", ".f5", function(e) {
	e.preventDefault();
	$("#f5-confirm").attr("href", $(this).attr('href'));
	if ($(this).data('confirm-message')) {
	$('.modal-body','#modal-confirm').html($(this).data('confirm-message'));
	}
	if ($(this).data('f5-confirm')) {
			$('#f5-confirm','#modal-confirm').html($(this).data('f5-confirm'));
	} 
	if ($(this).data('overide-f2')=="yes") {
		$("#f5-confirm").removeClass('f2');
	}
	
	if ($(this).data('f5-dismiss')) {
						$('#f5-dismiss','#modal-confirm').html($(this).data('f5-dismiss'));
	}
	$("#modal-confirm").modal('toggle');
});
$("#bodytag").on("click", "#f5-confirm", function(e) {
		$("#modal-confirm").modal('toggle');
				$("#f5-confirm").addClass('f2');
});





$("#modal-large").on("hidden.bs.modal", function () {

});

$("#modal-small").on("hidden.bs.modal", function () {
 
});

// Document Ready ending
});
