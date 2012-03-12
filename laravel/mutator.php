<?php namespace Laravel;

class Mutator {

	/**
	 * The response mutators for the application.
	 *
	 * @var array
	 */
	public static $mutators = array();

	/**
	 * Register a mutator for the application.
	 *
	 * <code>
	 *		// Register a closure as a mutator
	 *		Mutator::register('string', function() {});
	 *
	 *		// Register a class callback as a mutator
	 *		Mutator::register('json', array('Class', 'method'));
	 * </code>
	 *
	 * @param  string  $name
	 * @param  mixed   $callback
	 * @return void
	 */
	public static function register($name, $callback)
	{
		static::$mutators[$name] = $callback;
	}

	/**
	 * Call a mutator or set of mutators.
	 *
	 * @param  array   $collections
	 * @param  array   $pass
	 * @param  bool    $override
	 * @return mixed
	 */
	public static function run($name, $content)
	{
		if (!$name) {
			$name = Config::get('application.default_mutator');
		}

		if (isset(static::$mutators[$name]) && $name != 'string') {
			$content = call_user_func(static::$mutators[$name], $content);
		}

		return (string) $content;
	}

}
