<?php

namespace App\Services;

use App\Models\AuctionItem;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiRightsAnalysisService
{
    public function analyze(AuctionItem $item): string
    {
        $item->loadMissing(['registries', 'tenants', 'distributions']);

        $template = config('prompts.rights_analysis.user_template');
        $prompt = str_replace(
            ['{auction_item}', '{registries}', '{tenants}', '{distributions}'],
            [
                json_encode($this->formatAuctionItem($item), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                json_encode($item->registries->toArray(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                json_encode($item->tenants->toArray(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                json_encode($item->distributions->toArray(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
            ],
            $template
        );

        $content = config('prompts.rights_analysis.system') . "\n\n" . $prompt;

        $response = $this->callGemini($content);

        if ($response === null) {
            return '권리분석 요청 중 오류가 발생했습니다. API 키 및 네트워크를 확인해주세요.';
        }

        return $response;
    }

    private function formatAuctionItem(AuctionItem $item): array
    {
        return [
            'case_number' => $item->case_number,
            'location' => $item->location,
            'road_address' => $item->road_address,
            'property_type' => $item->property_type,
            'appraised_value' => $item->appraised_value,
            'lowest_bid_price' => $item->lowest_bid_price,
            'owner_name' => $item->owner_name,
            'creditor_name' => $item->creditor_name,
            'sale_conditions' => $item->sale_conditions,
            'cancellation_standard_date' => $item->cancellation_standard_date?->format('Y-m-d'),
            'total_registered_claims' => $item->total_registered_claims,
            'dividend_deadline' => $item->dividend_deadline?->format('Y-m-d'),
        ];
    }

    private function callGemini(string $content): ?string
    {
        $apiKey = config('gemini.api_key');
        $model = config('gemini.model');
        $baseUrl = config('gemini.base_url');

        if (empty($apiKey)) {
            Log::warning('GEMINI_API_KEY is not set');
            return null;
        }

        $url = "{$baseUrl}/models/{$model}:generateContent?key={$apiKey}";

        $response = Http::timeout(60)
            ->post($url, [
                'contents' => [
                    ['parts' => [['text' => $content]]],
                ],
                'generationConfig' => [
                    'temperature' => 0.3,
                    'maxOutputTokens' => 8192,
                ],
            ]);

        if (!$response->successful()) {
            Log::error('Gemini API error', ['response' => $response->json(), 'status' => $response->status()]);
            return null;
        }

        $data = $response->json();
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        return $text ?? null;
    }
}
