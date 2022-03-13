<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\ProductService;
use App\Http\Resources\Api\V1\ProductResource;
use App\Http\Requests\Api\V1\Product\UpdateRequest;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     * 
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(): JsonResponse
    {
        try {
            return $this->successResponse(
                trans('messages.action_successfully_done'),
                ProductResource::collection($this->productService->get())
            );
        } catch (Throwable $exception) {
            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        try {
            return $this->successResponse(
                trans('messages.action_successfully_done'),
                new ProductResource($this->productService->find($id))
            );
        } catch (Throwable $exception) {
            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  UpdateRequest  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->productService->update($id, $request->validated());
            DB::commit();
            return $this->successResponse(
                trans('messages.action_successfully_done')
            );
        } catch (Throwable $exception) {
            DB::rollBack();
            return $this->failureResponse(
                $exception->getMessage(),
                $exception
            );
        }
    }
}
