<?php

use App\Events\CommentPosted;
use App\Events\PostLiked;
use App\Models\User;

class AwardPoints
{
    public function handle($event)
    {
        $user = $event->comment ? $event->comment->user : $event->like->user;
        $user->points = $user->points ?? 0;
        $user->badge = $user->badge ?? '';

        if ($event instanceof CommentPosted) {
            $this->awardCommentPoints($user);
        } elseif ($event instanceof PostLiked) {
            $this->awardLikePoints($user);
        }

        $user->save();
    }

    protected function awardCommentPoints(User $user)
    {
        $commentCount = $user->comments()->count();
        if ($commentCount == 1) {
            $user->points += 50;
            $user->badge = 'beginner-badge';
        } elseif ($commentCount == 30) {
            $user->points += 2500;
            $user->badge = 'top-fan';
        } elseif ($commentCount == 50) {
            $user->points += 5000;
            $user->badge = 'super-fan';
        }
    }

    protected function awardLikePoints(User $user)
    {
        $likeCount = $user->likes()->count();
        if ($likeCount == 10) {
            $user->points += 500;
            $user->badge = 'beginner-badge';
        }
    }
}