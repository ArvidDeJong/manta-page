<?php

namespace Darvis\MantaPage\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Manta\FluxCMS\Traits\HasUploadsTrait;
use Manta\FluxCMS\Traits\HasTranslationsTrait;

class Page extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUploadsTrait;
    use HasTranslationsTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'manta_pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'created_by',
        'updated_by',
        'deleted_by',
        'company_id',
        'host',
        'pid',
        'locale',
        'description',
        'title',
        'title_2',
        'title_3',
        'title_4',
        'slug',
        'seo_title',
        'seo_description',
        'excerpt',
        'content',
        'template',
        'homepage',
        'homepageSort',
        'locked',
        'fullpage',
        'link',
        'route',
        'route_title',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'data',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'option_1' => 'boolean',
        'option_2' => 'boolean',
        'option_3' => 'boolean',
        'option_4' => 'boolean',
        'data' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];


    /**
     * @param mixed $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }

    public static function getMantaAttribute($id, $attribute = 'title', $edit = false)
    {
        // Retrieve the page using the id
        $page = Page::find($id);

        // Check if the page exists
        if (!$page) {
            echo "Page not found";
            return;
        }

        // Translate the page attributes
        $translatedPage = translate($page);

        // Display the translated attribute result
        if (isset($translatedPage['result']->$attribute)) {
            echo htmlspecialchars($translatedPage['result']->$attribute, ENT_QUOTES, 'UTF-8');
        } else {
            echo "Attribute not found";
            return;
        }

        // Check if editing is allowed, and the user is authenticated as staff
        if ($edit && !empty(auth('staff')->user())) {
            $link = route('page.read', ['page' => $page]);
            // Output the edit link
            echo <<<HTML
            <p>
                <a href="$link" style="text-decoration: none;">
                    <i class="fa-solid fa-pen-to-square"></i> Tekst
                </a>
            </p>
        HTML;
        }
    }

    public static function getMantaLink($id)
    {
        $page = Page::find($id);
        if (!$page) {
            return '#link-' . $id;
        }
        echo route('website.page', ['slug' => $page->slug]);
    }
}
