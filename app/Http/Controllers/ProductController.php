<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function test()
    {
        return response()->json([
            'data' => 'berhasil mengambil data dari API',
            'status' => 200
        ]);
    }

    // all products
    public function index()
    {
        $products = Product::all();

        $data = [
            'status' => 200,
            'message' => 'Data berhasil diambil',
            'data' => $products,
        ];

        return response()->json($data, Response::HTTP_OK);
    }

    // detail product by id
    public function show($id)
    {
        $product = Product::find($id);

        // jika data ada
        if (is_null($product)) {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Data detail tidak ditemukan',
                'data' => null,
            ];

            return response()->json($data, Response::HTTP_NOT_FOUND);
        } else {
            $data = [
                'status' => Response::HTTP_OK,
                'message' => 'Data detail berhasil diambil',
                'data' => $product,
            ];

            return response()->json($data, Response::HTTP_OK);
        }
    }

    // create new product
    public function store(Request $request)
    {
        // validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:png,jpg,jpeg|max:2048',
        ]);
        $input = $request->all();

        // logic upload image
        if ($image = $request->file('image')) {
            $target = 'assets/images/';
            $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($target, $productImage);
            $input['image'] = "$productImage";
        }

        Product::create($input);
        $data = [
            'status' => Response::HTTP_CREATED,
            'message' => 'Data berhasil ditambahkan',
            'data' => $input,
        ];

        return response()->json($data, Response::HTTP_CREATED);
    }

    // update product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        // jika data ada
        if ($product) {
            $request->validate([
                'name' => 'string|max:255',
                'description' => 'string',
                'price' => 'integer',
                'image' => 'image|mimes:png,jpg,jpeg|max:2048',
            ]);
            $input = $request->all();

            // logic upload image
            if ($image = $request->file('image')) {
                $target = 'assets/images/';
                // unlink($target . $product->image);
                $productImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($target, $productImage);
                $input['image'] = "$productImage";
            }
            $product->update($input);
            $data = [
                'status' => Response::HTTP_OK,
                'message' => 'Data berhasil diupdate',
                'data' => $product,
            ];
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }

    // delete product
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            $data = [
                'status' => Response::HTTP_OK,
                'message' => 'Data berhasil dihapus',
            ];
            return response()->json($data, Response::HTTP_OK);
        } else {
            $data = [
                'status' => Response::HTTP_NOT_FOUND,
                'message' => 'Data tidak ditemukan',
                'data' => null,
            ];
            return response()->json($data, Response::HTTP_NOT_FOUND);
        }
    }
}
