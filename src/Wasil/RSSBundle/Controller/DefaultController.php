<?php

namespace Wasil\RSSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Wasil\RSSBundle\Entity\Rss;
use Wasil\RSSBundle\Form\RssType;

use DateTime;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // $this->get('session')->setFlash('notice', 'Form successfully executed!');
        // $this->get('session')->setFlash('error', 'Form successfully executed!');
    }

    public function updateAction()
    {
        $em = $this->getDoctrine()->getManager();

        $feedsDbRaw = $em->getRepository('WasilRSSBundle:Feed')->findAll();
        $entities = $em->getRepository('WasilRSSBundle:Rss')->findAll();
        $itemsCount = 0;
        foreach ($feedsDbRaw as $fdr) {
            $content = file_get_contents($fdr->getUrl());
            $feed = simplexml_load_string($content);

            $titles = array();
            foreach ($entities as $en) {
                $titles[] = $en->getTitle();
            }

            $items =array();
            foreach($feed->channel->item as $item) {
                $items[] = $item;
            }

            $itemLimit = $this->container->getParameter('item_limit');
            $items = array_slice($items, 0, $itemLimit);

            foreach ($items as $item) {
                if (!in_array((string)$item->title, $titles)) {
                    $entity  = new Rss();
                    $entity->setTitle((string)$item->title);
                    $entity->setLink((string)$item->link);

                    // cleaning description of external links in img tags
                    $tmpDescription = preg_replace("/src=[\'\"]{1}(http.*?)['\"']{1}/", 'src=""', (string)$item->description);

                    $entity->setDescription($tmpDescription);
                    null != $item->author ? $entity->setAuthor((string)$item->author) : $entity->setAuthor("no author");
                    if (null != $item->pubDate) {
                        $date =  new DateTime((string)$item->pubDate);
                        $entity->setPubDate($date);
                    } else {
                        $entity->setPubDate("0000-00-00 00:00:00");
                    }
                    $entity->setFeed($fdr);
                    $entity->setRead(0);

                    $em->persist($entity);

                    $itemsCount++;

                    unset($entity);
                }
            }
        }

        $this->get('session')->setFlash('notice', 'Successfully added '.$itemsCount
            .' item'.(($itemsCount > 1 || $itemsCount == 0)? "s" : "")
            .' from '.count($feedsDbRaw).' feed'.(count($feedsDbRaw) > 1 ? "s" : "").'.');

        try {
            $em->flush(); 
        } catch (\Exception $e) {
             echo $e->getMessage();
        }
        return $this->redirect($this->generateUrl('rss'));
    }
}
