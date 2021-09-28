<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Fundraiser;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['fundraisers_id', 'reviewer_id', 'rating', 'review', 'review_date'];
    protected $table = 'ratings';

    /**
     * Get the fundraiser that owns the rating.
     */
    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public static function GetRatingsByFundraiser($id)
    {
        $fundraisers = DB::table('ratings')
                        ->selectRaw('
                            ratings.rating as rating,
                            ratings.review as review,
                            ratings.review_date as review_date,
                            reviewers.name as reviewers_name
                        ')
                        ->leftjoin('reviewers', 'reviewers.id', '=', 'ratings.reviewer_id')
                        ->where('fundraisers_id', '=', $id)
                        ->where('reviewers.email_verified', '=', '1')
                        ->get();

        return $fundraisers;
    }
}
