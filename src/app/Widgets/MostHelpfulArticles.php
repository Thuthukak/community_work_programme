<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\KnowledgeBase;
use DB;

class MostHelpfulArticles extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $posts = KnowledgeBase::join('votes','votes.voteable_id','=','knowledge_bases.id')->select('knowledge_bases.*',DB::raw('sum(votes.satisfied) as satisfied','votes.voteable_id','votes.satisfied'))
            ->groupBy('knowledge_bases.id')
            ->where('knowledge_bases.status',KnowledgeBase::PUBLISHED)
            ->orderBy('satisfied', 'DESC')
            ->limit(12)->get();
        
        return view('widgets.most_helpful_articles', [
            'posts' => $posts,
        ]);
    }
}
