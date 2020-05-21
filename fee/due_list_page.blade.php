	@include ('school.includes.top')
  
  <style>
	#dtblStudentAssign_wrapper{
		margin-top: 38px;
	}
    </style>
    
   </head>
   <body class="theme-bright breakpoint-1200">
    
	@include ('school.includes.header')

  	<div id="container" class="fixed-header">
       
        @include ('school.includes.left')
        
        <div id="content">
            <div class="container">
               	<div class="crumbs">
                  <ul id="breadcrumbs" class="breadcrumb">
                     <li> <i class="icon-home"></i> <a href="#">Dashboard</a> </li>
                     <li> <a title="">Fee Management</a></li>
                     <li class="current"> <a title="">Due Creation</a></li>
                  </ul>
               	</div>
               	<br>
               	<div class="row">
                 	<div class="col-md-12">
                     	<div class="widget">
	                        <div class="widget-content">
	                           	<div class="tabbable tabbable-custom">
	                              	<ul class="nav nav-tabs master">
	                                 	<li class="active"><a href="#define1" data-toggle="tab">Due Creation</a></li>
	                              	</ul>
	                              	<div class="tab-content">
	                                	<div class="form-group">
											<div class="col-sm-6">
												
											</div>
											<div class="col-sm-2">
												<select class="form-control" id="cmbCourseFilter_StudentAssign">
													
												</select>
											</div>
											<div class="col-sm-2">
												<select class="form-control" id="cmbClassFilter_StudentAssign">
													<option value="">Select Class</option>
												</select>
											</div>
											<div class="col-sm-2">
												<input class="form-control" type="text" placeholder="Admission Number" id="admission_number" name="admission_number"/>
											</div>
											<div class="col-sm-2">
												<button type="button" class="btn btn-primary" data-loading-text="..." id="btnFilter_StudentAssign" title="Filter" style="height: 28px;"><i class="icon-search"></i></button>
												<button type="button" class="btn btn-success" data-loading-text="..." id="btnReport" style="height: 28px;"><i class="icon-refresh"></i>&nbsp;Reports</button>
											</div>
										</div>
										
										<div id="div_dtblfeedetails">
											
										</div>
										
										
										
	                              	</div>
	                              	
	                           	</div>
	                		</div>
             			</div>
          			</div>
       			</div>
	    	</div>
	 	</div>
	</div>
  
@include ('school.includes.footer')

<script>
$(document).ready(function(){
	
    var url = '<?php echo url('/');?>';
    
    // Course
	$.ajax({
		url:url+"/school/master-page/api/SELECT_ALL_COURSE_AJAX",
		mType:"get",
		success:function(response)
		{
			var options = "";					
			var defaultoption="<option selected value=''>Select Course</option>";
			$.each(response, function(i,data)
			{
				options = options + "<option value="+data.course_code+">"+data.course_name+"</option>";				
			});
			
			$('#cmbCourseFilter_StudentAssign').html("");  
			$('#cmbCourseFilter_StudentAssign').append(defaultoption);
			$('#cmbCourseFilter_StudentAssign').append(options);
		},
		error:function()
		{
			toastr.error('Unable to process please contact support');
		}
	});
	
	// Class load on Course Change
	$('#cmbCourseFilter_StudentAssign').on("change",function(event)
	{
		var course_code = $('#cmbCourseFilter_StudentAssign').val(); 
		$.ajax({
			url:url+"/school/master-page/api/SELECT_ALL_CLASS_BY_COURSE_AJAX",
			type:"get",
			async: false,
			data:{course_code:course_code,_token:$('#csrf_token').val()},
			success:function(response)
			{  
				var options = "";
				var defaultoption="<option selected value='' required>Select Class</option>";
				$.each(response,function(i,data)
				{
					options = options + "<option value="+data.class_code+">"+data.class_name+"</option>";				
				});
				
				$('#cmbClassFilter_StudentAssign').html("");
				$('#cmbClassFilter_StudentAssign').append(defaultoption);
				$('#cmbClassFilter_StudentAssign').append(options);
			},
			error:function()
			{
				toastr.error('Unable to process please contact support');
			}
		});
	});
	
	 get_data();
	
});	
	
$('#btnFilter_StudentAssign').click(function()
{
	get_data();
});	

function get_data(){
	
	var url = '<?php echo url('/');?>';
	var course_code = $("#cmbCourseFilter_StudentAssign").val();
	var class_code = $("#cmbClassFilter_StudentAssign").val();
	var admission_number = $("#admission_number").val();
	
	$.ajax({
			url: url+"/school/fee/due/creation/selectAll",
			type:"get",
			data:{_token:$("#csrf_token").val(),course_code:course_code,class_code:class_code,admission_number:admission_number},
			success:function(response)
			{
				$("#div_dtblfeedetails").html(response);
				
			},
			error:function()
			{
				toastr.error('Unable to process please contact support');
			}
		});
		
	
}


		


</script>


      
 