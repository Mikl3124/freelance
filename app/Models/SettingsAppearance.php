<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsAppearance extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'settings_appearance';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'home_image_id',
        'badge_short_text',
        'badge_long_text',
        'badge_link',
        'primary_link_text',
        'primary_link_target',
        'secondary_link_text',
        'secondary_link_target',
        'custom_hero_section_html',
        'show_featured_categories',
        'show_bestsellers',
    ];


    /**
     * Get home image
     *
     * @return object
     */
    public function homeImage()
    {
        return $this->belongsTo(FileManager::class, 'home_image_id');
    }
}
