<?php
class CryptomeBridge extends BridgeAbstract {

	const MAINTAINER = 'BoboTiG';
	const NAME = 'Cryptome';
	const URI = 'https://cryptome.org/';
	const CACHE_TIMEOUT = 21600; //6h
	const DESCRIPTION = 'Returns the N most recent documents.';
	const PARAMETERS = array( array(
		'n' => array(
			'name' => 'number of elements',
			'type' => 'number',
			'defaultValue' => 20,
			'exampleValue' => 10
		)
	));

	public function getIcon() {
		return self::URI . '/favicon.ico';
	}

	public function collectData(){
		$html = getSimpleHTMLDOM(self::URI)
			or returnServerError('Could not request Cryptome.');
		$number = $this->getInput('n');
		if(!empty($number)) {
			$num = min($number, 20);
		}
		$i = 0;
		foreach($html->find('pre', 1)->find('b') as $element) {
			foreach($element->find('a') as $element1) {
				$item = array();
				$item['uri'] = $element1->href;
				$item['title'] = $element->plaintext;
				$this->items[] = $item;

				if ($i > $num) {
					break 2;
				}
				$i++;
			}
		}
	}
}
