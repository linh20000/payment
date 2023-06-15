    
    
    
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
    
    
    /*
    *  using controller 
    *
    *   use Illuminate\Http\Request;
    *   use Service\Payment\Momo\Processors\Wallet;
    *   use Illuminate\Support\Facades\Redirect;
    *   use Service\Payment\Momo\Processors\ATM;
    *   use Service\Payment\Momo\Processors\WalletRef;
    *   use Service\Payment\Vnpay\Processors\Wallet as ProcessorsWallet;
    *   use Service\Payment\Momo\Processors\ATMRefund;
    *   use Service\Payment\Vnpay\Processors\ATM as ProcessorsATM;
    *   use Service\Payment\Momo\Processors\MOMOTrans;
    *   use Service\Payment\Vnpay\Processors\VNPTrans;
    *   use Service\Payment\Vnpay\Processors\VNPAYRefund;
    *
    *
    */
   
    /**
        * wallet momo
        */
    // $data = Wallet::process([
    //     'amount'=> $request->amount,   // int
    //     'data'=>$request->all(),       // data
    //     'returnUrl' => route('result')  // url
    // ]);
    // return Redirect::to($data->getPayUrl());

    /**
    *  atm momo
    */
    // $data = ATM::process([
    //     'amount'=> $request->amount,      // int
    //     'data'=>$request->all(),          // data
    //     'returnUrl' => route('result')   // url
    // ]);
    // return Redirect::to($data);



    /**
        * wallet vnpay
        */
    // $data = ProcessorsWallet::process([ 
    //     'amount'=> $request->amount,       // int
    //     'returnUrl' => route('result')    // url
    // ]);
    // return Redirect::to($data);

    /*
    * atm vnpay 
    */
    // $data = ProcessorsATM::process([
    //     'amount'=> $request->amount,
    //     'returnUrl' => route('result')
    // ]);
    // return Redirect::to($data);



    /*
    *  create route 
    * Route::get('/result', [App\Http\Controllers\{target}Controller::class, 'result'])->name('result');
    *
    */


    public function result(Request $request)
    {
        // $data = $request->all();
        // $test = VNPTrans::Process($data);                           // vnpay transaction
        // dd($test);

        // $response = MOMOTrans::Process($data);                    // momo transaction
        // dd($response);
    }


    public function refund(Request $request)
    {
        // $test = VNPAYRefund::process([
        //     'TxnRef' => '1686801306',  // Mã tham chiếu của giao dịch lấy từ db 
        //     'TransactionType' => '03', // 02 == hoàn toàn phần  03 == hoàn một phần
        //     'amount' => '20',      // số tiền cần hoàn 
        //     'TransactionDate' => '20230615105521',  // pay_date lấy từ DB
        //     'TransactionNo' => '14039431',  // vnp_TransactionNo lấy từ DB
        //     'CreateBy' => 'ngoquanglinh23062000@gmail.com',     // email người thanh toán lấy từ DB
        // ]);
        // dd(json_decode($test->getContent()));


        // MOMORefund  coming soon...
    }


    /*
    * create view result.blade.php in resources  demo at src/view/result.blade.php
    *
    */


