<?php

namespace App\Filters;



use App\Models\Product;
use Illuminate\Http\Request;

class FilterProduct
{
    protected Request $request;

    protected \Illuminate\Database\Eloquent\Builder $query;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->query = Product::query();
    }

    /**
     * Apply all available filters to the Product query.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function apply(): \Illuminate\Database\Eloquent\Collection
    {
        $this->filterCategory();
        $this->filterPrice();
        $this->filterPopular();

        return $this->query->get();
    }

    /**
     * Filter for search on product category
     * @return void
     */
    protected function filterCategory(): void
    {
        if($this->request->filled('category_id')){
            $this->query->where('category_id', $this->request->category_id);
        }
    }

    /**
     * Filter for search product price
     * @return void
     */
    protected function filterPrice(): void
    {
        if($this->request->filled('price_min')){
            $this->query->where('price', '>=', $this->request->price_min);
        }
        if($this->request->filled('price_max')){
            $this->query->where('price', '<=', $this->request->price_max);
        }
    }

    /**
     * Filter for search products on popular
     * @return void
     */
    protected function filterPopular(): void
    {
        if($this->request->filled('popular') && $this->request->popular){
            $this->query->withCount('comments')->orderBy('comments_count', 'desc');
        }
    }

}
