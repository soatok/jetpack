<?php
/**
 * Test class for WPCOM_REST_API_V2_Endpoint_Update_Schedules, active feature.
 *
 * @package automattic/scheduled-updates
 */

use Automattic\Jetpack\Scheduled_Updates;
use Automattic\Jetpack\Scheduled_Updates_Active;
use Automattic\Jetpack\Scheduled_Updates_Logs;

/**
 * Test class for WPCOM_REST_API_V2_Endpoint_Update_Schedules, active feature.
 */
class Scheduled_Updates_Active_Test extends \WorDBless\BaseTestCase {

	/**
	 * Used to mock global functions inside a namespace.
	 *
	 * @see https://github.com/php-mock/php-mock-phpunit
	 */
	use \phpmock\phpunit\PHPMock;

	/**
	 * Admin user ID.
	 *
	 * @var int
	 */
	public $admin_id;

	/**
	 * The endpoint object.
	 *
	 * @var WPCOM_REST_API_V2_Endpoint_Update_Schedules
	 */
	public static $endpoint;

	/**
	 * Set up before class.
	 *
	 * @see Restrictions here: https://github.com/php-mock/php-mock-phpunit?tab=readme-ov-file#restrictions
	 * @beforeClass
	 */
	public static function set_up_before_class() {
		parent::set_up_before_class();

		self::$endpoint = new WPCOM_REST_API_V2_Endpoint_Update_Schedules();
	}

	/**
	 * Set up.
	 *
	 * @before
	 */
	public function set_up() {
		parent::set_up_wordbless();
		\WorDBless\Users::init()->clear_all_users();

		$this->admin_id = wp_insert_user(
			array(
				'user_login' => 'dummy_path_user',
				'user_pass'  => 'dummy_path_pass',
				'role'       => 'administrator',
			)
		);

		wp_set_current_user( $this->admin_id );

		Scheduled_Updates::init();
		do_action( 'rest_api_init' );
	}

	/**
	 * Clean up after test
	 *
	 * @after
	 */
	public function tear_down() {
		wp_delete_user( $this->admin_id );
		delete_option( Scheduled_Updates_Active::OPTION_NAME );

		parent::tear_down_wordbless();
	}

	/**
	 * Test create_item.
	 *
	 * @covers WPCOM_REST_API_V2_Endpoint_Update_Schedules::create_item
	 */
	public function test_create_scheduled_update_with_active_true() {
		$plugins   = array(
			'custom-plugin/custom-plugin.php',
			'gutenberg/gutenberg.php',
		);
		$request   = new WP_REST_Request( 'POST', '/wpcom/v2/update-schedules' );
		$post_data = array(
			'plugins'  => $plugins,
			'schedule' => array(
				'timestamp'          => strtotime( 'next Monday 8:00' ),
				'interval'           => 'weekly',
				'health_check_paths' => array(),
				'active'             => true,
			),
		);

		$request->set_body_params( $post_data );

		$schedule_id = Scheduled_Updates::generate_schedule_id( $plugins );
		$result      = rest_do_request( $request );
		$id          = $result->get_data();

		$this->assertSame( 200, $result->get_status() );
		$this->assertSame( $schedule_id, $id );
		$this->assertTrue( Scheduled_Updates_Active::get( $schedule_id ) );

		$request = new WP_REST_Request( 'GET', '/wpcom/v2/update-schedules' );
		$result  = rest_do_request( $request );
		$this->assertSame( 200, $result->get_status() );

		// Set active to false.
		$post_data['schedule']['active'] = false;

		$request->set_method( 'PUT' );
		$request->set_route( '/wpcom/v2/update-schedules/' . $id );
		$request->set_body_params( $post_data );
		$result = rest_do_request( $request );

		$this->assertSame( 200, $result->get_status() );

		$request->set_method( 'GET' );
		$result = rest_do_request( $request );
		$this->assertSame( 200, $result->get_status() );
		$this->assertFalse( $result->get_data()['active'] );

		$request->set_method( 'DELETE' );
		$result = rest_do_request( $request );
		$this->assertSame( 200, $result->get_status() );

		// The option should be removed.
		$this->assertSame( 'test', get_option( Scheduled_Updates_Active::OPTION_NAME, 'test' ) );
	}

