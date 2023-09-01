<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'pk' => $this->id,
            'task-title' => $this->title,
            'task-details' => $this->info,
            'task-details-length' => strlen($this->info),
            'task-sub-category-id' => $this->sub_category_id,
            'task-sub-category-name' => $this->subCategory->name,
            'created-since' => $this->created_at->diffForHumans(),
            'can-update' => auth('user-api')->user()->hasPermissionTo('Update-Task'),
            'can-delete' => $this->when(auth('user-api')->user()->hasPermissionTo('Delete-Task'), 'Delete Enabled'),
            $this->mergeWhen(auth('user-api')->user()->hasPermissionTo('Delete-Task'), [
                'delete-enabled' => true,
                'is-deleted' => false,
            ]),
        ];
    }
}
