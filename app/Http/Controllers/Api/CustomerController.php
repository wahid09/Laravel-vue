<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CustomerCollection(Customer::orderBy('id', 'DESC')->paginate(10));
    }

    public function search($field, $query){
        return new CustomerCollection(Customer::where($field, 'LIKE', "%$query%")->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email|unique:customers',
            'phone'     => 'required|numeric|unique:customers',
            'address'   => 'required',
            'address'   => 'required',
            'total'     => 'required|numeric',
        ]);

        $customer = new Customer();

        $customer->name    = $request->name;
        $customer->email   = $request->email;
        $customer->phone   = $request->phone;
        $customer->address = $request->address;
        $customer->total   = $request->total;

        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CustomerResource(Customer::findOrfail($id));
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
        $this->validate($request, [
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'required|numeric',
            'address'   => 'required',
            'address'   => 'required',
            'total'     => 'required|numeric',
        ]);

        $customer = Customer::findOrfail($id);

        $customer->name    = $request->name;
        $customer->email   = $request->email;
        $customer->phone   = $request->phone;
        $customer->address = $request->address;
        $customer->total   = $request->total;

        $customer->save();

        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrfail($id);
        $customer->delete();

        return new CustomerResource($customer);
    }
}
