<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        

        $tags = Redis::hGetAll('tags');
        if($request->has('tag'))
        {
            $products = self::getProductsByTag($request->get('tag'));
        }else{
            $products = self::getProducts();
        }

        //dd($tags,$products);

        return view('product.browse')
                ->with(['tags' => $tags, 'products' => $products]);
    }

    static function getProducts()
    {
        $productsIds = Redis::zRange('products', 0, -1);
        $products = [];

        foreach($productsIds as $productId => $score )
        {
            $products[$score] = Redis::hGetAll("product:$productId");
        }

        return $products;
    }


    static function getProductsByTag($tag)
    {
        $productsIds = Redis::lRange("$tag", 0, -1);
        $products = [];

        foreach($productsIds as $productId)
        {
            $products[] = Redis::hGetAll("product:$productId");
        }

        return $products;
    }

    public function create()
    {
        return view('product.create');
    }


    public function store(Request $request)
    {
        //return dd($request->all());

        $productId = self::getProductId();

        if(self::newProduct(['id' => $productId, 'name' => $request->product_name, 'image' => $request->product_image]))
        {
            $tags = explode(',',$request->tags);
            //dd($tags);
            self::addTags($tags);
            self::createProductTags($productId,$tags);
            self::addProductToTags($productId,$tags);

            return redirect()->route('product.all');
        }

        

    }

    static function getProductId() : int
    {
        if(!Redis::exists('product_id')) Redis::set('product_id',0);

        return Redis::incr('product_id');
    }

    static function newProduct($data) 
    {
        Redis::zAdd('products', time(), $data['id']);
        $res = Redis::hMset("product:{$data['id']}", $data);

        return $res;
    }

    static function addTags(array $tags)
    {
        Redis::hMset('tags', $tags);
    }


    static function createProductTags($productId,$tags)
    {
        Redis::hMset('product:$productId', $tags);
    }

    static function addProductToTags($productId,$tags)
    {
        foreach($tags as $tag)
        { 
            Redis::rPush($tag, $productId);
        }
    }
}
