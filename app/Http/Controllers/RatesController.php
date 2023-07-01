<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;

class RatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rates = Rate::get();
        $count = count($rates);

        return view('rates.index',compact('rates','count'));
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
        $rate = Rate::findOrFail($id);

        return view('rates.edit',compact('rate'));
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
        // dd($id);
        $rate = Rate::findOrFail($id);
        // dd($request->all());

        $validated = $request->validate([
            'rate' => 'required|numeric',
        ]);

        $rate->update([
            'rate' => $request->rate
        ]);

        return redirect()
            ->back()
            ->with('status', $rate->currency.' Rate Updated Successfully');
    }

    public function getRates()
    {
        $rates = Rate::orderBy('currency','DESC')->get();

        return response()->json($rates);
    }

    public function getRate(Request $request)
    {
        $rate = Rate::where('id',$request->id)->first();

        if (!$rate) {
            return response()->json(['error' => 'Cannot fund the Currency you are looking for']);
        }

        return response()->json($rate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
