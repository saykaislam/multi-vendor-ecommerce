<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Address;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:customer-list', ['only' => ['index']]);
        $this->middleware('permission:customer-edit', ['only' => ['profileShow','updateProfile','updatePassword']]);
        $this->middleware('permission:top-customer-list', ['only' => ['topRatedCustomers']]);

    }
    public function index()
    {
        $customerInfos = DB::table('users')
            ->where('user_type','=','customer')
            ->where('verification_code','!=',null)
            ->latest('created_at')
            ->get();
        $addresses = null;
//        $customerInfos = User::where('user_type','customer')->latest()->get();
        return view('backend.admin.customer.index',compact('customerInfos','addresses'));
    }
    public function search_area(Request $request){
        $name = $request->get('q');
        $area = Address::where('area', 'LIKE', '%'. $name. '%')->limit(5)->get();
        return $area;
    }
    public function areaWiseCustomer($area){
        $addresses = Address::where('area',$area)->latest()->get();
        return view('backend.admin.customer.index', compact('addresses'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
    public function profileShow($id)
    {
        $userInfo = User::find(decrypt($id));
        if($userInfo->view == 0){
            $userInfo->view = 1;
            $userInfo->save();
        }
        return view('backend.admin.customer.profile', compact('userInfo'));
    }
    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, [
            'name' =>  'required',
            'phone' => 'required|regex:/(01)[0-9]{9}/|unique:users,phone,'.$id,
            'email' =>  'required|email|unique:users,email,'.$id,
        ]);

        $user =  User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
        Toastr::success('Customer Profile Updated Successfully','Success');
        return redirect()->back();
    }
    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' =>  'required|confirmed|min:6',
        ]);

        $user =  User::find($id);
        $user->password = Hash::make($request->password);
        $user->save();
        Toastr::success('Customer Password Updated Successfully','Success');
        return redirect()->back();
    }
    public function topRatedCustomers(){
        $customers = DB::table('users')
            ->join('orders','users.id','=','orders.user_id')
            ->select('orders.user_id',DB::raw('COUNT(orders.id) as total_orders'))
            ->groupBy('orders.user_id')
            ->orderBy('total_orders', 'DESC')
            ->get();
//        dd($customers);
        return view('backend.admin.top_customers.index',compact('customers'));
    }
    public function banCustomer($id) {
        $customer = User::findOrFail($id);
        $customer->banned = 1;
        $customer->save();
        Toastr::success('This Customer has been Baned', 'Success');
        return redirect()->back();
    }
}
