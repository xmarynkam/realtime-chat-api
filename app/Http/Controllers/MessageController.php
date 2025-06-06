<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\MessageDeleted;
use App\Events\MessageSent;
use App\Events\MessageUpdated;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Http\Resources\Api\MessageResource;
use App\Models\Message;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class MessageController extends Controller
{
    public function __construct(
        private readonly MessageService $messageService,
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMessageRequest $request): JsonResponse
    {
        $message = $this->messageService->createMessage($request->validated());

        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => MessageResource::make($message),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message): MessageResource
    {
        $message = $this->messageService->updateMessage($message, $request->validated());

        broadcast(new MessageUpdated($message))->toOthers();

        return MessageResource::make($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message): JsonResponse
    {
        abort_if($message->receiver_id !== auth()->id(), Response::HTTP_FORBIDDEN);

        $this->messageService->deleteMessage($message);

        broadcast(new MessageDeleted($message))->toOthers();

        return response()->json(['message' => 'Message deleted.'], Response::HTTP_NO_CONTENT);
    }
}
