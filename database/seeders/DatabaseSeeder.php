<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Code;
use App\Models\Notes;
use App\Models\Publisher;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Tags\Tag;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // import the latest database
        require __DIR__ . '/downloads/11_19_21.php';

        // create users
        foreach ($users as $user) {
            User::firstOrCreate($user);
        }

        // create authors
        foreach ($authors as $author) {
            Author::firstOrCreate([
                'id' => $author['id'],
                'first_name' => $author['first_name'],
                'last_name' => $author['last_name']
            ]);
        }

        // create publishers
        foreach ($publishers as $publisher) {
            Publisher::firstOrCreate([
                'title' => $publisher['title']
            ]);
        }

        // Create References
        foreach ($references as $reference) {
            Reference::firstOrCreate([
                'title' => $reference['title'],
                'book_title' => $reference['book_title'],
                'year' => $reference['year'],
                'publisher_id' => $reference['publisher_id'],
                'city' => $reference['city'],
                'type' => $reference['type'],
                'volume' => $reference['volume'],
                'journal' => $reference['journal'],
                'issue' => $reference['issue'],
                'pages' => $reference['pages'],
            ]);
        }

        // Create Codes
        foreach ($codes as $code) {
            Code::firstOrCreate([
                'body' => $code['body'],
                'pages' => $code['pages'],
                'reference_id' => $code['reference_id'],
                'notes' => $code['notes'],
            ]);
        }

        // Notes
        foreach ($notes as $note) {
            Notes::firstOrCreate([
                'order' => $note['order'],
                'title' => $note['title'],
                'description' => $note['description'],
                'code_id' => $note['code_id']
            ]);
        }

        foreach ($userables as $userable) {
            if (DB::table('userables')->where([
                ['user_id', '=', $userable['user_id']],
                ['userable_type', '=', $userable['userable_type']],
                ['userable_id', '=', $userable['userable_id']]
            ])->doesntExist()) {
                DB::table('userables')->insert([
                    'user_id' => $userable['user_id'],
                    'userable_type' => $userable['userable_type'],
                    'userable_id' => $userable['userable_id']
                ]);
            }


        }

        foreach ($tags as $tag) {
            Tag::firstOrCreate([
                'name' => $tag['name'],
                'type' => $tag['type'],
                'order_column' => $tag['order_column']
            ]);
        }

        foreach ($taggables as $taggable) {
            if (DB::table('taggables')->where([
                ['tag_id', '=', $taggable['tag_id']],
                ['taggable_type', '=', $taggable['taggable_type']],
                ['taggable_id', '=', $taggable['taggable_id']]
            ])->doesntExist()) {
                DB::table('taggables')->insert([
                    'tag_id' => $taggable['tag_id'],
                    'taggable_type' => $taggable['taggable_type'],
                    'taggable_id' => $taggable['taggable_id']
                ]);
            }

        }

        foreach ($author_reference as $author) {
            if (DB::table('author_reference')->where([
                ['author_id', '=', $author['author_id']],
                ['role', '=', $author['role']],
                ['reference_id', '=', $author['reference_id']]
            ])->doesntExist()) {
                DB::table('author_reference')->insert([
                    'author_id' => $author['author_id'],
                    'role' => $author['role'],
                    'reference_id' => $author['reference_id']
                ]);
            }
        }

    }
}
