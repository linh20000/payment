    /*
    *  using controller 
    *
    *  use Service\Payment\Momo\Processors\ATM as ATMMOMO;
    *  use Service\Payment\Momo\Processors\WalletRef as WALLETMOMO;
    *
    *
    *  use Service\Payment\Vnpay\Processors\ATM as ATMVNPAY;
    *  use Service\Payment\Vnpay\Processors\Wallet as WALLETVNPAY;
    *  
    *  use Service\Payment\Momo\Processors\ATMRefund as REFUNDATMMOMO;
    *  use Service\Payment\Momo\Processors\WalletRef as REFUNDWALLETMOMO;
    *
    *  
    *  use Service\Payment\Momo\Processors\Log as ProcessorsLogMOMO;
    *  use Service\Payment\Vnpay\Processors\Log as ProcessorsLogVNPAY;
    *
    *
    */


    /*
    *  command line
    *   using Auth laravel 
    *   composer require laravel/ui --dev
    *   php artisan ui vue --auth
    *   npm install
    *   npm run dev
    *   php artisan vendor:publish --tag=config-api
    *   php artisan migrate 
    *  
    */






    /**
    * wallet momo
    */
    $data = WALLETMOMO::process([
        'amount'=> $request->amount,   // int
        'returnUrl' => route('result')  // url
        'data'=>$request->all(),       // data
    ]);
    return Redirect::to($data->getPayUrl());

    /**
    *  atm momo
    */
    $data = ATMMOMO::process([
        'amount'=> $request->amount,      // int
        'returnUrl' => route('result')   // url
        'data'=>$request->all(),          // data
    ]);
    return Redirect::to($data);

    /**
    * refund momo atm
    */
    $data = REFUNDATMMOMO::process([
        'amount'=> 20000,          // int
        'transId'=>'3028392073',   // transid where db
    ]);
    return $data;

    /**
    * refund momo wallet
    */
    $data = REFUNDWALLETMOMO::process([
        'amount'=> 20000,          //int
        'transId'=>'3028392073',  // transid where db 
    ]);
    return $data;

    /**
    * wallet vnpay
    */
    $data = WALLETVNPAY::process([ 
        'amount'=> $request->amount,       // int
        'returnUrl' => route('result')    // url
    ]);
    return Redirect::to($data);

    /*
    * atm vnpay 
    */
    $data = ATMVNPAY::process([
        'amount'=> $request->amount,
        'returnUrl' => route('result')
    ]);
    return Redirect::to($data);





    /*
    *  create route 
    * Route::get('/result', [App\Http\Controllers\{target}Controller::class, 'result'])->name('result');
    *
    */


    public function result(Request $request)
    {
        $data = $request->all();
        ProcessorsLogMOMO::processBacklog($data);           // insert array data momo in DB
        ProcessorsLogVNPAY::processBacklog($data);          // insert array data vnpay in DB

        return redirect()->route({target view}) 
            or
        return view('result', compact('data'));
    }



    /*
    * create view result.blade.php in resources  demo at src/view/result.blade.php
    *
    */


