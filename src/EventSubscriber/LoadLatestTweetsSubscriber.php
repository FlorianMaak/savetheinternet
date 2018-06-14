<?php

namespace App\EventSubscriber;

use App\Services\TweetService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\PostResponseEvent;

class LoadLatestTweetsSubscriber implements EventSubscriberInterface
{

    /**
     * @var TweetService
     */
    private $tweetService;

    /**
     * IndexController constructor.
     * @param TweetService $tweetService
     */
    public function __construct(TweetService $tweetService)
    {
        $this->tweetService = $tweetService;
    }

    public function onKernelTerminate(PostResponseEvent $event)
    {
        $this->tweetService->deleteAllTweets();

        $this->tweetService->loadLatestTweets();
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.terminate' => 'onKernelTerminate',
        ];
    }
}
