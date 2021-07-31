<?php


namespace App\Services;


use App\Models\Product;

class ProductService
{
    protected $file;
    public function __construct(FileService $file)
    {
        $this->file = $file;
    }

    public function allProduct()
    {
        return Product::all(['id','title','description','price','image']);
    }

    public function setter($value) : array
    {
        $data = [
            'title' => $value['title'],
            'description' => $value['description'],
            'price' => $value['price'],
        ];
        return $data;
    }

    public function store($data, $request)
    {
        $product = new Product();
        $property = $this->setter($data);
        if ($request->hasFile('image')) {
            $property['image'] = $this->file->storeFile($request);
        }
        $product->create($property);
    }

    public function update($data, $request, $model)
    {
        $property = $this->setter($data);
        if ($request->hasFile('image')) {
            if($model->image){
                $this->file->removeFile($model->image);
            }
            $property['image'] = $this->file->storeFile($request);
        }
        $model->update($property);
    }

    public function destroy($model)
    {
        if($model->image){
            $this->file->removeFile($model->image);
        }
        $model->delete();
    }

}