<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SellerExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return User::where('user_type','seller')->where('verification_code','!=',null)->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'shop_name',
            'email',
            'phone',
            'verification_status',
            'admin_to_pay',
            'seller_will_pay_admin',
            'commission',
            'bank_name',
            'bank_acc_name',
            'bank_acc_no',
            'bank_routing_no',
            'bank_payment_status',
            'nid_number',
        ];
    }

    public function map($seller): array
    {
        return [
            $seller->id,
            $seller->name,
            $seller->shop->name,
            $seller->email,
            $seller->phone,
            $seller->seller->verification_status,
            $seller->seller->admin_to_pay,
            $seller->seller->seller_will_pay_admin,
            $seller->seller->commission,
            $seller->seller->bank_name,
            $seller->seller->bank_acc_name,
            $seller->seller->bank_acc_no,
            $seller->seller->bank_routing_no,
            $seller->seller->bank_payment_status,
            $seller->seller->nid_number,
        ];
    }

}
