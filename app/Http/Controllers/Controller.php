<?php

namespace App\Http\Controllers;

use App\Models\Organ;
use App\Models\OrganUser;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function time($time)
    {
        $vertaTime = new Verta($time);
        return $vertaTime->format('F d , Y');
    }
    public function time_topnav($time)
    {
        $vertaTime = new Verta($time);
        return $vertaTime->format('h:i:s Y/m/d');
    }

    public function time_index($time)
    {
        $vertaTime = new Verta($time);
        $now = new Verta();

        $diffSeconds = $now->diffSeconds($vertaTime);

        if ($diffSeconds < 60) {
            return "$diffSeconds ثانیه پیش";
        } elseif ($diffSeconds < 3600) {
            return floor($diffSeconds / 60) . " دقیقه پیش";
        } elseif ($diffSeconds < 86400) {
            return floor($diffSeconds / 3600) . " ساعت پیش";
        } else {
            return floor($diffSeconds / 86400) . " روز پیش";
        }
    }

    public function buying()
    {
        // return $request;
        $user = User::find(Auth::user()->id);
        $organ_id = OrganUser::where('user_id', $user->id)->first()->organ_id;

        $invoice = new Invoice();
        $invoice->amount(1000);
        $invoice->detail("خرید هزینه عضویت");

        $paymentId = md5(uniqid());
        $transaction = $user->transactions()->create([
            'payment_id' => $paymentId,
            'paid' => 1000,
            'invoice_details' => $invoice,
            'organ_id' => $organ_id,
        ]);
        $callbackUrl = route('payment.callback', ['paymentId' => $paymentId, 'organ_id' => $organ_id]);
        $payment = Payment::callbackUrl($callbackUrl);
        $payment->purchase($invoice, function ($driver, $transactionId) use ($transaction) {
            $transaction->transaction_id = $transactionId;
            $transaction->save();
        });
        return $payment->pay()->render();
        // return view('shahrie.shopping');
        // return redirect()->route('profile');
    }
    public function callback(Request $request)
    {
        if ($request->missing('paymentId')) {
            return redirect()->route('dashboard')->with('fail', 'پرداخت ناموفق بود');
        }
        $transaction = Transaction::where('payment_id', $request->paymentId)->first();
        if (empty($transaction)) {
            return redirect()->route('dashboard')->with('fail', 'پرداخت ناموفق بود');
        }
        try {
            $payment = Payment::amount($transaction->paid)->transactionId($transaction->transaction_id)->verify();
            $transaction->status = 2;
            $transaction->transaction_result = $payment;
            $transaction->save();

            $user = User::find(auth()->id());
            $organ = Organ::find($request->organ_id);
            $organ->status = 5;
            $organ->save();
            return redirect()->route('dashboard')->with('success', 'پرداخت موفق بود');
        } catch (\Exception $e) {
            $transaction->status = 3;
            $transaction->transaction_result = $e->getMessage();
            $transaction->save();
            return redirect()->route('dashboard')->with('fail', 'پرداخت ناموفق بود');
        }
    }
}
