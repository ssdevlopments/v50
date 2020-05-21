<?php

namespace App\Http\Controllers\School\Fee;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use DB;
use Session;

class dueController extends Controller
{
	public $institute_code;
	public $session_code;
	
	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			
			// fetch session and use it in entire class with constructor
			$this->institute_code = Session::get('institute_code');
			$this->session_code = Session::get('session_code');
			$this->user_code = Session::get('institute_code').'_ADMIN001';// Session::get('user_code');

			return $next($request);
		});
        
    }
	
	public function dueCreationListPage()
	{
		return view('school.fee.due_list_page');
	}
	
	public function SelectAll(Request $request)
	{
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		
		//$courseFilter = $request->input('courseFilter');
		//$classFliter = $request->input('classFilter');
		$admission_number = $request->input('admission_number');
		
		$limit = $request->input('iDisplayLength');
		$start = $request->input('iDisplayStart');
		$search = strtoupper($request->input('sSearch'));
		
		$output = array("aaData" => array());
		
		$totals = 0;
		
		
		$admission_number = '10504';
		//echo($admission_number);
		
		/*SELECT A.student_code,total_due,total_paid FROM
			(
			SELECT  student_code,SUM(due)AS total_due
			FROM 
			 student_fee_detail A  
			INNER JOIN dim_time B ON A.period = B.time_id
			 WHERE A.student_code = '0700652019-20_APSHIS'
			 AND calendar_date <= DATE(NOW())
			 GROUP BY student_code
			 
			 ) A
			 LEFT JOIN(
			 
				SELECT student_code,SUM(amount_paid)AS total_paid
				FROM student_payment_detail A  
				WHERE A.student_code = '0700652019-20_APSHIS'
				GROUP BY student_code
			)AS D ON A.student_code = D.student_code 

			 */
		
		// GET THE student Details
		$student_data = DB::select("select admission_no,student_name,course_code,class_code,category_1,
				category_2,student_code 
				from k12.ac_student_master
				where admission_no = '$admission_number'
				AND institute_code = '$institute_code'
				AND session_code = '$session_code'"); 
				
				
		//print_r($student_data);	
		
		$html = '<table class="table table-striped table-bordered" id="feedetails" width="100%">
				<thead>
					<tr >
						<th  class="text-center table_bg_header1">Sl No.</th>
						<th class="text-center table_bg_header1">AdmNo</th>
						<th class="text-center table_bg_header1">Name</th>
						<th class=" table_bg_header1">Course</th>
						<th class="table_bg_header1">Class</th>
						<th class="text-center table_bg_header1">Cat-1</th>
						<th class="text-center table_bg_header1">Cat-2</th>
						<th class="text-center table_bg_header1">Due</th>
						<th class="text-center table_bg_header1">Action</th>
					</tr>
				</thead>
				<tbody>';
				$slno =1;
				foreach($student_data AS $data)
				{
					/*echo('<pre>');
					print_r($data);die();*/
					$html .= '<tr>';
					$html .= '<td>'.$slno.'</td>';
					$html .= '<td>'.$data->admission_no.'</td>';
					$html .= '<td>'.$data->student_name.'</td>';
					$html .= '<td>'.$data->course_code.'</td>';
					$html .= '<td>'.$data->class_code.'</td>';
					$html .= '<td>'.$data->category_1.'</td>';
					$html .= '<td>'.$data->category_2.'</td>';
					$html .= '<td>Due</td>';
					$html .= "<td><a href=\"javascript:void(0)\" onclick=\"window.open('http://localhost/v50/school/fee/due/creation/debitCreate?student_code=".$data->student_code."','winview','width=1000,height=700,toolbar=0,status=0,menubar=0,resizable=1,scrollbars=1').focus();\"  title=\"Create\" class=\"btn btn-info custombtn tooltips\">Create</a>&nbsp;&nbsp;<a href=\"javascript:void(0)\" onclick=\"window.open('http://localhost/v50/school/fee/due/creation/debitmodify?student_code=".$data->student_code."','winview','width=1000,height=700,toolbar=0,status=0,menubar=0,resizable=1,scrollbars=1').focus();\"  title=\"View / Edit\" class=\"btn btn-info custombtn tooltips\" >EDIT</i></a></td>";
					$html .= '</tr>';
					
					$slno++;
				}	
					
		$html .='</tbody>
			</table>';
		echo($html);		
				
		
	}
	
	public function getDebitModifyData(Request $request)
	{
		$student_code = $request->student_code;
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		
		
		$fee_data = DB::select( "SELECT student_code,C.account_code,C.account_name,due
			FROM 
			 fee.student_fee_detail A  
			LEFT JOIN fee.dim_time B ON A.period = B.time_id
			LEFT JOIN fee.account_master C ON C.account_code = A.account_code
			 WHERE A.student_code = '1718882019-20_APSHIS'
			 AND period = '01012020'");
		
		
		
		$html = '';
		$html = '<form  name="frm_dueModify" id="frm_dueModify">
				<table class="table table-bordered" id="dtblfeedetails" style="width: -moz-available;" border= 1>
				<thead>
					<tr style="background-color: #3c8dbc;">
						<th height="26" class="text-center table_bg_header1">Sl No.</th>
						<th class="text-center table_bg_header1">Account Name</th>
						<th class="text-center table_bg_header1">Due</th>
					</tr>
				</thead>
				<tbody>';
				$sl_no = 1;
				foreach($fee_data AS $data)
				{
					$html .= '<tr>';
					$html .= '<td>'.$sl_no.'</td>';
					$html .= '<td>'.$data->account_name.'</td>';
					$html .= '<td><input type="text-box" name="'.$data->account_code.'" id="'.$data->account_code.'" value="'.$data->due.'" ></td>';
					$html .= '</tr>';
					
					$sl_no++;
				}	
				
				$html .= '</tbody>
				</table>';
				
				$html .= '</br>
				
				<div class="form-group">
								<input type="hidden" name="student_code" id="student_code" value= "1718882019-20_APSHIS" >
								<input type="hidden" name="period" id="period" value= "01012020" >
								<label class="col-sm-1 col-sm-offset-3 control-label" for="" style="text-align:left;font-size:16px;">Mode:</label>
								<div class="col-sm-12">
									<select class="form-control" name="cmbMode" id="cmbMode">
										<option value="Cash" selected="">Cash</option>
										<option value="Bank">Bank</option>
									</select>
									<label class="col-sm-1 control-label " for="" style="font-size:16px;text-align:left;">Date:</label>
									<input type="text" class="form-control tooltips" id="txtDate" name="txtDate" placeholder="Pick Date" title="Pick Date" value="20-07-2019">
									<button type="button" class="btn btn-info custombtn" id="debitaddbtn" name="debitaddbtn" style="background-color: brown;align:right;" onclick="submit_data()"><b>Submit</b></button>
								
								</div>
							</div></form>';
		echo($html);
	}
	
	public function debitCreate(Request $request)
	{
		return view('school.fee.debitCreate');
	}
	
	public function debitmodify(Request $request)
	{
		return view('school.fee.debitmodify');
	}
	
	
	
	public function getStudentInfo(Request $request)
	{
		$student_code = $request->student_code;
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		
			$student_data = DB::select("select admission_no,student_name,A.course_code,A.class_code,category_1,
				category_2,A.student_code ,B.course_name,C.class_name
				
				FROM k12.ac_student_master A
				
				INNER JOIN k12.ac_course_master B ON  A.course_code = B.course_code
				INNER JOIN k12.ac_class_master  C ON A.class_code = C.class_code
				
				where A.student_code = '$student_code'
				AND A.institute_code = '$institute_code'
				AND A.session_code = '$session_code'");
				
			return response()->json($student_data);
	}
	
	public function getDate(Request $request)
	{
		$student_code = $request->student_code;
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		
		$calendar_date_data = DB::select("SELECT DISTINCT 
				 calendar_date,period
				FROM fee.student_fee_detail,fee.dim_time
				WHERE student_fee_detail.period = dim_time.time_id
				AND student_code = '1718882019-20_APSHIS'
			
				AND institute_code = '$institute_code'
				AND session_code = '$session_code'
				AND record_status = 1
				ORDER BY calendar_date DESC");
				
			return response()->json($calendar_date_data);
		
	}
	
	public function submitModifyDue(Request $request)
	{
		
		
		$due_array = $request->input();
		
		 unset($due_array['student_code']);
		 unset($due_array['period']);
		 unset($due_array['cmbMode']);
		 unset($due_array['txtDate']);
		 unset($due_array['_token']);
		echo('<pre>');
		print_r($due_array);
		
		
		/*$account_code = $row['account_code'];
		$amount = $_POST['amount'][$i];
		
		$query="UPDATE student_fee_detail
				SET due = '$amount',
				updated_by = '$user',
				updated_on = NOW()
				WHERE period = '$due_date'
				AND student_code = '$student_code'
				AND class_code = '$cc_code'
				AND account_code = '$account_code'
				AND institute_code = '$institute_code'
				AND session_code = '$session_code'
				AND record_status = 1";*/
	}
	
	public function getDebitCreateData(Request $request){
	
		$student_code = $request->student_code;
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		
		
		$fee_data = DB::select( "
			SELECT SUM(due) As due,A.account_code,C.account_name
			FROM 
			 fee.student_fee_detail A  
			LEFT JOIN fee.dim_time B ON A.period = B.time_id
			LEFT JOIN fee.account_master C ON C.account_code = A.account_code
			 WHERE A.student_code = '1718882019-20_APSHIS'
			 -- AND calendar_date:: <=  NOW()::date
			 GROUP BY A.account_code,C.account_name");
		
		
		
		$html = '';
		$html = '
			
			<table class="table table-bordered" id="dtblfeedetails" style="width: -moz-available;" border= 1>
				<thead>
					<tr style="background-color: #3c8dbc;">
						<th height="26" class="text-center table_bg_header1">Sl No.</th>
						<th class="text-center table_bg_header1">Account Name</th>
						<th class="text-center table_bg_header1">Amount</th>
						<th class=" table_bg_header1">Modify</th>
					</tr>
				</thead>
				<tbody>';
				$sl_no = 1;
				foreach($fee_data AS $data)
				{
					$html .= '<tr>';
					$html .= '<td>'.$sl_no.'</td>';
					$html .= '<td>'.$data->account_name.'</td>';
					$html .= '<td>'.$data->due.'</td>';
					$html .= "<td><a href=\"javascript:void(0)\"','winview','width=1000,height=700,toolbar=0,status=0,menubar=0,resizable=1,scrollbars=1').focus();\"  title=\"Modify\" class=\"btn btn-info custombtn tooltips\">Modify</a></td>";
					$html .= '</tr>';
					
					$sl_no++;
				}	
				
				$html .= '</tbody>
				</table>';
				
				$html .= '</br><div class="btngroup">
										<button type="submit" class="btn btn-info custombtn" id="debitaddbtn" name="debitaddbtn" style="background-color: brown;align:right;"><b>Submit</b></button>
									</div>';
		echo($html);
	}
	
	public function lateFeeSetupPagechangeStatus(Request $request)
	{
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		$user_code = $this->user_code;
		
		$unique_code = $request->input('unique_code');
		$frequency = $request->input('frequency');
		$status = $request->input('status');
		
		$values = explode(',',$unique_code);
		$course_code = $values[0];
		$class_code = $values[1];
		$account_code = $values[2];
		
		//CHECK EXIST OR NOT
		$chkQuery = "SELECT COUNT(*) AS cnt FROM fee.late_fee_setup 
						WHERE 
					course_code = '$course_code' 
					AND class_code = '$class_code' 
					AND account_code = '$account_code' 
					AND frequency = '$frequency'
					AND institute_code = '$institute_code' 
					AND session_code = '$session_code'"; 
		$results = DB::select($chkQuery);
		$chkcnt = count($results);
		
		if($chkcnt > 0)
		{
			$query = "UPDATE fee.late_fee_setup 
						SET 
					STATUS = '$status',
					frequency = '$frequency',
		  			updated_by = '$user_code',
		  			updated_on = NOW()
		  			WHERE 
		  				course_code = '$course_code' 
		  				AND class_code = '$class_code' 
			  			AND account_code = '$account_code' 
			  			AND frequency = '$frequency'
						AND institute_code = '$institute_code' 
						AND session_code = '$session_code'";
		}
		else
		{
			$query = "INSERT INTO fee.late_fee_setup
					(course_code,class_code,account_code,STATUS,frequency,institute_code,session_code,created_by,created_on)
		  			VALUES ('$course_code','$class_code','$account_code','$status','$frequency',
		  			'$institute_code','$session_code','$user_code',NOW())";
		}
		//echo $query;exit;
		$results = DB::query($query);
		
		if($results)
		{
            $output['dbStatus'] = 'SUCCESS';
            $output['dbMessage'] = 'Record has been '.$status;
        }
        else
        {
            $output['dbStatus'] = 'FAILURE';
            $output['dbMessage'] = 'OOPS! Someting Went Wrong on insert Operation.';
        }
		
		return response()->json($output);
	}
	
	public function lateFeeSetupPagegetLateFeeStatus(Request $request)
	{
		$institute_code = $this->institute_code;
		$session_code = $this->session_code;
		
		$html = '';
		$unique_code = $request->input('unique_code');
		$x = explode(",",$unique_code);
		$course_code = $x[0];
		$class_code = $x[1];
		$account_code = $x[2];
		$frequency = $request->input('frequency');
		$x = explode("_",$session_code);
		$academic_year = $x[0];
		
		/*SELECT A.id, period, pay_by_date, amount, amount_periodicity, calc_rule, value_in,
				B.code_desc AS amount_periodicity_desc,C.code_desc AS calc_rule_desc, 
				D.code_desc AS value_in_desc,
				CASE WHEN is_struck_off = 0 THEN 'NO' ELSE 'YES' END AS is_struck_off
			FROM fee.late_fee_amount A
				LEFT JOIN admin.code_desc B ON A.amount_periodicity::text = B.code
				LEFT JOIN admin.code_desc C ON A.calc_rule = C.code
				LEFT JOIN admin.code_desc D ON A.value_in = D.code
				WHERE 
				course_code = 'GEN_2019-20_APSHIS'
					AND class_code = 'II_2019-20_APSHIS'
					AND account_code = '51001_2019-20_APSHIS'
					AND A.institute_code= 'APSHIS'
					AND A.session_code = '2019-20_APSHIS'
			ORDER BY period, pay_by_date*/
			
		$query = "SELECT A.id, period, pay_by_date, amount, amount_periodicity, calc_rule, value_in,
				B.code_desc AS amount_periodicity_desc,C.code_desc AS calc_rule_desc, 
				D.code_desc AS value_in_desc,
				CASE WHEN is_struck_off = 0 THEN 'NO' ELSE 'YES' END AS is_struck_off
			FROM fee.late_fee_amount A
				LEFT JOIN admin.code_desc B ON A.amount_periodicity = B.code
				LEFT JOIN admin.code_desc C ON A.calc_rule = C.code
				LEFT JOIN admin.code_desc D ON A.value_in = D.code
				WHERE 
				course_code = '$course_code'
					AND class_code = '$class_code'
					AND account_code = '$account_code'
					AND A.institute_code= '$institute_code'
					AND A.session_code = '$session_code'
			ORDER BY period, pay_by_date";
		$res = DB::select($query);
		
		$output = array("aaData" => array());
		$allrows = array();
		foreach($res as $row)
		{
			$allrows[$row->period][] = $row;
		}
		
		if($frequency == 'Quarterly')
		{
			//get timeid from dim_time for quarters
			
			/*$query = "SELECT time_id, academic_quarter 
				FROM dim_time 
				WHERE academic_year = :academic_year
				GROUP BY academic_quarter
				ORDER BY calendar_date ";
			$res=$pdo->prepare($query);
			$res->bindParam(':academic_year',$academic_year);
			$res->execute();
			//$result = mysqli_query($con,$query ) or die( 'MySQL Error: ' . mysqli_error($con) );
			foreach($res->fetchAll() as $row)
			{
				$allquarters[] = $row;
			}
			mysqli_free_result($result);*/
			
			$query = "SELECT DISTINCT time_id, academic_quarter 
				FROM fee.dim_time 
				WHERE academic_year = '$academic_year' AND academic_quarter IN('Q1','Q2','Q3','Q4')
				-- GROUP BY academic_quarter
				-- ORDER BY calendar_date";
			$res = DB::select($query);
			foreach($res as $row)
			{
				$allquarters[] = $row;
			}
			
			echo '<pre>';
			print_r($allquarters);
			exit;
			
			$html .= '<table class="table table-bordered" style="width:100%">';
			$html .= '<tr>';
			$html .= '<th>Quarter</th>';
			$html .= '</tr>';
			foreach($allquarters as $quarter_row)
			{
				$html .= '<tr><th>';
				$html .= $quarter_row['academic_quarter'].' <button type="button" class="btn btn-primary btn-sm" onclick="add_amount_setup(\''.$quarter_row['time_id'].'\',\''.$quarter_row['academic_quarter'].'\');"><i class="fa fa-plus"></i></button>';
				if(isset($allrows[$quarter_row['time_id']]) && count($allrows[$quarter_row['time_id']]) > 0)
				{
					$html .= '<table class="table table-bordered" style="width:100%">';
					$html .= '<tr>';
					$html .= '<td>Date</td><td>Amount</td><td>Periodicity</td><td>Calc Rule</td><td>Value In</td><td>Struck Off</td><td>Action</td>';
					$html .= '</tr>';
					foreach($allrows[$quarter_row['time_id']] as $row)
					{
						$html .= '<tr>';
						$html .= '<td>'.date("d-M-Y",strtotime($row['pay_by_date'])).'</td>';
						$html .= '<td>'.$row['amount'].'</td>';
						$html .= '<td>'.$row['amount_periodicity_desc'].'</td>';
						$html .= '<td>'.$row['calc_rule_desc'].'</td>';
						$html .= '<td>'.$row['value_in_desc'].'</td>';
						$html .= '<td>'.$row['is_struck_off'].'</td>';
						$html .= '<td><button class="btn btn-info btn-xs" type="button" onclick="editAmount(\''.$quarter_row['time_id'].'\',\''.$quarter_row['academic_quarter'].'\','.$row['id'].',\''.date("d-m-Y",strtotime($row['pay_by_date'])).'\','.$row['amount'].',\''.$row['amount_periodicity'].'\',\''.$row['calc_rule'].'\',\''.$row['value_in'].'\',\''.$row['is_struck_off'].'\');"><i class="fa fa-edit"></i></button> <button class="btn btn-danger btn-xs" type="button" onclick="deleteAmount('.$row['id'].');"><i class="fa fa-trash"></i></button></td>';
						$html .= '</tr>';
					}
					$html .= '</table>';
				}
				$html .= '</th></tr>';
			}
			
			$html .= '</table>';
		}
		echo $html;exit;
	}
}

