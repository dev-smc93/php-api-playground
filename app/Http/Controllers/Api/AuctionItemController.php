<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuctionItemRequest;
use App\Http\Requests\UpdateAuctionItemRequest;
use App\Http\Resources\AuctionItemResource;
use App\Models\AuctionItem;
use App\Services\GeminiRightsAnalysisService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class AuctionItemController extends Controller
{
    /**
     * 경매 물건 목록 조회
     */
    public function index(): AnonymousResourceCollection
    {
        $items = AuctionItem::query()
            ->with(['registries', 'tenants', 'distributions'])
            ->orderByDesc('created_at')
            ->get();

        return AuctionItemResource::collection($items);
    }

    /**
     * 경매 물건 생성
     */
    public function store(StoreAuctionItemRequest $request): JsonResponse
    {
        $item = DB::transaction(function () use ($request) {
            $item = AuctionItem::query()->create($request->safe()->except(['registries', 'tenants', 'distributions']));
            $this->syncNested($item, $request->validated());
            return $item->load(['registries', 'tenants', 'distributions']);
        });

        return (new AuctionItemResource($item))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * 경매 물건 상세 조회
     */
    public function show(AuctionItem $auctionItem): AuctionItemResource
    {
        $auctionItem->load(['registries', 'tenants', 'distributions']);

        return new AuctionItemResource($auctionItem);
    }

    /**
     * 경매 물건 수정
     */
    public function update(UpdateAuctionItemRequest $request, AuctionItem $auctionItem): AuctionItemResource
    {
        DB::transaction(function () use ($request, $auctionItem) {
            $auctionItem->update($request->safe()->except(['registries', 'tenants', 'distributions']));
            $this->syncNested($auctionItem, $request->validated());
        });

        return new AuctionItemResource($auctionItem->fresh(['registries', 'tenants', 'distributions']));
    }

    /**
     * 경매 물건 삭제
     */
    public function destroy(AuctionItem $auctionItem): JsonResponse
    {
        $auctionItem->delete();

        return response()->json(null, 204);
    }

    /**
     * AI 권리분석 (Gemini)
     */
    public function analyze(AuctionItem $auctionItem, GeminiRightsAnalysisService $service): JsonResponse
    {
        $analysis = $service->analyze($auctionItem);

        return response()->json(['analysis' => $analysis]);
    }

    private function syncNested(AuctionItem $item, array $validated): void
    {
        if (isset($validated['registries'])) {
            $item->registries()->delete();
            foreach ($validated['registries'] as $r) {
                $item->registries()->create($r);
            }
        }
        if (isset($validated['tenants'])) {
            $item->tenants()->delete();
            foreach ($validated['tenants'] as $t) {
                $item->tenants()->create($t);
            }
        }
        if (isset($validated['distributions'])) {
            $item->distributions()->delete();
            foreach ($validated['distributions'] as $d) {
                $item->distributions()->create($d);
            }
        }
    }
}
