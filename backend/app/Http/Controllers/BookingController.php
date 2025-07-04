<?php

namespace App\Http\Controllers;

use App\Contracts\BookingServiceInterface;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends BaseController
{
    /**
     * BookingController constructor.
     * @param BookingServiceInterface $bookingService
     */
    public function __construct(
        public BookingServiceInterface $bookingService
    ){}

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()
                ->json([
                    'message' => 'Unauthorized'
                ], Response::HTTP_UNAUTHORIZED);
        }

        $validated = $request->validated();

        try {
            $this
                ->bookingService
                ->bookRoom($user, $validated['room_id'], $validated['date']);

        } catch (\Exception $e) {
            $code = $e->getCode() === Response::HTTP_UNPROCESSABLE_ENTITY
                ? Response::HTTP_UNPROCESSABLE_ENTITY
                : Response::HTTP_INTERNAL_SERVER_ERROR;

            return response()
                ->json([
                    'message' => $e->getMessage()
                ], $code);
        }

        return response()
            ->json([
                'message' => 'Booking successful'
            ], Response::HTTP_CREATED);
    }
}
