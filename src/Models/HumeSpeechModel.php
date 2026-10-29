<?php

declare(strict_types=1);

namespace AiSdk\Hume\Models;

use AiSdk\Contracts\BaseModel;
use AiSdk\Contracts\SpeechModelInterface;
use AiSdk\Exceptions\InvalidArgumentException;
use AiSdk\Hume\HumeOptions;
use AiSdk\Requests\SpeechRequest;
use AiSdk\Responses\SpeechResponse;
use AiSdk\Results\AudioData;
use AiSdk\Support\Usage;
use AiSdk\Utils\Support\Url;

final class HumeSpeechModel extends BaseModel implements SpeechModelInterface
{
    public function __construct(
        private readonly string $modelId,
        private readonly HumeOptions $options,
    ) {}
    public function provider(): string
    {
        return HumeOptions::PROVIDER_NAME;
    }
    public function modelId(): string
    {
        return $this->modelId;
    }

    public function generate(SpeechRequest $request): SpeechResponse
    {
        $options = $request->providerOptionsFor($this->provider());
        $voice = $request->voice ?? ($options['voice_id'] ?? null);
        if (! is_string($voice) || $voice === '') {
            throw new InvalidArgumentException('Hume speech requires ->voice("voice-id").');
        }
        unset($options['voice_id']);
        $format = in_array($request->format, ['mp3', 'wav', 'pcm'], true) ? $request->format : 'mp3';
        $body = array_replace(['utterances' => [['text' => $request->input, 'voice' => ['id' => $voice, 'provider' => 'HUME_AI']]], 'format' => ['type' => $format]], $options);
        $response = $this->runner($this->options->sdk)->postRaw(Url::joinPath($this->options->baseUrl, '/v0/tts/file'), $body, $this->options->authHeaders(), $this->provider());
        return new SpeechResponse(new AudioData((string) $response->getBody(), $response->getHeaderLine('Content-Type') ?: $this->mime($format)), new Usage(), [], ['hume' => ['model' => $this->modelId, 'voice_id' => $voice]]);
    }
    private function mime(string $format): string
    {
        return match ($format) {
            'wav' => 'audio/wav', 'pcm' => 'audio/pcm', default => 'audio/mpeg',
        };
    }
}
