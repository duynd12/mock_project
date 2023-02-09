<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Repositories\AttributeRepository;
use App\Services\AttributeService;
use Illuminate\Http\Request;
use App\Constants\Attribute as AttributeConstants;

class AttributeController extends Controller
{

    private $attributeService;
    private $attributeRepository;

    public function __construct(
        AttributeService $_attributeService,
        AttributeRepository $_attributeRepository
    ) {
        $this->attributeService = $_attributeService;
        $this->attributeRepository = $_attributeRepository;
    }
    public function index()
    {
        $data = Attribute::paginate(AttributeConstants::ATTRIBUTE_VALUE_LIMIT_SHOW);
        return view('attributes.attributeManager', ['data' => $data]);
    }
    public function create()
    {
        return view('attributes.addAttribute');
    }

    public function store(AttributeRequest $request)
    {
        $this->attributeService->createAttribute($request);
        return redirect()->back();
    }

    public function edit($id)
    {
        $data = $this->attributeRepository->find($id);
        return view('attributes.editAttribute', [
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $data = Attribute::with(['attributeValues'])->find($id);
        return view('attributes.AttributeValueManager', ['data' => $data]);
    }

    public function update(AttributeRequest $request, $id)
    {
        $this->attributeService->updateAttribute($request, $id);
        return redirect()->back();
    }

    public function destroy($id)
    {
        $this->attributeService->deleteAttribute($id);
        return redirect()->back();
    }
}
