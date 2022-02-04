<?php

namespace App\Http\Controllers;

use App\Category;
use App\Gallery;
use App\Portfolio;
use Illuminate\Http\Request;
use Auth;
use Alert;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return $portfolio = Portfolio::with('gallery')->find(1);
        $portfolios = Portfolio::orderBy('completion','desc')->get();
        return view('admin.portfolios.index', compact('portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.portfolios.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        request()->validate([
//            'album' => 'required',
//            'album.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
//        ]);

        $this->validate($request, [
            'en_name' => 'required',
            //'ar_name' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'en_client' => 'required',
            //'ar_client' => 'required',
            'completion' => 'required',
            'en_role' => 'required',
            //'ar_role' => 'required',
            'category_id' => 'required',
            'en_details' => 'required',
            //'ar_details' => 'required',
        ]);

        $input = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            //dd(md5_file($image));

            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            //dd($file_name);

            //$filename = date('Y-m-d-H-i-s') . "." . $image->getClientOriginalExtension();
            $image->move(public_path('images/portfolios'), $file_name);
            $input['image'] = $file_name;
        }
        $portfolio = Portfolio::create($input);

        /** Start Store Portfolio album in Gallery table */
        if ($request->hasfile('album')) {
            foreach ($request->file('album') as $image_album) {
                //$album_name = date('Y-m-d-H-i-s') . "." . $image_album->getClientOriginalExtension();
                $original_name = strtolower(trim($image_album->getClientOriginalName()));
                $album_name = time() . rand(100, 999) . $original_name;
                //$album_name = date('Y-m-d-H-i-s').'-'.rand(100,999).$original_name;
                $image_album->move(public_path() . '/images/portfolios/', $album_name);
                //$data[] = $album_name;

                $gallery = new Gallery();
                $gallery->portfolio_id = $portfolio->id;
                $gallery->image = $album_name;
                $gallery->save();
            }
        }
//        $gallery = new Gallery();
//        $gallery->portfolio_id = $portfolio->id;
//        $gallery->image = json_encode($data);
//        $gallery->save();
        /** End Store Portfolio album in Gallery table */

        alert()->success('The portfolio was created successfully!')->persistent('Close');
        return redirect()->route('portfolio.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $portfolio = Portfolio::where('id', $id)->with('gallery:id,portfolio_id,image')->with('category:id,name')->first();
        $categories = Category::select('id', 'name')->get();

        return view('admin.portfolios.edit', compact('portfolio', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'en_name' => 'required',
            //'ar_name' => 'required',
            'en_client' => 'required',
            //'ar_client' => 'required',
            'completion' => 'required',
            'en_role' => 'required',
            //'ar_role' => 'required',
            'category_id' => 'required',
            'en_details' => 'required',
            //'ar_details' => 'required',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $original_name = strtolower(trim($image->getClientOriginalName()));
            $file_name = time() . rand(100, 999) . $original_name;
            $image->move(public_path('images/portfolios'), $file_name);
            $input['image'] = $file_name;
        } else {
            unset($input['image']);
        }

        Portfolio::findOrFail($id)->update($input);

        alert()->success('The portfolio was updated successfully!')->persistent('Close');
        return redirect()->route('portfolio.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Portfolio::findOrFail($id)->delete();
        alert()->success('The portfolio was deleted successfully!')->persistent('Close');
        return redirect()->route('portfolio.index');
    }
}
