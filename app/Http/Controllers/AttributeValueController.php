<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeValueRequest;
use App\Models\AttributeValue;
use Helmesvs\Notify\Facades\Notify;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    private $attribute_id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AttributeValue::all();
        return view('attributes.AttributeValueManager');
    }
    public function showformCreate($id)
    {
        $this->attribute_id = $id;
        return view('attributes.addAttributeValue', ['id' => $id]);
    }
    // public function create($id)
    // {
    //     $this->attribute_id = $id;
    //     return view('attributes.addAttributeValue', $id);
    // }

    /**
     * Store a newly created resource in storage.
    
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AttributeValueRequest $request, $id)
    {
        $data = $request['value_name'];
        try {
            AttributeValue::create([
                'attribute_id' => $id,
                'value_name' => $data
            ]);
            Notify::success("Thêm thành công");
            return redirect()->back();
        } catch (\Exception $e) {
            Notify::success("Thêm thất bại");
        }
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
        $data = AttributeValue::find($id);
        return view('attributes.editAttributeValue', [
            'id' => $id,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AttributeValueRequest $request, $id)
    {
        $data = $request->all();
        try {
            AttributeValue::findOrFail($id)->update([
                'value_name' => $data['value_name'],
            ]);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            // throw new $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            AttributeValue::destroy($id);
            Notify::success("Xóa thành công");
            return redirect()->back();
        } catch (\Exception $e) {
            Notify::success("Xóa thất bại");
        }
    }
}