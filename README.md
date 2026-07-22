# Hume provider for PHP AI SDK

```bash
composer require aisdk/hume
```

```php
use AiSdk\Hume;
use AiSdk\Generate;

Hume::create(['apiKey' => $_ENV['HUME_API_KEY']]);

$result = Generate::speech('Hello from Hume.')
    ->model(Hume::model('default'))
    ->voice('your-hume-voice-id')
    ->run();
```

This package uses Hume's expressive text-to-speech endpoint at `POST /v0/tts/file`. Supply a Hume voice ID with `->voice()`; provider options are forwarded to Hume's native request body. EVI speech-to-speech sessions use Hume's separate WebSocket API. See [Hume's API reference](https://dev.hume.ai/reference/text-to-speech/tts/synthesize-file).
