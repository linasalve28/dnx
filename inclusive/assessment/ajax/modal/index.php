<?php
	
	function main() {
?>
<script>

var modal_already_loaded=false;

$(document).ready(function(){
	
	$(".modal").on("hidden.bs.modal", function(){
   $(this).find("input,textarea,select").val('').end();
    $("#question").html('');
	});
		
   /*
   $("button").click(function(){
        $("#thisone").replaceWith("Hello world!");
    });
    */
    $('#basicModal').on('hidden.bs.modal', function () {
       // console.log("HT: modal hide!");
        reset_modal_form(); // set to initial value!!
    });

	    
    $('#basicModal').on('shown.bs.modal', function () {
//        console.log("HT: modal shown!");
//        console.log("CONTENT: "+$("#thisone").html());
        if(!modal_already_loaded){
            //console.log("HT: first time!");
            // attach events to model content elements only after the first modal shown!
            $("#selector").on("change", function() {
                //console.log("HT: selector change: "+$("#selector").val())
                if($("#selector").val()=="text") {
                    $("#question").load("/inclusive/assessment/ajax/modal/response.php?id=1");
                } else if($("#selector").val()=="selectbox") {
                    $("#question").load("/inclusive/assessment/ajax/modal/response.php?id=2");
                }
            });
            $('#modal_form_submit').click(function(){
//            $("body").on('click', '#modal_form_submit', function(){
                var formaction = $("#modalform").attr("action");
               // console.log("HT: form submitted with:");
                $.ajax({
                    type: "POST",
                    url: formaction,
                    data: $('#modalform').serialize(),
                    success: function(message){
                        $("#feedback").html(message);
                        $("#basicModal").modal('hide');
                    },
                    error: function(){
                        alert("Error occurred.");
                    }
                });
            });
            $('#modalform').on('keydown', function(e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        }else{
            //console.log("HT: NOT first time!")
        }
        modal_already_loaded=true;
    });
});

function reset_modal_form(){
   // $("#selector").val('text'); // question type = text !
  //  $("#question_text").val(''); // question text = empty !
//    $("#question").html(''); //reset option box !

   	}
</script>

    <a class="btn btn-lg btn-success" data-toggle="modal" data-target="#basicModal"  href="/inclusive/assessment/ajax/modal/modal.html">Click to open Modale</a>
    <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id="modal-content">
            </div>
        </div>
    </div>
    <div id="feedback"> </div>

<?php
}
?>