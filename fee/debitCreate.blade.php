<?php
	$student_code = $_REQUEST['student_code'];
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Debit</title>
		<style media="all" type="text/css">
	  		.alignRight { text-align: right; }
	  		.row {
			    margin-left: 0;
			    margin-right: 0;
			}
			.btn{
				border-radius:0px;
			}
		</style>
	</head>

<body>
	<div class="row" style="background-color:#aaaaff; ">
			<br>
			<div class="col-lg-4" >
				<label id="lbl_student_detail" class="col-sm-12 control-label"></label>
				<label class="col-sm-12 control-label"></label>
    		</div>
    	</div>
		<div class="tab-content">
		
		    <div class="form-group">
		    	
		    </div>
		    <div id="table_div">
	    	</div>
	    </div>
	    
	</body>	
</html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
	var student_code = '<?php echo $student_code;?>';
	var url = '<?php echo url('/');?>';
	
	//$("#lbl_student_detail").html(student_code);
	
	
	$( document ).ready(function() {
    	$.ajax({
			url: url+"/school/fee/due/creation/getStudentInfo",
			type:"get",
			data:{_token:$("#csrf_token").val(),student_code:student_code},
			success:function(response)
			{
			
				$.each(response,function(i,data)
				{
					
					var admission_no = data.admission_no;
					var student_name = data.student_name;
					var course_name = data.course_name;
					var class_name = data.class_name;
					var category_1 = data.category_1;
					var category_2 = data.category_2;
					
					var lbl = '<b>Admission No - </b>'+admission_no + '<b> Name: </b>'+student_name + '<b> Course </b>'+course_name + '<b> Class </b>'+class_name+ '<b> Category-1 </b>'+ category_1 + '<b> Category-2 </b>'+category_2;
					$("#lbl_student_detail").html('');
					$("#lbl_student_detail").html(lbl);
				});
				
			},
			error:function()
			{
				toastr.error('Unable to process please contact support');
			}
		});
		
		$.ajax({
			url: url+"/school/fee/due/creation/getDebitCreateData",
			type:"get",
			data:{_token:$("#csrf_token").val(),student_code:student_code},
			success:function(response)
			{
				$("#table_div").html(response);
				
			},
			error:function()
			{
				toastr.error('Unable to process please contact support');
			}
		});	
	});

</script>
