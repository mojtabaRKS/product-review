<?php

namespace App\Http\Controllers\Api\V1;

use Throwable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Api\V1\ProductService;
use App\Http\Resources\Api\V1\ProductResource;

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
    public function index(Request $request)
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
}
