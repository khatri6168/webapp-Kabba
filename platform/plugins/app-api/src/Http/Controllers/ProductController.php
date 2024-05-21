<?php

namespace Botble\AppApi\Http\Controllers;

use Illuminate\Http\Request;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Enums\BaseStatusEnum;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\ProductCategoryInterface;
use Botble\Ecommerce\Services\Products\GetProductService;
use Botble\Ecommerce\Facades\ProductCategoryHelper;

use Exception;
use DB;


class ProductController extends BaseController{

    public function __construct(
            protected ProductInterface $productRepository){
        }

    public function getAllCategories(){
        $allCategories = ProductCategoryHelper::getAllProductCategories();
        if (count($allCategories) > 0) {
            return response()->json([
                'errors' => [],
                'message' => 'Categories successfully found.',
                'data' => $allCategories,
                'success' => true
            ], 200);
        }
        return response()->json([
            'errors' => [],
            'message' => 'Categories not found.',
            'data' => [],
            'success' => false
        ], 404);
    }

    public function getCategoryProducts(Request $request,
                                        ProductCategoryInterface $categoryRepository,
                                        GetProductService $getProductService)
    {
        $condition = [
            'ec_product_categories.id' => $request->category_id,
            'ec_product_categories.status' => BaseStatusEnum::PUBLISHED,
        ];

        $category = $categoryRepository->getFirstBy($condition, ['*'], ['slugable']);
        if (is_null($category)) {
            return response()->json([
                'errors' => [],
                'message' => 'Category Not Found.',
                'data' => (object)$category,
                'success' => false
            ], 404);
        }

        $with = [
            'slugable',
            'variations',
            'productLabels',
            'variationAttributeSwatchesForProductList',
            'productCollections',
        ];
        $request->merge([
            'categories' => array_merge(
                [$category->id],
                $category->activeChildren->pluck('id')->all()
            ),
        ]);
        $request['paginateFlag'] = false;
        $products = $getProductService->getProduct($request, null, null, $with);
        if (count($products) == 0) {
            return response()->json([
                'errors' => [],
                'message' => 'Products Not Found.',
                'data' => (object)[],
                'success' => false
            ], 404);
        }
        $request->merge([
            'categories' => array_merge(
                $category->parents->pluck('id')->all(),
                $request->input('categories')
            ),
        ]);
        $response['category'] = $category;
        $response['products'] = $products;

        return response()->json([
            'errors' => [],
            'message' => 'Products successfully found.',
            'data' => $response,
            'success' => true
        ], 200);

    }

    public function getProductDetails(Request $request){

        try {
            $product = $this->productRepository->findOrFail($request->product_id);
            $product->loadMissing(['options', 'options.values','taxes']);
        } catch (\exception $e) {
            return response()->json([
                'errors' => [],
                'message' => 'Product Not found.',
                'data'=> $e,
                'success' => false
            ], 404);
        }

        return response()->json([
            'errors' => [],
            'message' => 'Product details successfully found.',
            'data' => $product,
            'success' => true
        ], 200);

    }
}
