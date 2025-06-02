<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\ChatDeleted;
use App\Http\Requests\CreateChatRequest;
use App\Http\Resources\Api\ChatResource;
use App\Models\Chat;
use App\Services\ChatService;
use App\Services\ChatSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

final class ChatController extends Controller
{
    public function __construct(
        private readonly ChatService $chatService,
        private readonly ChatSyncService $chatSyncService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $chats = $this->chatService->getChats();

        AnonymousResourceCollection::wrap('chats');

        return ChatResource::collection($chats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateChatRequest $request): ChatResource
    {
        $chat = DB::transaction(function () use ($request) {
            $chat = $this->chatService->createChat();

            $this->chatSyncService->syncParticipants($chat, $request->array('participant_ids'));
            $this->chatSyncService->syncMessages($chat, $request->array('messages'));

            return $chat;
        });

        $chat->load(['participants', 'messages']);

        return ChatResource::make($chat);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat): JsonResponse
    {
        abort_if($chat->creator_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        event(new ChatDeleted($chat));

        $this->chatService->deleteChat($chat);

        return response()->json(['message' => 'Chat deleted.'], Response::HTTP_NO_CONTENT);
    }
}
