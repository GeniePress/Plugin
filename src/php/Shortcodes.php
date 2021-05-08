<?php

namespace Plugin;

use GeniePress\AjaxHandler;
use GeniePress\Interfaces\GenieComponent;
use GeniePress\Utilities\AddShortcode;
use GeniePress\View;

class Shortcodes implements GenieComponent
{


	public static function setup()
	{
		/**
		 * A simple Shortcode with Dynamic Twig
		 */
		AddShortcode::called('test_twig')
			->run(function () {

				$valid = View::isValidTwig('{{hello}} Tosh');

				return $valid ? 'is valid Twig Code' : 'is Invalid twig code';

			});

		/**
		 * Add a shortcode that fires the test ajax endpoint
		 */
		AddShortcode::called('test')->run(function () {
			return View::with('shortcode/test.twig')
				->addVar('endpoint', AjaxHandler::generateUrl('test'))
				->render();

		});

	}


}
