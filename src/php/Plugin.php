<?php

namespace Plugin;

use Lnk7\GeniePress\AjaxHandler;
use Lnk7\GeniePress\Interfaces\GenieComponent;
use Lnk7\GeniePress\Utilities\AddShortcode;
use Lnk7\GeniePress\Utilities\HookInto;
use Lnk7\GeniePress\Utilities\RegisterAjax;
use Lnk7\GeniePress\View;
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