	/**
	 * Test create_item.
	 *
	 * @covers WPCOM_REST_API_V2_Endpoint_Update_Schedules::create_item
	 */
	public function test_create_scheduled_update_is_active() {
		$plugins   = array( 'gutenberg/gutenberg.php' );
		$request   = new WP_REST_Request( 'POST', '/wpcom/v2/update-schedules' );
		$post_data = array(
			'plugins'  => $plugins,
			'schedule' => array(
				'timestamp'          => strtotime( 'next Monday 8:00' ),
				'interval'           => 'weekly',
				'health_check_paths' => array(),
			),
		);

		$request->set_body_params( $post_data );

		$schedule_id = Scheduled_Updates::generate_schedule_id( $plugins );
		$result      = rest_do_request( $request );

		$this->assertSame( 200, $result->get_status() );
		delete_option( Scheduled_Updates_Active::OPTION_NAME );

		$request->set_method( 'GET' );
		$result = rest_do_request( $request );
		$this->assertSame( 200, $result->get_status() );

		// Still active (for backwards compatibility)
		$this->assertTrue( $result->get_data()[ $schedule_id ]['active'] );
	}

	/**
	 * Test run_scheduled_update.
	 *
	 * @covers Scheduled_Updates::run_scheduled_update
	 */
	public function test_run_inactive_schedule() {
		$plugins   = array(
			'custom-plugin/custom-plugin.php',
			'gutenberg/gutenberg.php',
		);
		$request   = new WP_REST_Request( 'POST', '/wpcom/v2/update-schedules' );
		$post_data = array(
			'plugins'  => $plugins,
			'schedule' => array(
				'timestamp'          => strtotime( 'next Monday 8:00' ),
				'interval'           => 'weekly',
				'health_check_paths' => array(),
				'active'             => false,
			),
		);

		$request->set_body_params( $post_data );
		$result = rest_do_request( $request );
		$this->assertSame( 200, $result->get_status() );

		$schedule_id = Scheduled_Updates::generate_schedule_id( $plugins );
		$this->assertSame( $schedule_id, $result->get_data() );
		$this->assertFalse( call_user_func_array( array( Scheduled_Updates::class, 'run_scheduled_update' ), $plugins ) );
	}

	/**
	 * Test run_scheduled_update.
	 *
	 * @covers Scheduled_Updates::run_scheduled_update
	 */
	public function test_run_active_schedule() {
		$plugins   = array( 'gutenberg/gutenberg.php' );
		$request   = new WP_REST_Request( 'POST', '/wpcom/v2/update-schedules' );
		$post_data = array(
			'plugins'  => $plugins,
			'schedule' => array(
				'timestamp'          => strtotime( 'next Monday 8:00' ),
				'interval'           => 'weekly',
				'health_check_paths' => array(),
			),
		);

		$request->set_body_params( $post_data );
		$result = rest_do_request( $request );
		$this->assertSame( 200, $result->get_status() );

		$schedule_id = Scheduled_Updates::generate_schedule_id( $plugins );
		$this->assertSame( $schedule_id, $result->get_data() );
		$this->assertFalse( call_user_func_array( array( Scheduled_Updates::class, 'run_scheduled_update' ), $plugins ) );

		$logs = Scheduled_Updates_Logs::get( $schedule_id );
		$this->assertCount( 1, $logs );
		$this->assertCount( 2, $logs[0] );

		// The scheduled update started and succeeded.
		$this->assertSame( Scheduled_Updates_Logs::PLUGIN_UPDATES_START, $logs[0][0]['action'] );
		$this->assertSame( Scheduled_Updates_Logs::PLUGIN_UPDATES_SUCCESS, $logs[0][1]['action'] );
	}
}
