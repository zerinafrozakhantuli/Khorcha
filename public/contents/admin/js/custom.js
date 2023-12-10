setTimeout(function(){
	$('.alert_success').slideUp(1000);
},5000);

setTimeout(function(){
	$('.alert_error').slideUp(1000);
},10000);



// modal code start

$(document).ready(function() {
	$(document).on("click","#softDelete", function(){
		var deleteID = $(this).data('id');
		$(".modal_body #modal_id").val(deleteID);
	});

	$(document).on("click","#restore", function(){
		var restoreID = $(this).data('id');
		$(".modal_body #modal_id").val(restoreID);
	});

	$(document).on("click","#delete", function(){
		var deleteID = $(this).data('id');
		$(".modal_body #modal_id").val(deleteID);
	});
});

// datatables

$(document).ready( function () {
    $('#myTable').DataTable();


$('#alltableinfo').DataTable({
	"paging": true,
	"lengthChange": true,
	"searching": true,
	"ordering": false,
	"info": true,
	"autoWidth": false
});

$('#alltableDesc').DataTable({
	"paging": true,
	"lengthChange": true,
	"searching": true,
	"ordering": true,
	"order": [[0, "desc"]],
	"info": true,
	"autoWidth": false
});

$('#inexsummary').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": false,
		"ordering": true,
		"info": true,
		"autoWidth": false,
		"order": [[ 0, "desc" ]],
	});

});

// datepicker
$(function(){
	$('#date').datepicker({
	autoclose: true,
	format:'yyyy-mm-dd',
	todayHighlight: true
	
});

	$('#startDate').datepicker({
	autoclose: true,
	format:'yyyy-mm-dd',
	todayHighlight: true
	
});
	$('#endDate').datepicker({
	autoclose: true,
	format:'yyyy-mm-dd',
	todayHighlight: true
	
});


});