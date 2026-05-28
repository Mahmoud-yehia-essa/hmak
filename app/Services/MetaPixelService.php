<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MetaPixelService
{
    protected string $pixelId;
    protected string $accessToken;
    protected string $graphVersion = 'v20.0'; // use latest you’re comfortable with

    public function __construct()
    {
        $this->pixelId     = (string) config('services.facebook.pixel_id');
        $this->accessToken = (string) config('services.facebook.access_token');
    }

    /**
     * Send a server-side event to Meta (Conversions API)
     *
     * @param  string       $eventName      e.g. 'Purchase', 'Lead', 'CompleteRegistration'
     * @param  string|null  $eventId        Pass same ID to frontend fbq for deduplication
     * @param  array        $userDataRaw    ['email'=>..., 'phone'=>..., 'external_id'=>..., 'ip'=>..., 'ua'=>...]
     * @param  array        $customData     e.g. ['currency'=>'USD','value'=>99.99,'content_ids'=>['SKU123']]
     * @param  Request|null $request        To auto-fill IP/UA/fbc/fbp if not provided
     * @param  string|null  $testEventCode  From Events Manager → Test Events (optional)
     * @return array                        Meta API JSON response
     */
    public function sendEvent(
        string $eventName,
        ?string $eventId = null,
        array $userDataRaw = [],
        array $customData = [],
        ?Request $request = null,
        ?string $testEventCode = null
    ): array {
        // Build user_data with proper hashing/formatting
        $userData = $this->buildUserData($userDataRaw, $request);

        $payload = [
            'data' => [[
                'event_name'    => $eventName,
                'event_time'    => time(),           // Unix timestamp (seconds)
                'event_id'      => $eventId,         // for deduplication (optional but recommended)
                'user_data'     => $userData,
                'custom_data'   => $customData,
                'action_source' => 'website',
            ]],
            'access_token' => $this->accessToken,
        ];

        if ($testEventCode) {
            $payload['test_event_code'] = $testEventCode;
        }

        $url = "https://graph.facebook.com/{$this->graphVersion}/{$this->pixelId}/events";

        try {
            $response = Http::retry(3, 200)
                ->asJson()
                ->post($url, $payload);

            if ($response->failed()) {
                Log::warning('Meta Conversions API error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
            }

            return $response->json();
        } catch (\Throwable $e) {
            Log::error('Meta Conversions API exception', ['error' => $e->getMessage()]);
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }

    /**
     * Normalize + hash identifiers per Meta spec.
     * Email/phone/external_id must be SHA256 hashed.
     */
    protected function buildUserData(array $raw, ?Request $request = null): array
    {
        $email       = $raw['email']        ?? null;
        $phone       = $raw['phone']        ?? null;
        $externalId  = $raw['external_id']  ?? null; // your internal user ID (string)
        $ip          = $raw['ip']           ?? null;
        $ua          = $raw['ua']           ?? null;
        $fbc         = $raw['fbc']          ?? null;
        $fbp         = $raw['fbp']          ?? null;

        // If Request present, enrich automatically
        if ($request) {
            $ip = $ip ?: $request->ip();
            $ua = $ua ?: $request->userAgent();
            [$autoFbc, $autoFbp] = $this->extractFbCookies($request);
            $fbc = $fbc ?: $autoFbc;
            $fbp = $fbp ?: $autoFbp;
        }

        $data = [];

        if ($email) {
            $normalized = strtolower(trim($email));
            $data['em'] = hash('sha256', $normalized);
        }

        if ($phone) {
            // Keep digits only; include country code if you have it
            $digits = preg_replace('/\D+/', '', $phone);
            $data['ph'] = hash('sha256', $digits);
        }

        if ($externalId) {
            $data['external_id'] = hash('sha256', (string) $externalId);
        }

        if (!empty($ip)) $data['client_ip_address']  = $ip;
        if (!empty($ua)) $data['client_user_agent']  = $ua;
        if (!empty($fbc)) $data['fbc'] = $fbc;
        if (!empty($fbp)) $data['fbp'] = $fbp;

        return $data;
    }

    /**
     * Extract fbc/fbp (if your frontend Pixel has set them).
     * fbp is a first-party cookie set by the Pixel.
     * fbc can be created from fbclid in the URL: "fb.1.<timestamp>.<fbclid>"
     */
    protected function extractFbCookies(Request $request): array
    {
        $fbp = $request->cookie('_fbp', null);

        $fbc = $request->cookie('_fbc', null);
        if (!$fbc) {
            // If user arrived with fbclid query param, we can synthesize fbc
            $fbclid = $request->query('fbclid');
            if ($fbclid) {
                $fbc = 'fb.1.' . time() . '.' . $fbclid;
            }
        }

        return [$fbc, $fbp];
    }
}
