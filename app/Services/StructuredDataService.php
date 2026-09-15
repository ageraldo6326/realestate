<?php

namespace App\Services;

class StructuredDataService
{
    public function findings(string $type, $entity, $company): array
    {
        $metadata = $this->metadataFor($type, $entity, $company);
        if ($metadata === null) {
            return [];
        }

        $types = [];
        foreach ($metadata['schema'] ?? [] as $schema) {
            foreach ((array) ($schema['@type'] ?? []) as $schemaType) {
                $types[] = $schemaType;
            }
        }

        $required = ['property' => 'Product', 'post' => 'BlogPosting', 'zone' => 'BreadcrumbList'][$type] ?? null;
        if ($required === null || in_array($required, $types, true)) {
            return [];
        }

        return [[
            'rule_code' => 'SEO-SCHEMA-001',
            'severity' => 'medium',
            'message' => "Falta el dato estructurado requerido {$required}.",
            'evidence' => ['found_types' => $types],
        ]];
    }

    private function metadataFor(string $type, $entity, $company): ?array
    {
        $metadata = app(SeoMetadataService::class);

        if ($type === 'property') {
            return $metadata->forProperty($entity, $company);
        }
        if ($type === 'post') {
            return $metadata->forPost($entity, $company);
        }
        if ($type === 'zone') {
            return $metadata->forZone($entity, $company);
        }

        return null;
    }
}
