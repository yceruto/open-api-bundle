<?php

namespace Yceruto\OpenApiBundle\OpenApi\Processor;

use OpenApi\Analysis;
use OpenApi\Annotations\AbstractAnnotation;
use OpenApi\Generator;
use OpenApi\Processors\ProcessorInterface;

readonly class CleanupComponents implements ProcessorInterface
{
    public function __invoke(Analysis $analysis): void
    {
        if (null === $openapi = $analysis->openapi) {
            return;
        }

        if (Generator::isDefault($openapi->components)) {
            return;
        }

        $this->removeDuplicatedResponses($analysis);
        $this->removeUselessSchemas($analysis);
    }

    public static function priority(): int
    {
        return -100;
    }

    protected function removeDuplicatedResponses(Analysis $analysis): void
    {
        if (null === $openapi = $analysis->openapi) {
            return;
        }

        $responses = [];
        foreach ($openapi->components->responses as $i => $response) {
            if (!isset($responses[$response->response])) {
                $responses[$response->response] = true;

                continue;
            }

            unset($openapi->components->responses[$i]);
            $this->detachAnnotationRecursively($response, $analysis);
        }
    }

    protected function removeUselessSchemas(Analysis $analysis): void
    {
        if (null === $openapi = $analysis->openapi) {
            return;
        }

        foreach ($openapi->components->schemas as $i => $schema) {
            foreach ($analysis->annotations as $annotation) {
                if (property_exists($annotation, 'ref') && (string) $annotation->ref === '#/components/schemas/'.$schema->schema) {
                    continue 2;
                }
            }

            $this->detachAnnotationRecursively($schema, $analysis);
            unset($openapi->components->schemas[$i]);
        }
    }

    protected function detachAnnotationRecursively(object|array $annotation, Analysis $analysis): void
    {
        if ($annotation instanceof AbstractAnnotation) {
            $analysis->annotations->detach($annotation);
        }

        foreach ($annotation as $field) {
            if (is_array($field) || $field instanceof AbstractAnnotation) {
                $this->detachAnnotationRecursively($field, $analysis);
            }
        }
    }
}
