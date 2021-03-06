<?php

namespace App\Http\Livewire\User;

use App\Models\Order;
use App\Models\Sale;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserOrderDetailsComponent extends Component
{
    public $order_id;

    public function mount($order_id){
        $this->order_id = $order_id;
    }
    public function cancelOrder(){
        $orders = Order::find($this->order_id);
        $orders->status = "canceled";
        $orders->canceled_date = DB::raw('CURRENT_DATE');
        $orders->save();
        session()->flash('order_canceled','User Cancel this order successfully');
    }
    public function render()
    {
        $sale = Sale::find(1);
        $orders = Order::where('user_id',Auth::user()->id)->where('id',$this->order_id)->first();
        return view('livewire.user.user-order-details-component',['orders' => $orders,'sale' => $sale])->layout('layouts.base');
    }
}
