<?php

namespace App\Http\Controllers\api;

use App\Classes\ApiResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\ProductRepositoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepositoryInterface;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepositoryInterface = $productRepositoryInterface;
     }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->productRepositoryInterface->getAll();
        return ApiResponseHelper::sendResponse(ProductResource::collection($data), '', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = [
            'mark' => $request->mark,
            'name' => $request->name,
            'state' => $request->state,
        ];
        DB::beginTransaction();
        try {
            $model = $this->productRepositoryInterface->store($data);
            DB::commit();
            return ApiResponseHelper::sendResponse(new ProductResource($model), 'Record create succesful', 201);
        } catch (Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $model = $this->productRepositoryInterface->getById($id);
        return ApiResponseHelper::sendResponse($model, '', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $data = [
            'mark' => $request->mark,
            'name' => $request->name,
            'state' => $request->state,
        ];
        DB::beginTransaction();
        try {
            $this->productRepositoryInterface->update($data, $id);
            DB::commit();
            return ApiResponseHelper::sendResponse(null, 'Record update succesful', 200);
        } catch (Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->productRepositoryInterface->delete($id);
        return ApiResponseHelper::sendResponse(null, 'Record deleted succesful', 200);
    }
}
