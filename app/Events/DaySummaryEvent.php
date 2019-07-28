<?php

namespace App\Events;

use App\Category;
use App\DaySummary;
use App\NewsItem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\DB;

class DaySummaryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $newsItem;

    // Time in hours
    // When daily summary needs to be published
    private $publish_time = 20;

    function nowInDays($timeUnix)
    {
        return strtotime(date("Y-m-d", $timeUnix));
    }

    function fromYesterdayUntilToday($nowInDays)
    {
        // Until this time
        $until = $nowInDays + $this->publish_time * 60 * 60;

        // From this time
        $from = $until - 24 * 60 * 60;

        return array(
            'from' => $from,
            'until' => $until,
        );
    }

    function fromTodayUntilTomorrow($nowInDays)
    {
        // Until this time
        $until = $nowInDays + ($this->publish_time + 24) * 60 * 60;

        // From this time
        $from = $until - 24 * 60 * 60;

        return array(
            'from' => $from,
            'until' => $until,
        );
    }


    public function __construct(NewsItem $newsItem, $mode)
    {
        $this->newsItem = $newsItem;

        // If updating use datetime from newsItem created_at
        if ($mode == 'storing')
        {
            // This datetime (now)
            $time = time();
        }
        elseif($mode == 'updating')
        {
            // From newsItem created_at (when it was created)
            $time = strtotime($newsItem->created_at);
        }
        else
        {
            throw new \ErrorException('No such $mode as: ' . $mode);
        }




        // Today in Days
        $nowInDays = $this->nowInDays($time);

        // Only if main_news was checked

        if($newsItem->main_news == 1)
        {
            // If it is already 20:00 or not
            if($time > ($nowInDays + $this->publish_time * 60 * 60))
            {
                // It's over 20:00
                // 20:00 - 00:00
                $period = $this->fromTodayUntilTomorrow($nowInDays);
                $this->updateOrCreateSummary($period);
            }
            else
            {
                // It's before 20:00
                // 00:00 - 20:00 (+ one day)
                $period = $this->fromYesterdayUntilToday($nowInDays);

                $this->updateOrCreateSummary($period);
            }
        }
        else
        {
            // If main_news wasn't checked
            // Then remove relation to daySummary
            $newsItem->update([
                'day_summaries_id' => null,
            ]);
        }

    }

    public function updateOrCreateSummary($period)
    {
        // Check if day_summary for given datetime interval exist
        $daySummary = DaySummary::where([
            // published_at
            // is same as = until with timestamp newsItems are recording
            ['publish_at', date('Y-m-d H:i:s', $period['until'])]
        ])->first();

        if($daySummary)
        {
            // There is summary for this period!!!
            // Summary is already created
            // So we need just to relate our new newsItem to existing daySummary

            // Start transaction
            DB::transaction(function() use ($period, $daySummary)
            {
                // There summary for this period
                // So let's relate our newsItem to it

                // In mysql datetime format!!!
                $until = date('Y-m-d H:i:s', $period['until']);
                $from =  date('Y-m-d H:i:s', $period['from']);

                // There is already feedEntity for daySummary

                // Relate newsItem to created daySummary
                $this->newsItem->update([
                    'day_summaries_id' => $daySummary->id,
                ]);

                // Everything is in transaction
                // So if it gonna fail
                // It will rollback everything hopefully
            });
        }
        else
        {
            // Start transaction
            DB::transaction(function() use ($period)
            {
                // There is no summary for this period!!!
                // So let's create one;

                // In mysql datetime format!!!
                $until = date('Y-m-d H:i:s', $period['until']);
                $from =  date('Y-m-d H:i:s', $period['from']);

                $daySummary = DaySummary::create([
                    'title' => "Итоги дня ($from - $until)",
                    'publish_at' => $until,
                ]);

                // And now create related FeedEntity
                // So you can see it in news feed

                // but before we need to know in witch category to put our feedEntity

                $category = Category::where('type', 'day_summary')->first();

                $daySummary->feedEntity()->create([
                    'category_id' => $category->id,
                    // So you can sort it easily
                    'created_at' => $until
                ]);


                // Relate newsItem to created daySummary
                $this->newsItem->update([
                    'day_summaries_id' => $daySummary->id,
                ]);

                // Everything is in transaction
                // So if it gonna fail
                // It will rollback everything
            });

        }
    }



//    /**
//     * Get the channels the event should broadcast on.
//     *
//     * @return \Illuminate\Broadcasting\Channel|array
//     */
//    public function broadcastOn()
//    {
//        return new PrivateChannel('channel-name');
//    }
}
