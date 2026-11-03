# PHP AI SDK — Hume

Speech generation with Hume for the framework-agnostic [PHP AI SDK](https://phpaisdk.com).

## Installation

```bash
composer require aisdk/hume
```

Set `HUME_API_KEY` in your environment and replace `your-voice-id` with a voice from your Hume account.

## Usage

```php
use AiSdk\Generate;
use AiSdk\Hume;

$result = Generate::speech('Welcome to the PHP AI SDK.')
    ->model(Hume::model('default'))
    ->voice('your-voice-id')
    ->providerOptions('hume', ['version' => '2'])
    ->run();

$result->output->save(__DIR__.'/speech.mp3');
```

Hume selects Octave through the `version` provider option; the SDK model ID is a local reference.

## Documentation

[Read the documentation](https://phpaisdk.com/docs/0.x/providers/hume) for configuration, supported features, and more examples.

[Contributing](https://github.com/phpaisdk/.github/blob/main/CONTRIBUTING.md) · [Support](https://github.com/phpaisdk/.github/blob/main/SUPPORT.md)

## License

The MIT License (MIT). See [LICENSE](LICENSE) for details.
