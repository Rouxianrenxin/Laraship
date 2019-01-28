<?php

$postClass = \Corals\Modules\CMS\Models\Post::class;

\DB::table('tags')->orderBy('tags.id')
    ->chunk(20, function ($oldTags) use ($postClass) {
        foreach ($oldTags as $oldTag) {
            $newTagId = \DB::table('utility_tags')->insertGetId([
                'name' => $oldTag->name,
                'slug' => $oldTag->slug,
                'module' => 'CMS',
                'status' => $oldTag->status
            ]);

            $oldPostTags = \DB::table('post_tag')->where('tag_id', $oldTag->id)->get();

            foreach ($oldPostTags as $postTag) {
                \DB::table('taggables')->insert([
                    'tag_id' => $newTagId,
                    'taggable_id' => $postTag->post_id,
                    'taggable_type' => $postClass
                ]);
            }
        }
    });

\Schema::dropIfExists('post_tag');
\Schema::dropIfExists('tags');