<?php

namespace App\Http\Controllers;
use DB;
use URL;
use Auth;
use Session;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Gate;

use App\User;
use App\tbl_settings;
use App\tbl_gatepasses;
use App\tbl_gatepasses_images;

use App\Gatepass;
use App\Service;
use App\Setting;
use App\BranchSetting;

use App\Http\Requests\StoreGatepassAddEditFormRequest;

class Getpasscontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//gatepass list
    public function index()
	{
		$currentUser = User::where([['soft_delete',0],['id','=',Auth::User()->id]])->orderBy('id','DESC')->first();
		$adminCurrentBranch = BranchSetting::where('id','=',1)->first();
		if (!isAdmin(Auth::User()->role_id)) 
		{			
			if (getUsersRole(Auth::User()->role_id) == "Customer") 
			{
				//$gatepass = Gatepass::where('customer_id','=',Auth::User()->id)->orderby('id','DESC')->get();
				$gatepass = Service::
									join('tbl_gatepasses','tbl_services.job_no','=','tbl_gatepasses.jobcard_id')
									->where('tbl_services.customer_id', Auth::User()->id)
									->orderby('tbl_gatepasses.id','DESC')->get();
			}
			elseif (getUsersRole(Auth::User()->role_id) == "Employee") 
			{
				$gatepass = Service::
									join('tbl_gatepasses','tbl_services.job_no','=','tbl_gatepasses.jobcard_id')
									->where([['tbl_services.assign_to', Auth::User()->id], ['tbl_services.branch_id',$currentUser->branch_id]])
									->orderby('tbl_gatepasses.id','DESC')->get();
			}
			elseif (getUsersRole(Auth::user()->role_id) == 'Support Staff' || getUsersRole(Auth::user()->role_id) == 'Accountant' || getUsersRole(Auth::user()->role_id) == 'Branch Admin') {
				//$gatepass = Gatepass::orderby('id','DESC')->get();
				$gatepass = Service::
									join('tbl_gatepasses','tbl_services.job_no','=','tbl_gatepasses.jobcard_id')
									->where('tbl_services.branch_id',$currentUser->branch_id)
									->orderby('tbl_gatepasses.id','DESC')->get();
			}
		}
		else
		{
			//$gatepass = Gatepass::orderby('id','DESC')->get();
			$gatepass = Service::
								join('tbl_gatepasses','tbl_services.job_no','=','tbl_gatepasses.jobcard_id')
								->where('tbl_services.branch_id',$adminCurrentBranch->branch_id)
								->orderby('tbl_gatepasses.id','DESC')->get();
		}

		return view('gatepass.list',compact('gatepass')); 
	}
	
	//gatepass add form
	public function addgatepass()
	{
		$characters = '0123456789';
		$code =  'G'.''.substr(str_shuffle($characters),0,6);
    	
		$customer=DB::table('users')->where('role','=','Customer')->get()->toArray();
		$vehicle=DB::table('tbl_vehicles')->get()->toArray();
		
		$getpass=DB::table('tbl_gatepasses')->get()->toArray();
		
		$job_no=array();
		
		foreach($getpass as $getpas){
			$job_no[]=$getpas->jobcard_id;			
		}


		$currentUser = User::where([['soft_delete',0],['id','=',Auth::User()->id]])->orderBy('id','DESC')->first();
		$adminCurrentBranch = BranchSetting::where('id','=',1)->first();
		if (isAdmin(Auth::User()->role_id)) 
		{
			//$jobno=DB::table('tbl_invoices')->where([['job_card','like','J%')->whereNotIn('job_card',$job_no)->get()->toArray();
			$jobno = Service::
						join('tbl_invoices','tbl_services.job_no','=','tbl_invoices.job_card')
						->where('tbl_invoices.job_card','like','J%')
						->where('tbl_services.branch_id', '=', $adminCurrentBranch->branch_id)
						->whereNotIn('tbl_invoices.job_card',$job_no)->get();
		}
		elseif (getUsersRole(Auth::user()->role_id) == 'Customer') {
			$jobno=DB::table('tbl_invoices')->where('job_card','like','J%')->whereNotIn('job_card',$job_no)->get()->toArray();
		}
		else
		{
			$jobno = Service::
						join('tbl_invoices','tbl_services.job_no','=','tbl_invoices.job_card')
						->where('tbl_invoices.job_card','like','J%')
						->where('tbl_services.branch_id', '=', $currentUser->branch_id)
						->whereNotIn('tbl_invoices.job_card',$job_no)->get();
						//->orderby('tbl_invoices.id','DESC')->get();
		}

		return view('gatepass.gatepass',compact('customer','vehicle','code','jobno'));
	}
	
	//gatepass data to show for customer
	public function gatedata(Request $request)
	{
		$jobcard = $request->jobcard;
		
		$gatepass=DB::select("SELECT * FROM `tbl_services` 
        		INNER JOIN users ON tbl_services.customer_id = users.id 
        		INNER JOIN tbl_vehicles ON tbl_services.vehicle_id = tbl_vehicles.id 
				INNER JOIN tbl_jobcard_details ON tbl_services.id = tbl_jobcard_details.service_id 
				INNER JOIN tbl_vehicle_types ON tbl_vehicles.vehicletype_id = tbl_vehicle_types.id where tbl_services.job_no='$jobcard'");
         
		$getdata = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($gatepass), ENT_NOQUOTES));
		echo $getdata;
	}
	
	//gatepass store
	public function store(Request $request){

		/*$this->validate($request, [          
		  // 'out_date'  => 'required|date|after:today',
	    ]);*/ 
		 
		$jobcard = $request->jobcard;
		if(getDateFormat()== 'm-d-Y')
		{
			$out_date = date('Y-m-d H:i:s',strtotime(str_replace('-','/',$request->out_date)));
		}
		else
		{
			$out_date = date('Y-m-d H:i:s',strtotime($request->out_date));
		}
		$jobservice = DB::table('tbl_services')->where('job_no','=',$jobcard)->first();
		$c_id = $jobservice->customer_id;
		$v_id = $jobservice->vehicle_id;
		
		$gatepass = new Gatepass;
		$gatepass->jobcard_id = $jobcard;
		$gatepass->gatepass_no = $request->gatepass_no;
		$gatepass->customer_id = $c_id;
		$gatepass->vehicle_id = $v_id;
		$gatepass->service_out_date = $out_date;
		$gatepass->ser_pro_status = 1;
        $gatepass->create_by = Auth::user()->id;
		$gatepass->save();

		$gatepass = DB::table('tbl_gatepasses')->orderBy('id','desc')->first();
   		$id = $gatepass->id;

		$image = $request->image;
		if(!empty($image))
		{
			$files = $image;

			foreach($files as $file)
			{
				$filename = $file->getClientOriginalName();
				$file->move(public_path().'/gatepass/', $file->getClientOriginalName());
				$images = new tbl_gatepasses_images;
				$images->gatepass_id = $id;
				$images->image = $filename;
				$images->save();
			}
		}

		return redirect('/gatepass/list')->with('message','Successfully Submitted');
	}
	
	//gatepass delete
	public function delete($id)
	{
		$gatepass=DB::table('tbl_gatepasses')->where('id','=',$id)->delete();
		return redirect('/gatepass/list')->with('message','Successfully Deleted');
	}
	
	//gatepass edit
	public function edit($id)
	{	

		$currentUser = User::where([['soft_delete',0],['id','=',Auth::User()->id]])->orderBy('id','DESC')->first();
	    $adminCurrentBranch = BranchSetting::where('id','=',1)->first();
		if (isAdmin(Auth::User()->role_id)) 
		{
			$jobno = Service::
						join('tbl_invoices','tbl_services.job_no','=','tbl_invoices.job_card')
						->where('tbl_invoices.job_card','like','J%')
						->where('tbl_services.branch_id', '=', $adminCurrentBranch->branch_id)->get();
						//->whereNotIn('tbl_invoices.job_card',$job_no)->get();
		}
		elseif (getUsersRole(Auth::user()->role_id) == 'Customer') {
			$jobno=DB::table('tbl_invoices')->where('job_card','like','J%')->get()->toArray();
		}
		else
		{
			$jobno = Service::
						join('tbl_invoices','tbl_services.job_no','=','tbl_invoices.job_card')
						->where('tbl_invoices.job_card','like','J%')
						->where('tbl_services.branch_id', '=', $currentUser->branch_id)->get();
		}

		$gatepass=DB::table('tbl_services')
									->join('users','tbl_services.customer_id','=','users.id')
									->join('tbl_vehicles','tbl_services.vehicle_id','=','tbl_vehicles.id')
									->join('tbl_jobcard_details','tbl_services.id','=','tbl_jobcard_details.service_id')
									->join('tbl_vehicle_types','tbl_vehicles.vehicletype_id','=','tbl_vehicle_types.id')
									->join('tbl_gatepasses','tbl_services.job_no','=','tbl_gatepasses.jobcard_id')
									->where('tbl_gatepasses.id','=',$id)->first();
			
		
		$images1=DB::table('tbl_gatepasses_images')->where('gatepass_id','=',$id)->get()->toArray();
		
		return view('gatepass.edit',compact('gatepass','jobno','images1'));
	}
	
	public function deleteImages(Request $request)
	{
		$id = $request->delete_image;
		$image = DB::table('tbl_gatepasses_images')->where('id','=',$id)->delete();
	}
	
	//gatepass update
	public function upadte(Request $request,$id)
	{
		$this->validate($request, [
		  // 'out_date'  => 'required|date|after:today',
	      ]);
		$jobcard = $request->jobcard;
		if(getDateFormat()== 'm-d-Y')
		{
			$out_date=date('Y-m-d H:i:s',strtotime(str_replace('-','/',$request->out_date)));
		}
		else
		{
			$out_date=date('Y-m-d H:i:s',strtotime($request->out_date));
		}
		$jobservice=DB::table('tbl_services')->where('job_no','=',$jobcard)->first();
		$c_id=$jobservice->customer_id;
		$v_id=$jobservice->vehicle_id;
		
		$gatepass=Gatepass::find($id);
		$gatepass->jobcard_id=$jobcard;
		$gatepass->gatepass_no=$request->gatepass_no;
		$gatepass->customer_id=$c_id;
		$gatepass->vehicle_id=$v_id;
	
		$gatepass->service_out_date=$out_date;
		$gatepass->ser_pro_status = 1;
        $gatepass->create_by = Auth::user()->id;
		$gatepass->save();


		// $image = $request->image;
		// if(!empty($image))
		// {
			$files = explode(',', session('post_vehicle_image')); //$image;

			foreach($files as $file)
			{
				// $filename = $file->getClientOriginalName();
				// $file->move(public_path().'/gatepass/', $file->getClientOriginalName());
				$images = new tbl_gatepasses_images;
				$images->gatepass_id = $id;
				$images->image = $file;
				$images->save();
			}
		// }
		return redirect('/gatepass/list')->with('message','Successfully Updated');
	}
	
	public function vehicle_images(Request $request)
    {
        $image = $request->file('file');
        $imageName = $image->getClientOriginalName();
        $image->move(public_path('gatepass'),$imageName);
        
		$images = Session::get('post_vehicle_image');
		$imageName = $images ? $imageName .','.$images : $imageName;
        
        Session::put('post_vehicle_image', $imageName);
		echo session('post_vehicle_image'); 
    }
	
	//gatepass modal 
	public function gatepassview(Request $request)
	{
		$getpassid = $request->getpassid;

		$getpassdata = Gatepass::
						join('users','users.id','=','tbl_gatepasses.customer_id')
						->join('tbl_vehicles','tbl_gatepasses.vehicle_id','=','tbl_vehicles.id')
						->join('tbl_services','tbl_gatepasses.jobcard_id','=','tbl_services.job_no')
						->select('tbl_gatepasses.*','tbl_services.service_date','tbl_vehicles.modelname','users.name','users.lastname')
						->where('jobcard_id',$getpassid)->first();
						
		$image = DB::table('tbl_gatepasses_images')->where('gatepass_id','=',$getpassdata->id)->get()->toArray();
		if(!empty($image))
		{
			foreach ($image as $images)
			{
				$image_name[] = URL::to('/public/gatepass/'.$images->image);
			}
		}
		else
		{
			$image_name[] = URL::to('/public/gatepass/avtar.png');
		}
		$available = json_encode($image_name);
		$setting = Setting::first();
						
		$html = view('gatepass.getpassmodel')->with(compact('getpassid','getpassdata','setting','available'))->render();

		return response()->json(['success' => true, 'html' => $html]);
	}
	
}	
