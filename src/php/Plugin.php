<?php

namespace Plugin;

use GeniePress\AjaxHandler;
use GeniePress\Interfaces\GenieComponent;
use GeniePress\Utilities\AddShortcode;
use GeniePress\Utilities\HookInto;
use GeniePress\Utilities\RegisterAjax;
use GeniePress\View;
use Plugin\Exceptions\ThemeException;

class Plugin implements GenieComponent
{


	public static function setup()
	{
		/**
		 * Make sure we load jQuery
		 */
		HookInto::action('init')
			->run(function () {
				wp_enqueue_script('jQuery');
			});




	}

}
