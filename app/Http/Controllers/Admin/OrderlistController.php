<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Orderlist;
use App\Screenshots;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orderlists = Orderlist::all();

        return view('admin.orderlists.index', compact('orderlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Keep the checkout data.
     * @author Nemanja
     * @since 2021-04-14
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Savecheckout(Request $request) 
    {
        $userid = auth()->id();
        $orderlist = Orderlist::where('checking_num', $request['checking_num'])->first();

        DB::beginTransaction();

        try {
            if (@$orderlist) {
                $order_number = $orderlist->order_number;
                $checking_num = $orderlist->checking_num;

                $screen = Screenshots::where('orderNumber', $orderlist->order_number)->first();
                $screenshot = $screen->screenshot;
            }else{
                $order_number = Orderlist::generateOrderNum();
                $checking_num = $request['checking_num'];

                $screenshot = Screenshots::upload_file($request->screenshot);
            }

            $order__list = Orderlist::create([
                'order_number' => $order_number,
                'checking_num' => $checking_num,
                'userid' => $userid,
                'model_name' => $request['model_name'],
                'model_price' => $request['model_price'],
                'model_photo' => $request['model_photo'],
                'order_count' => $request['order_count'],
                'order_date' => date('Y-m-d h:i:s')
            ]);

            if (@$orderlist) {
            }else{
                $screenshots = Screenshots::create([
                    'orderNumber' => $order__list->order_number,
                    'screenshot' => $screenshot
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            
            throw $e;
        }  

        $result = [];
        $result['description'] = "Successfully ordered your models!";
        $result['screenshot'] = asset('uploads/')."/".$screenshot;
        $result['order_number'] = $order_number;

        return response()->json($result); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Orderlist::where('id', $id)->delete();
        
        return redirect()->route('orderlists.index');
    }
}
