<?php

declare(strict_types=1);

use AiSdk\Generate;
use AiSdk\Hume;
use AiSdk\Support\Sdk;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Response;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

afterEach(function (): void {
    Generate::reset();
    Hume::reset();
});

it('uses Hume expressive text-to-speech', function (): void {
    $client = new class implements ClientInterface {
        public ?RequestInterface $request = null;
        public function sendRequest(RequestInterface $request): ResponseInterface
        {
            $this->request = $request;
            return new Response(200, ['Content-Type' => 'audio/mpeg'], 'audio-bytes');
        }
    };
    $factory = new Psr17Factory();
    Generate::configure(new Sdk($client, $factory, $factory));
    Hume::create(['apiKey' => 'hume-test']);
    $result = Generate::speech('Hello from Hume')->model(Hume::model('default'))->voice('voice-id')->run();
    $body = json_decode((string) $client->request?->getBody(), true);
    expect($result->output->data)->toBe('audio-bytes')->and((string) $client->request?->getUri())->toBe('https://api.hume.ai/v0/tts/file')->and($client->request?->getHeaderLine('X-Hume-Api-Key'))->toBe('hume-test')->and($body['utterances'][0]['voice']['id'])->toBe('voice-id');
});
