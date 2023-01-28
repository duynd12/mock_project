<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use App\Services\AttributeService;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $attributeService;
    public function __construct(AttributeService $_attributeService)
    {
        $this->attributeService = $_attributeService;
    }
    public function index()
    {
        $data = Attribute::paginate(5);
        // dd($data);
        return view('attributes.attributeManager', ['data' => $data]);
    }
    public function create()
    {
        return view('attributes.addAttribute');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->attributeService->createAttribute($request);
        return redirect()->route('attribute.create');
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
        //
    }
}
