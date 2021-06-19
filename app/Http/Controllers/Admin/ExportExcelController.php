<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\CustomerExport;
use App\Model\OrderExport;
use App\Model\ProductsExport;
use App\Model\SellerExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportExcelController extends Controller
{
    public function exportSellerProducts(){
        return Excel::download(new ProductsExport(), 'all_seller_products.xlsx');
    }
    public function exportOrders(){
        return Excel::download(new OrderExport(), 'all_orders.xlsx');
    }
    public function exportSeller(){
        return Excel::download(new SellerExport(), 'all_sellers.xlsx');
    }
    public function exportCustomer(){
        return Excel::download(new CustomerExport(), 'all_customers.xlsx');
    }




}
