<?php

namespace App\Model;;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithMapping, WithHeadings
{
    public function collection()
    {
        return Order::latest()->get();
    }

    public function headings(): array
    {
        return [
            'customer_name',
            'user_id',
            'shipping_address',
            'shop_name',
            'shop_id',
            'area',
            'latitude',
            'longitude',
            'payment_type',
            'payment_status',
            'transaction_id',
            'ssl_status',
            'invoice_code',
            'grand_total',
            'discount',
            'total_vat',
            'total_labour_cost',
            'profit',
            'commission_calculated',
            'delivery_cost',
            'delivery_status',
            'view',

        ];
    }

    public function map($order): array
    {
        return [
            $order->user->name,
            $order->user_id,
            $order->shipping_address,
            $order->shop->name,
            $order->shop_id,
            $order->area,
            $order->latitude,
            $order->longitude,
            $order->payment_type,
            $order->payment_status,
            $order->transaction_id,
            $order->ssl_status,
            $order->invoice_code,
            $order->grand_total,
            $order->discount,
            $order->total_vat,
            $order->total_labour_cost,
            $order->profit,
            $order->commission_calculated,
            $order->delivery_cost,
            $order->delivery_status,
            $order->view,
        ];
    }
}
