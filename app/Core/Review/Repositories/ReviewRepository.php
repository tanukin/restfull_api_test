<?php

namespace App\Core\Review\Repositories;

use App\Core\Review\Exceptions\ReviewDeleteException;
use App\Core\Review\Exceptions\ReviewSaveException;
use App\Core\Review\Dto\ReviewDto;
use App\Core\Review\Models\Review;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository
{
    /**
     * @param int $id
     *
     * @return Review|null
     */
    public function getReview(int $id): ?Review
    {
        return Review::findOrFail($id);
    }

    /**
     * @param int $productId
     * @param ReviewDto $dto
     *
     * @return Collection
     */
    public function getReviews(int $productId, ReviewDto $dto): Collection
    {
        $build = Review::on()
            ->where(['product_id' => $productId])
            ->offset($dto->getOffset())
            ->limit($dto->getLimit());

        return $build->get();
    }

    /**
     * @param Review $review
     *
     * @return Review
     *
     * @throws ReviewSaveException
     */
    public function save(Review $review): Review
    {
        if (!$review->save()) {
            throw new ReviewSaveException('Error. Review was not saved');
        }

        return $review;
    }

    /**
     * @param int $id
     *
     * @throws ReviewDeleteException
     */
    public function delete(int $id)
    {
        if (!Review::destroy($id)) {
            throw new ReviewDeleteException('Error. Product was not deleted');
        }
    }
}