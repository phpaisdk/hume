# aisdk/hume

<a href="https://github.com/phpaisdk/hume/actions"><img alt="GitHub Workflow Status" src="https://img.shields.io/github/actions/workflow/status/phpaisdk/hume/tests.yml?branch=main&label=Tests"></a>
<a href="https://packagist.org/packages/aisdk/hume"><img alt="Latest Version" src="https://img.shields.io/packagist/v/aisdk/hume"></a>
<a href="https://packagist.org/packages/aisdk/hume"><img alt="License" src="https://img.shields.io/packagist/l/aisdk/hume"></a>

------

Official Hume provider for the PHP AI SDK. Uses Hume's native expressive text-to-speech API.

## Installation

```bash
composer require aisdk/hume
```

## Basic Usage

```php
use AiSdk\Generate;
use AiSdk\Hume;

Hume::create(['apiKey' => $_ENV['HUME_API_KEY']]);

$result = Generate::speech('Hello from Hume.')
    ->model(Hume::model('default'))
    ->voice('your-hume-voice-id')
    ->run();
```

## Configuration

| Variable | Description | Default |
| --- | --- | --- |
| `HUME_API_KEY` | API key for authentication | Required |
| `HUME_BASE_URL` | Base URL for API requests | `https://api.hume.ai` |

## Supported Capabilities

| Capability | Support |
| --- | --- |
| Text-to-speech | Native `POST /v0/tts/file` |
| Hume voice ID | Portable `->voice()` option |

Use `providerOptions('hume', [...])` for Hume text-to-speech request fields. EVI speech-to-speech sessions use Hume's separate WebSocket API and are outside this package's current scope.

## Documentation

- [Hume TTS API reference](https://dev.hume.ai/reference/text-to-speech/tts/synthesize-file)
- [PHP AI SDK documentation](https://phpaisdk.com/docs/hume)
