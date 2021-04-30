<?php

namespace Plugin;

use Lnk7\GeniePress\AjaxHandler;
use Lnk7\GeniePress\Interfaces\GenieComponent;
use Lnk7\GeniePress\Utilities\AddShortcode;
use Lnk7\GeniePress\View;

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
