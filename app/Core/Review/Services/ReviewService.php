<?php

namespace App\Core\Review\Services;

use App\Core\Review\Exceptions\ReviewException;
use App\Core\Review\Dto\ReviewDto;
use App\Core\Review\Models\Review;
use App\Core\Review\Repositories\ReviewRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;


class ReviewService
{
    /**
     * @var ReviewRepository
     */
    private $repository;

    /**
     * ProductService constructor.
     *
     * @param ReviewRepository $repository
     */
    public function __construct(ReviewRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     *
     * @return Review
     */
    public function getReview(int $id): Review
    {
        return $this->repository->getReview($id);
    }

    /**
     * @param Request $request
     * @param int $productId
     *
     * @return Collection
     */
    public function getReviews(Request $request, int $productId): Collection
    {
        $dto = new ReviewDto();
        $dto->setOffset($request->get('offset'));
        $dto->setLimit($request->get('limit'));

        return $this->repository->getReviews($productId, $dto);
    }

    /**
     * @param Request $request
     * @param int $productId
     *
     * @return Review
     *
     * @throws ReviewException
     */
    public function create(Request $request, int $productId): Review
    {
        $review = new Review();
        $review = $this->setProperties($review, $request);
        $review->product_id = $productId;

        return $this->repository->save($review);
    }

    /**
     * @param Request $request
     * @param int $productId
     *
     * @return Review
     *
     * @throws ReviewException
     */
    public function update(Request $request, int $productId): Review
    {
        $review = $this->getReview($productId);
        $product = $this->setProperties($review, $request);

        return $this->repository->save($product);
    }

    /**
     * @param int $id
     *
     * @throws ReviewException
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    /**
     * @param Review $review
     * @param Request $request
     *
     * @return Review
     */
    protected function setProperties(Review $review, Request $request): Review
    {
        $review->customer = $request->get('customer');
        $review->review = $request->get('review');
        $review->star = $request->get('star');

        return $review;
    }
}