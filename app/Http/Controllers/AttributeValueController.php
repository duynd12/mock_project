<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeValueRequest;
use App\Models\AttributeValue;
use App\Repositories\AttributeValueRepository;
use App\Services\AttributeValueService;
use Helmesvs\Notify\Facades\Notify;
use App\Constants\Attribute as AttributeConstants;

class AttributeValueController extends Controller
{
    private $attributeValueService;
    private $attributeValueRepository;


    public function __construct(
        AttributeValueService $_attributeValueService,
        AttributeValueRepository $_attributeValueRepository
    ) {
        $this->attributeValueService = $_attributeValueService;
        $this->attributeValueRepository = $_attributeValueRepository;
    }
    public function index()
    {
        $data = $this->attributeValueRepository->paginate(AttributeConstants::ATTRIBUTE_VALUE_LIMIT_SHOW);
        return view('attributes.AttributeValueManager');
    }
    public function showformCreate($id)
    {
        return view('attributes.addAttributeValue', ['id' => $id]);
    }
    public function create($id)
    {
        return view('attributes.addAttributeValue', ['id' => $id]);
    }

    public function store(AttributeValueRequest $request, $id)
    {
        $this->attributeValueService->createAttrValue($request, $id);
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data = $this->attributeValueRepository->find($id);
        return view('attributes.editAttributeValue', ['data' => $data]);
    }

    public function update(AttributeValueRequest $request, $id)
    {
        $this->attributeValueService->updateAttrValue($request, $id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->attributeValueService->deleteAttrValue($id);
        return redirect()->back();
    }
}