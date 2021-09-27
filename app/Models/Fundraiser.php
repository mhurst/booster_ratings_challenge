<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;

class Fundraiser extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table = 'fundraisers';

    /**
     * Get the ratings for a fundraiser.
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public static function GetFundraisersWithAvgRating()
    {
        $fundraisers = DB::table('fundraisers')
                        ->selectRaw('
                            fundraisers.id as fundraiser_id,
                            fundraisers.name as fundraiser_name,
                            Round(Avg(ratings.rating)) as average_rating
                        ')
                        ->leftjoin('ratings', 'fundraisers.id', '=', 'ratings.fundraisers_id')
                        ->groupBy('fundraisers.name')
                        ->orderBy('average_rating', 'desc')
                        ->get();

        return $fundraisers;
    }
}
