<?php

/**
 * rss actions.
 *
 * @package    clipboard
 * @subpackage rss
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rssActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  //public function executeIndex(sfWebRequest $request)
  //{}
  
  public function executeRss(sfWebRequest $request)
  {
    $feed = new sfAtom1Feed();
    $feed->setTitle('The mouse blog');
    $feed->setLink('http://www.myblog.com/');
    $feed->setAuthorEmail('pclive@myblog.com');
    $feed->setAuthorName('Peter Clive');

    $feedImage = new sfFeedImage();
    $feedImage->setFavicon('http://www.myblog.com/favicon.ico');
    $feed->setImage($feedImage);

  $c = new Criteria;
  $c->addDescendingOrderByColumn(PostPeer::CREATED_AT);
  $c->setLimit(5);
  $posts = PostPeer::doSelect($c);

  foreach ($posts as $post)
  {
    $item = new sfFeedItem();
    $item->setTitle($post->getTitle());
    $item->setLink('@permalink?stripped_title='.$post->getStrippedTitle());
    $item->setAuthorName($post->getAuthor()->getName());
    $item->setAuthorEmail($post->getAuthor()->getEmail());
    $item->setPubdate($post->getCreatedAt('U'));
    $item->setUniqueId($post->getStrippedTitle());
    $item->setDescription($post->getDescription());

    $feed->addItem($item);
  }

  $this->feed = $feed;

  }
}

?>