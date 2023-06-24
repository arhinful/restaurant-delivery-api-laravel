<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function __construct($resource, public array $conversions=[])
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'custom_properties' => $this->custom_properties,
            'url' => $this->getUrl(),
            'conversions' => $this->convertedImages()
        ];
    }

    public static function collection($resource){
        $data = collect();
        foreach ($resource as $item){
            $data->add(new MediaResource($item));
        }
        return $data;
    }

    private function convertedImages(): array{
        $conversions = [];
        if ($this->conversions && count($this->conversions) > 0){
            foreach ($this->conversions as $conversion) {
                $conversions[$conversion] = [
                    'url' =>  $this->getUrl($conversion)
                ];
            }
        }
        return $conversions;
    }
}
