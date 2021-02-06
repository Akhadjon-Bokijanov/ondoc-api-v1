<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\PaymeTransaction;
use Illuminate\Http\Request;

class PaymeTransactionController extends Controller
{
    const USERNAME = 'Paycom';
    const PASSWORD = '8c&?y?&fUWa%ygdTorG0jY?EG%x6XGPowFOr'; //this is test key

    const PASSWORD_TEST = 'rw6P3oT1eDArP7jE6KyIyBqboou#SxG6ZQT7';
    const METHOD_CHECK_PERFORM_TRANSACTION = 'CheckPerformTransaction';
    const METHOD_CREATE_TRANSACTION = 'CreateTransaction';
    const METHOD_CHECK_TRANSACTION = 'CheckTransaction';
    const METHOD_PERFORM_TRANSACTION = 'PerformTransaction';
    const METHOD_CANCEL_TRANSACTION = 'CancelTransaction';
    const METHOD = 'method';
    public $enableCsrfValidation = false;

    const CODE_UNAUTHORIZE = -32504;
    const CODE_OLYMPIAD_NOT_FOUND = -31050;
    const CODE_TRANSACTION_NOT_FOUND = -31003;
    const CODE_WRONG_AMOUNT = -31001;
    const CODE_DISABLED_CANCEL = -31007;
    const CODE_STATE_NOT_1 = -31008;
    const CODE_ALREADY_PAID = -31051;
    const CODE_WAITING_PAYMENT = -31052;
    const CODE_SERVER_ERROR = -31099;

