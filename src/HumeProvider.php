<?php

declare(strict_types=1);

namespace AiSdk\Hume;

use AiSdk\Contracts\BaseProvider;
use AiSdk\Contracts\SpeechModelInterface;
use AiSdk\Contracts\SpeechProviderInterface;
use AiSdk\Hume\Models\HumeSpeechModel;

final class HumeProvider extends BaseProvider implements SpeechProviderInterface
{
    public function __construct(public readonly HumeOptions $options) {}
    public function name(): string
    {
        return HumeOptions::PROVIDER_NAME;
    }
    protected function speechModel(string $modelId): SpeechModelInterface
    {
        return new HumeSpeechModel($modelId, $this->options);
    }
}
