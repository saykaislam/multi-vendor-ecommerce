<?php

namespace App\Http\Controllers\Admin;

use App\Model\Attribute;
use App\Model\Brand;
use App\Model\Category;
use App\Model\Product;
use App\Model\Subcategory;
use App\Model\SubSubcategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStaffs = User::where('user_type','staff')->count();
        $totalUsers = User::where('user_type','customer')->count();
        $totalCategories = Category::count();
        $totalSubCategories = Subcategory::count();
        $totalSubSubCategories = SubSubcategory::count();
        $totalBrands = Brand::count();
        $totalAttributes = Attribute::count();
        $totalProducts =  Product::count();
        $totalReqProducts =  Product::where('added_by','seller')->where('admin_permission',0)->count();
        //dd($totalBrands);
        return view('backend.admin.dashboard',
            compact('totalStaffs','totalBrands','totalUsers','totalCategories',
            'totalSubCategories','totalSubSubCategories','totalAttributes','totalProducts','totalReqProducts'
            ));
    }
}
