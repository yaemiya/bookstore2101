<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Purchase extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $order_date, $carts, $sub_total, $total_quantity)
    {
        $this->name = $name;
        $this->order_date = $order_date;
        $this->carts = $carts;
        $this->sub_total = $sub_total;
        $this->total_quantity = $total_quantity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to('ya.ay110177@gmail.com')  // 送信先アドレス
        ->subject('【BOOKSTOREアプリテスト】注文完了のお知らせ') // 件名
        ->view('mail') // 本文
        ->with(['name' => $this->name, 'order_date' => $this->order_date, 'carts' => $this->carts, 'sub_total' => $this->sub_total, 'total_quantity' => $this->total_quantity]); // 本文に送る値
    }
}
