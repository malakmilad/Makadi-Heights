<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::paginate(15);
        // $faqs = Payment::get();
        $count = count($faqs);

        return view('faqs.index', compact('faqs', 'count'));
    }

    public function searchPayments(Request $request)
    {
        $faqs = Faq::with(['payments']);

        if ($request->get('question')) {
            $faqs->where('question', 'like', '%' . $request->question . '%');
        }

        if ($request->get('answer')) {
            $faqs->where('answer', 'like', '%' . $request->answer . '%');
        }

        if ($request->get('date_from') || $request->get('date_to')) {
            $faqs->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59',
            ]);
        }

        $faqs = $faqs->orderBy('created_at', 'DESC')->paginate(15);
        $count = count($faqs);

        // return redirect()->route('faqs',compact('faqs'));
        return view('faqs.index', compact('faqs', 'count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);

        $faq = Faq::create($request->all());

        return redirect()
            ->route('faqs')
            ->with('status', 'Faq Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $faq = Faq::findOrFail($request->id);
        return view('faqs.show', compact('faq'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $faq = Faq::findOrFail($request->id);
        return view('faqs.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        $faq = Faq::findOrFail($request->id);

        $validated = $request->validate([
            'question' => 'required|max:255',
            'answer' => 'required',
        ]);

        $faq->fill($request->input())->save();

        return redirect()
            ->back()
            ->with('status', 'FAQ Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $faq = faq::findOrFail($request->id);

        $faq->delete();

        return redirect()
            ->route('faqs')
            ->with('status', 'FAQ Deleted Successfully');
    }
}
