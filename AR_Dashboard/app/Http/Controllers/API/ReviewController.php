<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Resources\Review as ReviewResource;

use App\Models\ArtObject;
use App\Models\Review;

class ReviewController extends BaseController
{
    public function getReview($id)
    {
        $review = Review::where('art_object_id', $id)->get();
        if ($review != null && !$review->isEmpty()) {
            $status = true;
        } else {
            $status = false;
        }

        return $this->sendResponse(ReviewResource::collection($review), 'Review retrieved successfully.', $status);
    }

    public function postReview(Request $request)
    {
        $request->validate([
            'art_object_id' => 'required',
            'review' => 'required'
        ]);

        Review::create([
            'art_object_id' => $request->art_object_id,
            'review' => $request->review
        ]);

        return response()->json('Success!');
    }
}
