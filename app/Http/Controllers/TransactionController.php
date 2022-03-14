<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TripayService;

class TransactionController extends Controller
{
    public function show($reference)
    {
        $tripay = new TripayService();
        $detail = $tripay->detailTranscation($reference);
        return view('transaction.show',compact('detail'));
    }
    public function store(Request $request)
    {
        // request transaction in tripay
        $book = Book::find($request->book_id);
        $method = $request->method;
        
        $tripay = new TripayService();
        $transaction = $tripay->requestTransaction($method,$book);
        // create new data in transaction model
        $user = Auth::user();
        Transaction::create([
            'user_id'=>$user->id,
            'book_id'=>$book->id,
            'reference'=>$transaction->reference,
            'merchant_ref'=>$transaction->merchant_ref,
            'total_amount'=>$transaction->amount,
            'status'=>$transaction->status
        ]);
        
        return redirect()->route('transaction.show',[
            'reference' => $transaction->reference,
        ]);
    }
    
}
