# PHP API Playground

Laravel 13 기반 PHP API 기본 구성 파악용 프로젝트입니다. Supabase PostgreSQL을 데이터베이스로 사용하며, Posts CRUD API, 경매 물건(Auction Items) CRUD·AI 권리분석(Gemini) API, Swagger(Scramble) 문서를 포함합니다.

---

## 목차

- [필수 요구사항](#필수-요구사항)
- [초기 환경 설정](#초기-환경-설정)
- [프로젝트 셋업](#프로젝트-셋업)
- [프로젝트 구조](#프로젝트-구조)
- [API 문서 (Swagger)](#api-문서-swagger)
- [주요 명령어](#주요-명령어)
- [트러블슈팅](#트러블슈팅)

---

## 필수 요구사항

| 항목     | 버전      |
| -------- | --------- |
| PHP      | 8.3 이상  |
| Composer | 최신 버전 |

> Node.js는 Laravel Blade 템플릿으로 화면을 구성할 때 필수는 아닙니다. Vite·npm 기반 프론트엔드 빌드가 필요할 때만 설치하면 됩니다.

---

## 초기 환경 설정

### 1. PHP 설치 (Windows)

1. [PHP Windows 다운로드](https://windows.php.net/download/) 에서 **VS16 x64 Non Thread Safe** 또는 **VS17 x64 Non Thread Safe** ZIP 다운로드
2. `C:\php` 등 원하는 경로에 압축 해제
3. **시스템 환경 변수**에 PHP 경로 추가:
    - `제어판` → `시스템` → `고급 시스템 설정` → `환경 변수`
    - `Path`에 PHP 폴더 경로 추가 (예: `C:\php`)
4. 터미널에서 확인:

    ```powershell
    php -v
    ```

### 2. PHP PostgreSQL 확장 활성화

Supabase(PostgreSQL) 연결을 위해 `pdo_pgsql` 확장이 필요합니다.

1. `php.ini` 파일 위치 확인:

    ```powershell
    php --ini
    ```

2. `Loaded Configuration File` 경로의 `php.ini`를 편집기로 열기
3. 다음 줄의 `;`(세미콜론) 제거:

    ```ini
    ;extension=pdo_pgsql
    ;extension=pgsql
    ```

    아래처럼 변경:

    ```ini
    extension=pdo_pgsql
    extension=pgsql
    ```

4. 확장 로드 확인:

    ```powershell
    php -m | findstr pgsql
    ```

    `pdo_pgsql`, `pgsql` 이 출력되면 정상입니다.

### 3. Composer 설치

1. [Composer 다운로드](https://getcomposer.org/download/) 에서 Windows용 설치 파일 다운로드
2. 설치向导 따라 진행 (PHP 경로가 자동 감지됨)
3. 터미널에서 확인:

    ```powershell
    composer -v
    ```

---

## 프로젝트 셋업

### 1. 의존성 설치

```powershell
composer install
```

### 2. 환경 설정 파일 생성

```powershell
copy .env.example .env
```

### 3. 애플리케이션 키 생성

```powershell
php artisan key:generate
```

### 4. Supabase 데이터베이스 연결 설정

`.env` 파일에서 다음 항목을 Supabase 프로젝트 정보로 수정합니다.

> **중요:** IPv4 네트워크에서는 **Session Pooler**를 사용해야 합니다.  
> Direct Connection은 IPv6 전용이라 대부분의 로컬 환경에서 연결이 되지 않습니다.

1. Supabase Dashboard → **Project Settings** → **Database**
2. **Connect** → **Connection String** → **Method**에서 **Session pooler** 선택
3. 표시된 연결 정보를 `.env`에 반영:

    ```env
    DB_CONNECTION=pgsql
    DB_HOST=aws-1-ap-south-1.pooler.supabase.com
    DB_PORT=5432
    DB_DATABASE=postgres
    DB_USERNAME=postgres.[프로젝트참조ID]
    DB_PASSWORD="[DB비밀번호]"
    DB_SSLMODE=require
    ```

    - `DB_USERNAME`: Session Pooler 사용 시 `postgres.프로젝트참조ID` 형식 (예: `postgres.gogkjiveegqgiuqzqaoy`)
    - `DB_PASSWORD`: 비밀번호에 특수문자(`!` 등)가 있으면 따옴표로 감싸기

### 5. 마이그레이션 실행

데이터베이스 테이블 생성:

```powershell
php artisan migrate
```

생성되는 테이블: `users`, `sessions`, `cache`, `jobs`, `posts`, `auction_items`, `auction_item_registries`, `auction_item_tenants`, `auction_item_distributions`, `password_reset_tokens` 등

### 6. 시드 데이터 (선택)

경매 물건 20건 시드:

```powershell
php artisan db:seed --class=AuctionItemSeeder
```

### 7. Gemini API 키 (권리분석용, 선택)

`.env`에 추가:

```env
GEMINI_API_KEY=your-gemini-api-key
GEMINI_MODEL=gemini-1.5-flash
```

[Google AI Studio](https://makersuite.google.com/)에서 API 키 발급

### 8. 개발 서버 실행

```powershell
php artisan serve
```

브라우저에서 `http://127.0.0.1:8000` 접속

---

## 프로젝트 구조

```
php-api-playground/
├── app/                    # 애플리케이션 핵심 코드
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/        # API 컨트롤러 (PostController, AuctionItemController)
│   │   ├── Requests/       # Form Request
│   │   └── Resources/      # API Resource
│   ├── Models/             # Eloquent 모델 (Post, AuctionItem 등)
│   ├── Services/           # GeminiRightsAnalysisService (권리분석)
│   └── Providers/         # 서비스 프로바이더
├── config/                 # 설정 파일
│   ├── gemini.php          # Gemini API 설정
│   └── prompts.php         # 권리분석 프롬프트 (유지보수용)
├── database/
│   ├── migrations/         # DB 마이그레이션
│   ├── factories/          # 모델 팩토리
│   └── seeders/            # 시더
├── public/                 # 웹 진입점
│   └── index.php
├── resources/
│   ├── views/              # Blade 뷰
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php             # 웹 라우트
│   ├── api.php             # API 라우트 (posts, auction-items, analyze)
│   └── console.php         # Artisan 명령
├── storage/                # 로그, 캐시, 세션
├── .env                    # 환경 변수 (git 제외)
├── .env.example            # 환경 변수 예시
├── artisan                 # Artisan CLI
├── composer.json           # PHP 의존성
└── README.md
```

---

## API 문서 (Swagger)

| URL | 설명 |
|-----|------|
| `http://127.0.0.1:8000/docs/api` | Swagger UI (API 문서) |
| `http://127.0.0.1:8000/docs/api.json` | OpenAPI JSON 스펙 |

Scramble을 사용해 라우트·FormRequest·Resource에서 자동으로 OpenAPI 문서를 생성합니다.

### Posts CRUD API 엔드포인트

| Method | URI | 설명 |
|--------|-----|------|
| GET | `/api/posts` | 게시글 목록 조회 |
| POST | `/api/posts` | 게시글 생성 |
| GET | `/api/posts/{id}` | 게시글 상세 조회 |
| PUT/PATCH | `/api/posts/{id}` | 게시글 수정 |
| DELETE | `/api/posts/{id}` | 게시글 삭제 |

### Auction Items API 엔드포인트

| Method | URI | 설명 |
|--------|-----|------|
| GET | `/api/auction-items` | 경매 물건 목록 조회 |
| POST | `/api/auction-items` | 경매 물건 생성 |
| GET | `/api/auction-items/{id}` | 경매 물건 상세 조회 |
| PUT/PATCH | `/api/auction-items/{id}` | 경매 물건 수정 |
| DELETE | `/api/auction-items/{id}` | 경매 물건 삭제 |
| POST | `/api/auction-items/{id}/analyze` | AI 권리분석 (Gemini) |

---

## 주요 명령어

| 명령어                                      | 설명                            |
| ------------------------------------------- | ------------------------------- |
| `php artisan serve`                         | 개발 서버 실행                  |
| `php artisan migrate`                       | 마이그레이션 실행 (테이블 생성) |
| `php artisan migrate:rollback`              | 마이그레이션 롤백               |
| `php artisan make:controller ApiController` | API 컨트롤러 생성               |
| `php artisan make:model Post -m`            | 모델 + 마이그레이션 생성        |
| `php artisan route:list`                    | 라우트 목록 조회                |
| `php artisan config:clear`                  | 설정 캐시 초기화                |

---

## 트러블슈팅

### `No application encryption key has been specified`

```powershell
php artisan key:generate
```

### `could not find driver` (PostgreSQL)

`php.ini`에서 `pdo_pgsql`, `pgsql` 확장 활성화 (위 [PHP PostgreSQL 확장 활성화](#2-php-postgresql-확장-활성화) 참고)

### `could not translate host name to address`

Direct Connection이 IPv6 전용이라 발생. **Session Pooler** 연결 정보로 `.env` 수정

### `relation "sessions" does not exist`

마이그레이션이 실행되지 않은 상태. 아래 명령 실행:

```powershell
php artisan migrate
```

---

## 참고 자료

- [Laravel 공식 문서](https://laravel.com/docs)
- [Supabase Database 연결 가이드](https://supabase.com/docs/guides/database/connecting-to-postgres)
- [Laravel Learn (한글)](https://laravel.com/learn)
