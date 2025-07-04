<?php

namespace App\Http\Controllers;

use App\Contracts\RoomServiceInterface;
use App\Http\Requests\RoomListRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\RoomResource;

class RoomController extends Controller
{
    /**
     * RoomController constructor.
     * @param RoomServiceInterface $roomService
     */
    public function __construct(
        public RoomServiceInterface $roomService
    ){}

    /**
     * Получить список свободных номеров на указанные даты или на неделю вперед.
     */
    public function index(RoomListRequest $request)
    {
        $rooms = $this
            ->roomService
            ->getFreeRooms($request->validated());

        return response()->json(RoomResource::collection($rooms), Response::HTTP_OK);
    }
}
