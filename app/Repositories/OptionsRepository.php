<?php
namespace App\Repositories;

use App\Models\Option;

class OptionsRepository
{
    /**
     * @var Option
     */
    private $option;

    /**
     * OptionsRepository constructor.
     * @param Option $option
     */
    public function __construct(Option $option)
    {
        $this->option = $option;
    }

    /**
     * @param $product_id
     * @return bool
     */
    public function is_visible($product_id): bool
    {
        return $this->option->where('product_id', '=', $product_id)->firstOrFail()->is_visible;
    }

    /**
     * @param $product_id
     * @return mixed
     */
    public function returnOptionsIfVisible($product_id)
    {
        return $this->option
            ->select(['product_id', 'product_visibility', 'comments_mode', 'vote_mode'])
            ->where('product_id', '=', $product_id)
            ->visible()
            ->firstOrFail();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function setOptions($request)
    {
        return $this->option->updateOrCreate(
            ['product_id' => $request->product_id],
            [
                'product_visibility' => $request->visible,
                'comments_mode' => $request->comments_mode,
                'vote_mode' => $request->vote_mode,
            ]
        );
    }
}
