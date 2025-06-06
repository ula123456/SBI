<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Services\ProductService;

class ProductController extends Controller
{
    public function exportExcel(ProductService $service)
    {
        $service->exportProductsToExcel();
        // ...
    }
}
public function index()
    {
        return ProductResource::collection(Product::with('category')->get());
    }

public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        $product->load('category'); // загружаем категорию
        return new ProductResource($product);
    }
public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

// реализуй show, update, destroy аналогично CategoryController
}
