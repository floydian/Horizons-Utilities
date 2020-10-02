<?php
/*
	Created by Wayne Fincher
	Released to the public domain.
	No warrenty of mechantability or usefullness is claimed or implied. Use at your own discretion!
*/




class DoublyLinkedListNode {
	
	public function __construct($value, $previous, $next) {
		$this->value = $value;
		$this->setPrevious($previous);
		$this->setNext($next);
	}
	
	private $previous = null;
	
	private $next = null;
	
	private $value = null;
	
	public function previous() {
		return $this->previous;
	}
	
	public function next() {
		return $this->next;
	}
	
	public function value() {
		return $this->value;
	}
	
	public function setPrevious($previous) {
		$this->previous = $previous;
	}
	
	public function setNext($next) {
		$this->next = $next;
	}
	
	public function __toString() {
		return $this->value();
	}
	
	public function __debugInfo() {
		return [
			'value' => $this->value(),
			'previous value' => $this->previous() ? $this->previous()->value() : null,
			'next value' => $this->next() ? $this->next()->value() : null,
		];
	}
}

class DoublyLinkedList {
	
	/*
		Note that we don't need a setFirst() method since $first is controlled internally.
	*/
	private $first = null;
	
	
	/*
		Note that we don't need a setLast() method since $last is controlled internally.
	*/
	private $last = null;
	
	private $size = 0;
	
	public function first() {
		return $this->first;
	}
	
	public function last() {
		return $this->last;
	}
	
	public function insertLast($value) {
		if (is_null($this->last)) {
			$node = new DoublyLinkedListNode($value, null, null);
			$this->last = $this->first = $node;
		} else {
			$node = new DoublyLinkedListNode($value, $this->last, null);
			$this->last->setNext($node);
			$this->last = $node;
		}
		$this->size++;
	}
	
	public function removeNode($node) {
		if ($node == $this->first) {
			if ($node->next()) {
				$this->first = $node->next();
				$this->first->setPrevious(null);
			} else {
				$this->last = $this->first = null;
			}
		} else if ($node == $this->last) {
			if ($node->previous()) {
				$this->last = $node->previous();
				$this->last->setNext(null);
			} else {
				$this->last = $this->first = null;
			}
		} else {
			$node->previous()->setNext($node->next());
			$node->next()->setPrevious($node->previous());
		}
		$this->size--;
	}
	
	public function size() {
		return $this->size;
	}
	
	public function __debugInfo() {
		$items = [];
		if ($this->first) {
			$item = $this->first;
			while($item) {
				$items[] = $item;
				$item = $item->next();
			}
		}
		return [
			'first' => $this->first(),
			'last' => $this->last(),
			'items' => $items,
		];
	}
}