    const STATE_NEW = 1;
    const STATE_COMPLETED = 2;
    const STATE_CANCELED = -1;
    const STATE_CANCELED_AFTER_COMPLETE = -2;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return PaymeTransaction::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //
        try {

            $auth_header = $req->header("authorization");
            if (!$this->paymeAuth($auth_header)){
                return $this->error(self::CODE_UNAUTHORIZE, "unauthorized");
            }

            $methods = self::getAllMethods();

            $request = $req->all();

            if(is_array($request) && array_key_exists(self::METHOD,$request) && in_array($request[self::METHOD],$methods)) {
                $key = array_search($request[self::METHOD],$methods);
                $method = $methods[$key];
                return $this->$method($request);
            } else {

                return response([], 404);
            }

        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymeTransaction  $paymeTransaction
     * @return \Illuminate\Http\Response
     */
    public function show($paymeTransaction)
    {
        //
        //return Company::where(['tin'=>$paymeTransaction])->first();
        return PaymeTransaction::where(['transaction_id' => $paymeTransaction])->first();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymeTransaction  $paymeTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymeTransaction $paymeTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymeTransaction  $paymeTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymeTransaction $paymeTransaction)
    {
        //
    }


    private function paymeAuth($header){
        if (isset($header)){
            $str = base64_decode(str_replace('Basic ','',$header));
            $array =explode(':', $str);

            if(is_array($array) && count($array) == 2){
                return $array[0] == self::USERNAME && $array[1] == self::PASSWORD;
            }
        }
        return false;
    }

    private function error($code,$message ='') {
        return [
            'error' => [
                'code' => $code,
                'message' => $message
            ],
        ];
    }

    public static function getAllMethods() {
        return [
            self::METHOD_CHECK_PERFORM_TRANSACTION,
            self::METHOD_CREATE_TRANSACTION,
            self::METHOD_CHECK_TRANSACTION,
            self::METHOD_PERFORM_TRANSACTION,
            self::METHOD_CANCEL_TRANSACTION
        ];
    }

    public function CheckPerformTransaction($request) {
        try {
            $model = Company::where(['tin'=>$request['params']['account']['tin']])->first();
            if(empty($model))
                return $this->error(self::CODE_OLYMPIAD_NOT_FOUND,[
                    'uz' => 'So\'rov topilmadi',
                    'ru' => 'Запрос не найден',
                    'en' => 'Request not found',
                ]);
        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }
        return $this->success(['allow' => true]);
    }

    public function CreateTransaction($request) {
        try {

            $model = Company::where(['tin'=>$request['params']['account']['tin']])->first();
            if(empty($model))
                return $this->error(self::CODE_OLYMPIAD_NOT_FOUND,[
                    'uz' => 'So\'rov topilmadi',
                    'ru' => 'Запрос не найден',
                    'en' => 'Request not found',
                ]);

            $transaction = PaymeTransaction::where(['transaction_id' => $request['params']['id']])->first();
            if(!empty($transaction) && $transaction->state != self::STATE_NEW)
                return $this->error(self::CODE_STATE_NOT_1,[
                    'uz' => 'Tranzaksiya to\'lovni kutyapti',
                    'ru' => 'В ожидании оплаты',
                    'en' => 'Pending payment',
                ]);


        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }

        if(empty($transaction)) {
            $transaction = new PaymeTransaction();
            $transaction->transaction_id = $request['params']['id'];
            $transaction->tin = $request['params']['account']['tin'];
            $transaction->transaction_create_time = $request['params']['time'];
            $transaction->create_time = (int)($transaction->create_time == null ? round(microtime(true) * 1000) : $transaction->create_time);
        }
        $transaction->amount = (int)$request['params']['amount'];
        $transaction->state = self::STATE_NEW;
        $transaction->save();
        return $this->success([
            'create_time' => (int)$transaction->create_time,
            'transaction' => (string)$transaction->id,
            'state' => $transaction->state,
        ]);
    }

    public function PerformTransaction($request) {
        try {
            $model = PaymeTransaction::where(['transaction_id' => $request['params']['id']])->first();
            if(empty($model))
                return $this->error(self::CODE_TRANSACTION_NOT_FOUND,[
                    'uz' => 'Tranzaksiya topilmadi',
                    'ru' => 'Транзакция не найден',
                    'en' => 'Transaction not found',
                ]);

            if($model->state != self::STATE_NEW && $model->state != self::STATE_COMPLETED)
                return $this->error(self::CODE_STATE_NOT_1,[
                    'uz' => 'To\'lovni amalga oshirish iloji y\'q',
                    'ru' => 'Невозможно выполнить данную операцию',
                    'en' => 'Cannot perform this operation'
                ]);

            $model->perform_time = (int)($model->perform_time == null ? round(microtime(true) * 1000) : $model->perform_time);
            $model->state = self::STATE_COMPLETED;
            if(!$model->save()){
                $this->serverError("Line 227: Transaction not saved!");
            }

        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }

        return $this->success([
            'transaction' => (string)$model->id,
            'perform_time' => (int)$model->perform_time,
            'state' => $model->state,
        ]);
    }

    public function CancelTransaction($request) {
        try {
            $model = PaymeTransaction::where(['transaction_id' => $request['params']['id']])->first();
            if(empty($model))
                return $this->error(self::CODE_TRANSACTION_NOT_FOUND,[
                    'uz' => 'Tranzaksiya topilmadi',
                    'ru' => 'Транзакция не найден',
                    'en' => 'Transaction not found',
                ]);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }

        $model->cancel_time = (int)($model->cancel_time == null ? round(microtime(true) * 1000) : $model->cancel_time);
        $model->reason = $request["params"]["reason"] ?? 5;
        $model->state = self::STATE_CANCELED;
        $model->save();
        return $this->success([
            'transaction' => (string)$model->id,
            'cancel_time' => (int)$model->cancel_time,
            'state' => (int)$model->state
        ]);
    }

    public function CheckTransaction($request) {
        try {
            $model = PaymeTransaction::where(['transaction_id' => $request['params']['id']])->first();
            if(empty($model))
                return $this->error(self::CODE_TRANSACTION_NOT_FOUND,[
                    'uz' => 'Tranzaksiya topilmadi',
                    'ru' => 'Транзакция не найден',
                    'en' => 'Transaction not found',
                ]);

        } catch (Exception $e) {
            return $this->serverError($e->getMessage());
        }

        $model->reason = $model->state==-1?3:$model->reason;
        return $this->success([
            'create_time' => (int)$model->create_time,
            'perform_time' => $model->perform_time== null ? 0 : (int)$model->perform_time ,
            'cancel_time' => $model->cancel_time == null ? 0 : (int)$model->cancel_time,
            'transaction' => (string)$model->id,
            'state' => $model->state,
            'reason' => $model->reason==null?null:(int)$model->reason
        ]);
    }


    private function success($result) {
        return [
            'result' => $result
        ];
    }

    private function serverError($m) {
        return $this->error(self::CODE_SERVER_ERROR,[
            'uz' => 'Server xatoligi',
            'ru' => 'Ошибка сервера',
            'en' => 'Server error',
            'm' => $m
        ]);
    }

}

