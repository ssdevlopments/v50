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
		    	<div class = "form-group row">
					<label for="" class="control-label col-sm-12 col-sm-offset-2">Select Due Creation Date:</label>
					<div class="col-sm-12">
						<select class="form-control" id="cmbDate" name="cmbDate">
							<option value="">Select Date</option>
														
						</select>
						<button type="submit" id="btnFilter" name="btnFilter" class="btn btn-info custombtn" onclick="get_data()"><i class="fa fa-search"></i> Filter</button>
					</div>
					
			    </div>
		    </div>
		    <div id="table_div">
	    	</div>
	    </div>
	    <input type="text" class="form-control tooltips" name="csrf_token" id="csrf_token" value="{{ csrf_token() }}"/>
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
			url: url+"/school/fee/due/creation/getDate",
			type:"get",
			data:{_token:$("#csrf_token").val(),student_code:student_code},
			success:function(response)
			{
			
				$.each(response,function(i,data)
				{
					
					var options = "";					
					var defaultoption="<option selected value='' >select Date</option>";
					
					$.each(response,function(i,data)
					{
						options = options + "<option value="+data.period+">"+data.calendar_date+"</option>";				
					});
					
					$('#cmbDate').html("");  
					$('#cmbDate').append(defaultoption);
					$('#cmbDate').append(options);
				});
				
			},
			error:function()
			{
				toastr.error('Unable to process please contact support');
			}
		});
		
		
		
		
	});
	
	function get_data(){
		var student_code = '<?php echo $student_code;?>';
		var url = '<?php echo url('/');?>';
	
		$.ajax({
			url: url+"/school/fee/due/creation/getDebitModifyData",
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
	}
	
	function submit_data(){
		var formData = new FormData(document.getElementById("frm_dueModify"));
		var csrf = $("#csrf_token").val();
		
		formData.append('_token',csrf );
		//console.log(form_data);
		//alert("under progress");
		$.ajax({
			url: url+"/school/fee/due/creation/submitModifyDue",
			type:"post",
			data:formData,
			cache: false,
	        contentType: false,
	        processData: false,
			success:function(response)
			{
				//$("#table_div").html(response);
				
				
				
			},
			error:function()
			{
				toastr.error('Unable to process please contact support');
			}
		});
		
	}
	

</script>
