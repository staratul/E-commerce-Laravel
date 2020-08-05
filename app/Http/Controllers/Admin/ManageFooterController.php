<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FooterRequest;
use App\Models\Admin\Footer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ManageFooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footer = Footer::first();
        return view('admin.pages.manage_footer', compact('footer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('admin.pages.add_footer');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FooterRequest $request)
    {
        $imageName = "";

        if(isset($request->logo)) {
            $path = 'uploads/admin/partnerlogo/';
            $file = $request->logo;
            $image = Image::make($file);
            $image = $image->resize(89, 23);
            $imageName = time().$file->getClientOriginalName();
            $image->save($path.$imageName);
        }

        $footer = Footer::create([
            'logo' => $imageName,
            'icons' => implode(',', $request->icons),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'information_links' => $request->information_links,
            'account_links' => $request->account_links,
            'newsletter_text' => $request->newsletter_text,
        ]);

        return redirect()->route('footers.index');
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
        $footer = Footer::first();
        return view('admin.pages.add_footer', compact('footer'));
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
        Footer::where('id', $id)->update([
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "information_links" => $request->information_links,
            "account_links" => $request->account_links,
            "newsletter_text" => $request->newsletter_text
        ]);

        return redirect()->route('footers.index');
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
