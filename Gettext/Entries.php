<?php
namespace Gettext;

use Gettext\Translation;

class Entries extends \ArrayObject {
	public $domain = null;
	public $headers = array();

	public function setHeader ($name, $value) {
		$this->headers[trim($name)] = trim($value);
	}

	public function getHeader ($name) {
		return isset($this->headers[$name]) ? $this->headers[$name] : null;
	}

	public function getHeaders () {
		return $this->headers;
	}

	public function setDomain ($domain) {
		$this->domain = $domain;
	}

	public function getDomain () {
		return $this->domain;
	}

	public function hasDomain () {
		return (isset($this->domain) && $this->domain !== '') ? true : false;
	}

	public function find ($context, $original = null, $plural = null) {
		if (is_object($original) && $original instanceof Translation) {
			$context = $original->getContext();
			$original = $original->getOriginal();
			$plural = $original->getPlural();
		}

		foreach ($this as $t) {
			if ($t->is($context, $original, $plural)) {
				return $t;
			}
		}

		return false;
	}

	public function append ($original, $translation = null, $context = null) {
		return $this[] = new Translation($original, $translation, $context, $domain);
	}
}
