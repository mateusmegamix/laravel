<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    protected $request;
    private $repository;

    public function __construct(Request $request, Product $product)
    {
        $this->request = $request;

        $this->repository = $product;

        //$this->middleware('auth');
        // $this->middleware('auth')->only([
        //     'create', 'store'
        // ]);
        // $this->middleware('auth')->except([
        //     'index', 'show'
        // ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $teste = 123;
        // $teste2 = 456;
        // $teste3 = [1, 2, 3];
        // $products = ['Tv', 'Geladeira', 'Forno', 'Sofa'];

        // return view('admin.pages.products.index', compact('teste', 'teste2', 'teste3', 'products'));

        $products = Product::latest()->paginate();
        return view('admin.pages.products.index', [
            'products' => $products,
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateProductRequest $request)
    {
        $data = $request->only('name', 'description', 'price');

        if($request->hasFile('image')&& $request->image->isValid()){
            $imagePath = $request->image->store->store('products');
            $data['imagem'] = $imagePath;
        }

        $this->repository->create($data);
        // $product = new Product;
        // $product->name = $request->name;
        // $product->save();

        return redirect()->route('products.index');

        /*
        $request->validate([
            'name' => 'required|min:3|max:255',
            'description' => 'nullable|min:3|max:10000',
            'photo' => 'required|image',
        ]);

        //onde faz o cadastro
        //dd($request->all());
        //dd($request->only(['name', 'description']));
        //dd($request->has('teste'));
        //dd($request->input('name', 'deafult'));
        //dd($request->except('name'));
        if($request->file('photo')->isValid()){
            //dd($request->file('photo')->store('products'));
            $nameFile = $request->name.'.'.$request->photo->extension();
            dd($request->file('photo')->storeAs('products', $nameFile));//personalizar com o nome do produto
        }
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$product = Product::where('id', $id)->first();
        if(!$product = $this->repository->find($id))
        return redirect()->back();
        
        return view('admin.pages.products.show', [
        'product' => $product
    ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!$product = $this->repository->find($id))
        return redirect()->back();

        //onde edita os arquivos
        return view('admin.pages.products.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUpdateProductRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateProductRequest $request, $id)
    {
        if(!$product = $this->repository->find($id))
        return redirect()->back();

        $data = $request->all();

        if($request->hasFile('image')&& $request->image->isValid()){

            if($product->image && Storage::exists($product->image)){
                Storage::delete($product->image);
            }

            $imagePath = $request->image->store->store('products');
            $data['imagem'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('products.index');
        //dd("Editando o produto {$id}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->repository->where('id', $id)->first();
        if (!$product)
        return redirect()->back();

        if($product->image && Storage::exists($product->image)){
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index');

        //dd("deletando o produto {$id}");
    }

    public function search(Request $request)
    {
        $filters = $request->except('_token');

        $products = $this->repository->search($request->filter);

        $products = Product::latest()->paginate();
        return view('admin.pages.products.index', [
            'products' => $products,
            'filter' => $filters,
        ]);
    }
}
