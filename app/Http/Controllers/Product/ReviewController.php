<?php

namespace App\Http\Controllers\Product;

use App\Core\Product\Models\Product;
use App\Core\Review\Exceptions\ReviewException;
use App\Core\Review\Exceptions\ReviewNotBelongsToProduct;
use App\Core\Review\Services\ReviewService;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaginationRequest;
use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * @var ReviewService
     */
    private $service;

    /**
     * ReviewController constructor.
     *
     * @param ReviewService $service
     */
    public function __construct(ReviewService $service)
    {
        $this->middleware('auth:api')->except('index', 'show');
        $this->service = $service;
    }

    /**
     * @param PaginationRequest $request
     * @param int $productId
     *
     * @return Response
     */
    public function index(PaginationRequest $request, int $productId)
    {
        $reviews = $this->service->getReviews($request, $productId);
        $reviews = ReviewResource::collection($reviews);

        return response()->json($reviews, Response::HTTP_OK);
    }

    /**
     * @param  ReviewRequest $request
     * @param Product $product
     *
     * @return Response
     */
    public function store(ReviewRequest $request, Product $product)
    {
        $review = $this->service->create($request, $product->id);

        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_CREATED);
    }

    /**
     * @param int $productId
     * @param int $reviewId
     *
     * @return Response
     *
     * @throws ReviewException
     */
    public function show(int $productId, int $reviewId)
    {
        $this->isReviewBelongsToProduct($productId, $reviewId);

        $review = $this->service->getReview($reviewId);

        return response()->json($review, Response::HTTP_OK);
    }

    /**
     * @param ReviewRequest $request
     * @param int $productId
     * @param int $reviewId
     *
     * @return Response
     *
     * @throws ReviewException
     */
    public function update(ReviewRequest $request, int $productId, int $reviewId)
    {
        $this->isReviewBelongsToProduct($productId, $reviewId);

        $review = $this->service->update($request, $reviewId);

        return response([
            'data' => new ReviewResource($review)
        ], Response::HTTP_OK);
    }

    /**
     * @param int $productId
     * @param int $reviewId
     *
     * @return Response
     *
     * @throws ReviewException
     */
    public function destroy(int $productId, int $reviewId)
    {
        $this->isReviewBelongsToProduct($productId, $reviewId);

        $this->service->delete($reviewId);

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $productId
     * @param int $reviewId
     *
     * @throws ReviewNotBelongsToProduct
     */
    protected function isReviewBelongsToProduct(int $productId, int $reviewId)
    {
        $review = $this->service->getReview($reviewId);

        if ($review->product_id !== $productId) {
            throw new ReviewNotBelongsToProduct(sprintf(
                'Review %d not belongs to product %d',
                $review->id,
                $productId
            ));
        }
    }
}
