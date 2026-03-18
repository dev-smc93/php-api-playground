<?php

namespace Database\Seeders;

use App\Models\AuctionItem;
use App\Models\AuctionItemDistribution;
use App\Models\AuctionItemRegistry;
use App\Models\AuctionItemTenant;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AuctionItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'case_number' => '2023타경110689',
                'court_name' => '서울중앙지방법원 경매1계',
                'location' => '서울특별시 동작구 사당동 422-3',
                'road_address' => '서울 동작구 사당로22길 84',
                'property_type' => '다가구(원룸등)',
                'case_registered_at' => '2023-07-27',
                'auction_type' => '임의경매',
                'land_area_sqm' => 122,
                'building_area_sqm' => 244.88,
                'owner_name' => '유승호',
                'debtor_name' => '유승호',
                'creditor_name' => '낙성대새마을금고',
                'appraised_value' => 1968638200,
                'lowest_bid_price' => 1259929000,
                'deposit_amount' => 125992900,
                'dividend_deadline' => '2024-10-25',
                'sale_conditions' => '임차권등기',
                'cancellation_standard_date' => '2020-01-02',
                'total_registered_claims' => 1566000000,
                'registries' => [
                    ['rank' => 1, 'receipt_date' => '2020-01-02', 'right_type' => '소유권', 'right_holder' => '유승호', 'claim_amount' => null, 'discharge_status' => '이전'],
                    ['rank' => 2, 'receipt_date' => '2019-07-03', 'right_type' => '근저당', 'right_holder' => '낙성대새마을금고', 'claim_amount' => 891000000, 'discharge_status' => '말소기준'],
                    ['rank' => 3, 'receipt_date' => '2020-03-15', 'right_type' => '근저당', 'right_holder' => '판테온대부주식회사', 'claim_amount' => 250000000, 'discharge_status' => '말소'],
                    ['rank' => 4, 'receipt_date' => '2020-05-20', 'right_type' => '근저당', 'right_holder' => '황갑순', 'claim_amount' => 145000000, 'discharge_status' => '말소'],
                    ['rank' => 5, 'receipt_date' => '2023-07-31', 'right_type' => '임의경매', 'right_holder' => '낙성대새마을금고', 'claim_amount' => 810000000, 'discharge_status' => null, 'remarks' => '2023타경110689'],
                ],
                'tenants' => [
                    ['tenant_name' => '하상엽', 'occupancy_status' => '주거용 301호', 'move_in_date' => '2020-01-21', 'fixed_date' => '2020-01-28', 'dividend_request_date' => '2023-09-25', 'deposit_amount' => 190000000, 'monthly_rent' => null, 'has_opposing_power' => false],
                    ['tenant_name' => '이은지', 'occupancy_status' => '주거용 203호', 'move_in_date' => '2020-01-23', 'fixed_date' => '2020-01-07', 'dividend_request_date' => '2023-10-13', 'deposit_amount' => 150000000, 'monthly_rent' => 70000, 'has_opposing_power' => false],
                    ['tenant_name' => '남민식', 'occupancy_status' => 'BI02호', 'move_in_date' => '2020-02-21', 'fixed_date' => '2020-01-28', 'dividend_request_date' => '2023-08-28', 'deposit_amount' => 90000000, 'monthly_rent' => null, 'has_opposing_power' => false, 'remarks' => '최우선변제대상'],
                ],
                'distributions' => [
                    ['rank' => 1, 'claim_type' => '매각대금', 'creditor_name' => null, 'claim_amount' => 1259929000, 'distributed_amount' => 1259929000],
                    ['rank' => 2, 'claim_type' => '경매비용', 'creditor_name' => null, 'claim_amount' => 8019621, 'distributed_amount' => 8019621],
                    ['rank' => 3, 'claim_type' => '주거(소액)', 'creditor_name' => '남민식', 'claim_amount' => 90000000, 'distributed_amount' => 37000000],
                    ['rank' => 4, 'claim_type' => '근저당', 'creditor_name' => '낙성대새마을금고', 'claim_amount' => 891000000, 'distributed_amount' => 891000000],
                    ['rank' => 5, 'claim_type' => '주거임차인', 'creditor_name' => '이은지', 'claim_amount' => 150000000, 'distributed_amount' => 150000000],
                    ['rank' => 6, 'claim_type' => '주거임차인', 'creditor_name' => '하상엽', 'claim_amount' => 190000000, 'distributed_amount' => 173909379, 'unpaid_amount' => 16090621],
                ],
            ],
        ];

        $seoulLocations = [
            ['loc' => '서울특별시 강남구 역삼동 123-45', 'road' => '서울 강남구 테헤란로 123'],
            ['loc' => '서울특별시 서초구 서초동 456-78', 'road' => '서울 서초구 강남대로 456'],
            ['loc' => '서울특별시 마포구 연남동 789-12', 'road' => '서울 마포구 월드컵로 78'],
            ['loc' => '서울특별시 송파구 잠실동 234-56', 'road' => '서울 송파구 올림픽로 234'],
            ['loc' => '서울특별시 영등포구 여의도동 345-67', 'road' => '서울 영등포구 여의대로 345'],
            ['loc' => '서울특별시 용산구 이태원동 456-78', 'road' => '서울 용산구 이태원로 456'],
            ['loc' => '서울특별시 종로구 평창동 567-89', 'road' => '서울 종로구 평창문화로 56'],
            ['loc' => '서울특별시 성동구 왕십리동 678-90', 'road' => '서울 성동구 왕십리로 678'],
            ['loc' => '서울특별시 광진구 자양동 789-01', 'road' => '서울 광진구 아차산로 789'],
            ['loc' => '서울특별시 강서구 화곡동 890-12', 'road' => '서울 강서구 화곡로 890'],
            ['loc' => '서울특별시 노원구 중계동 901-23', 'road' => '서울 노원구 동일로 901'],
            ['loc' => '서울특별시 도봉구 방학동 012-34', 'road' => '서울 도봉구 방학로 123'],
            ['loc' => '서울특별시 성북구 정릉동 123-45', 'road' => '서울 성북구 정릉로 234'],
            ['loc' => '서울특별시 은평구 녹번동 234-56', 'road' => '서울 은평구 통일로 345'],
            ['loc' => '서울특별시 양천구 목동 345-67', 'road' => '서울 양천구 오목로 456'],
            ['loc' => '서울특별시 구로구 개봉동 456-78', 'road' => '서울 구로구 경인로 567'],
            ['loc' => '서울특별시 금천구 시흥동 567-89', 'road' => '서울 금천구 시흥대로 678'],
            ['loc' => '서울특별시 관악구 신림동 678-90', 'road' => '서울 관악구 신림로 789'],
        ];

        $propertyTypes = ['다가구(원룸등)', '단독주택', '아파트', '오피스텔', '상가'];
        $creditors = ['낙성대새마을금고', 'NH농협은행', '신한은행', '우리은행', 'KB국민은행', '하나은행'];
        $auctionTypes = ['임의경매', '강제경매'];

        for ($i = 0; $i < 20; $i++) {
            $base = $items[0] ?? null;
            $loc = $seoulLocations[$i % count($seoulLocations)];
            $year = 2023 + ($i % 2);
            $caseNum = sprintf('%d타경%06d', $year, 110689 + $i * 111);
            $appraised = 800000000 + ($i * 50000000) + random_int(0, 200000000);
            $lowest = (int) ($appraised * (0.55 + $i * 0.02));
            $deposit = (int) ($lowest * 0.1);

            $item = AuctionItem::query()->create([
                'case_number' => $caseNum,
                'court_name' => '서울중앙지방법원 경매' . (($i % 3) + 1) . '계',
                'location' => $loc['loc'],
                'road_address' => $loc['road'],
                'property_type' => $propertyTypes[$i % count($propertyTypes)],
                'case_registered_at' => Carbon::now()->subYears(2)->addDays($i * 15),
                'auction_type' => $auctionTypes[$i % 2],
                'land_area_sqm' => 80 + ($i * 5),
                'building_area_sqm' => 150 + ($i * 10),
                'owner_name' => ['김철수', '이영희', '박민수', '최지현', '정대호'][$i % 5],
                'debtor_name' => ['김철수', '이영희', '박민수', '최지현', '정대호'][$i % 5],
                'creditor_name' => $creditors[$i % count($creditors)],
                'appraised_value' => $appraised,
                'lowest_bid_price' => $lowest,
                'deposit_amount' => $deposit,
                'dividend_deadline' => Carbon::now()->addMonths(6),
                'sale_conditions' => $i % 3 === 0 ? '임차권등기' : ($i % 3 === 1 ? '일괄매각' : null),
                'cancellation_standard_date' => Carbon::now()->subYears(4)->addDays($i),
                'total_registered_claims' => (int) ($appraised * (0.6 + $i * 0.02)),
            ]);

            // Registries
            $registryCount = 3 + ($i % 3);
            for ($r = 1; $r <= $registryCount; $r++) {
                AuctionItemRegistry::query()->create([
                    'auction_item_id' => $item->id,
                    'rank' => $r,
                    'receipt_date' => Carbon::now()->subYears(4)->addMonths($r),
                    'right_type' => $r === 1 ? '소유권' : ($r === 2 ? '근저당' : '근저당'),
                    'right_holder' => $r === 1 ? $item->owner_name : ($r === 2 ? $item->creditor_name : '판테온대부주식회사'),
                    'claim_amount' => $r === 1 ? null : ($r === 2 ? (int)($appraised * 0.45) : (int)($appraised * 0.15)),
                    'discharge_status' => $r === 1 ? '이전' : ($r === 2 ? '말소기준' : '말소'),
                ]);
            }

            // Tenants (0~4명)
            $tenantCount = $i % 5;
            $tenantNames = ['하상엽', '이은지', '손범수', '남민식', '김태희', '정우성', '송혜교'];
            for ($t = 0; $t < $tenantCount; $t++) {
                AuctionItemTenant::query()->create([
                    'auction_item_id' => $item->id,
                    'tenant_name' => $tenantNames[$t % count($tenantNames)],
                    'occupancy_status' => '주거용 ' . (201 + $t * 10) . '호',
                    'move_in_date' => Carbon::now()->subYears(3)->addMonths($t),
                    'fixed_date' => Carbon::now()->subYears(3)->addMonths($t)->addDays(7),
                    'dividend_request_date' => Carbon::now()->subMonths(6),
                    'deposit_amount' => 50000000 + ($t * 30000000),
                    'monthly_rent' => $t % 2 === 0 ? 50000 : null,
                    'has_opposing_power' => $t === 0 && $i % 4 === 0,
                ]);
            }

            // Distributions
            AuctionItemDistribution::query()->create([
                'auction_item_id' => $item->id,
                'rank' => 1,
                'claim_type' => '매각대금',
                'claim_amount' => $lowest,
                'distributed_amount' => $lowest,
            ]);
            AuctionItemDistribution::query()->create([
                'auction_item_id' => $item->id,
                'rank' => 2,
                'claim_type' => '근저당',
                'creditor_name' => $item->creditor_name,
                'claim_amount' => (int)($appraised * 0.45),
                'distributed_amount' => (int)($appraised * 0.45),
            ]);
        }

        // 첫 번째 항목은 이미지 기반 상세 데이터로 덮어쓰기
        $first = AuctionItem::query()->first();
        if ($first) {
            $first->registries()->delete();
            $first->tenants()->delete();
            $first->distributions()->delete();
            $first->update([
                'case_number' => '2023타경110689',
                'court_name' => '서울중앙지방법원 경매1계',
                'location' => '서울특별시 동작구 사당동 422-3',
                'road_address' => '서울 동작구 사당로22길 84',
                'property_type' => '다가구(원룸등)',
                'case_registered_at' => '2023-07-27',
                'auction_type' => '임의경매',
                'land_area_sqm' => 122,
                'building_area_sqm' => 244.88,
                'owner_name' => '유승호',
                'debtor_name' => '유승호',
                'creditor_name' => '낙성대새마을금고',
                'appraised_value' => 1968638200,
                'lowest_bid_price' => 1259929000,
                'deposit_amount' => 125992900,
                'dividend_deadline' => '2024-10-25',
                'sale_conditions' => '임차권등기',
                'cancellation_standard_date' => '2020-01-02',
                'total_registered_claims' => 1566000000,
            ]);
            foreach ($items[0]['registries'] as $r) {
                $first->registries()->create($r);
            }
            foreach ($items[0]['tenants'] as $t) {
                $first->tenants()->create($t);
            }
            foreach ($items[0]['distributions'] as $d) {
                $first->distributions()->create($d);
            }
        }
    }
}
