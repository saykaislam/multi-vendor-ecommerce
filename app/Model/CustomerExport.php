<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomerExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return User::where('user_type','customer')->where('verification_code','!=',null)->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'email',
            'phone',
            'balance',
            'referral_code',
            'referred_by',
        ];
    }

    public function map($customer): array
    {
//        $default_address = Address::where('user_id',$customer->id)->where('set_default',1)->first();
//        dd($default_address->address);
        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone,
            $customer->balance,
            $customer->referral_code,
            $customer->referred_by,

        ];
    }
}
