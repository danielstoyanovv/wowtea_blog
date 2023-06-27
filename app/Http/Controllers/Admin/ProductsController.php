<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.products.index', ['products' => Product::paginate(10)]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.create');

    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(ProductRequest $request)
    {
        try {
            if ($request->getMethod() == "POST") {
                $productData = [
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'price' => $request->input('price')
                ];
                if ($request->has('image')) {
                    $productData['image'] = \App\Helpers\ImageUploader::handleImageRequestData($request);
                }
                $product = ProductFactory::new($productData)->create();
                session()->flash('message', __('Product was created'));
                return redirect()->action([self::class, 'edit'], ['product' => $product->id]);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', ['product' => $product]);
    }

    /**
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        if ($request->getMethod() == "PATCH") {
            $validated = $request->validated();
            try {
                if ($request->has('image')) {
                    $validated['image'] = \App\Helpers\ImageUploader::handleImageRequestData($request);
                }
                $product->update($validated);
                session()->flash('message', __('Product was updated'));
                return redirect()->action([self::class, 'edit'], ['product' => $product->id]);

            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        throw new NotFoundHttpException();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->image) {
                unlink(public_path($product->image));
            }
            Product::destroy($product->id);
            session()->flash('message', __('Product was removed'));
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return redirect()->action([self::class, 'index']);
    }
}
