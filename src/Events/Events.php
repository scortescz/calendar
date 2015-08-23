<?php

namespace Scortes\Calendar\Events;

class Events
{
    /** @var \Scortes\Calendar\Events\EventNode */
    private $root;
    /** @var \Scortes\Calendar\Events\KeyDecomposition */
    private $keys;

    public function __construct($delimiter)
    {
        $this->root = new EventNode('');
        $this->keys = new KeyDecomposition($delimiter);
    }

    public function find($key)
    {
        $event = $this->findEventNode($key);
        return $event instanceof EventNode ? $event->unwrapEvent() : null;
    }

    private function findEventNode($key)
    {
        $event = $this->root;
        $this->keys->decompose($key);
        foreach ($this->keys as $key) {
            if ($event->existsSubEvent($key)) {
                $event = $event->getSubEvent($key);
            } else {
                return null;
            }
        }
        return $event;
    }

    public function set($key, $event)
    {
        $this->keys->decompose($key);
        if ($this->keys->noKeys()) {
            $this->root->add($event);
        } else {
            $this->setChildEvent($event);
        }
    }

    private function setChildEvent($event)
    {
        $childKey = $this->keys->getLastKey();
        $parent = $this->getParentEvent();
        $existingEvent = $this->getOrCreateSubEvent($parent, $childKey);
        $existingEvent->add($event);
    }

    private function getParentEvent()
    {
        $keys = $this->keys->getKeysWithoutLastKey();
        if (empty($keys)) {
            return $this->root;
        } else {
            $event = $this->root;
            foreach ($keys as $key) {
                $event = $this->getOrCreateSubEvent($event, $key);
            }
            return $event;
        }
    }

    private function getOrCreateSubEvent($parent, $key)
    {
        if (!$parent->existsSubEvent($key)) {
            $childDate = $this->getChildDate($parent, $key);
            $parent->setSubEvent($key, new EventNode($childDate));
        }
        return $parent->getSubEvent($key);
    }

    private function getChildDate($parent, $key)
    {
        $date = '';
        if ($parent != $this->root) {
            $date .= $parent->getEvent()->date . $this->keys->getDelimiter();
        }
        $date .= $key;
        return $date;
    }

    public function getIterator()
    {
        return $this->iterate('');
    }

    public function iterate($startNode)
    {
        $firstNode = $this->findEventNode($startNode);
        return new DepthFirstSearch($firstNode);
    }
}
