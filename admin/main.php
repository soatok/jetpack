<div class="jetpack-beta__master-head">
	<div class="jetpack-beta-container">
		<a class="jp-masthead__logo-link" href="<?php echo esc_url( Jetpack_Beta_Admin::settings_link() ); ?>">
			<svg className="jetpack-beta-logo" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" height="32" viewBox="0 0 118 32">
				<path fill="#00BE28" d="M16,0C7.2,0,0,7.2,0,16s7.2,16,16,16s16-7.2,16-16S24.8,0,16,0z M15,19H7l8-16V19z M17,29V13h8L17,29z" />
				<path d="M41.3,26.6c-0.5-0.7-0.9-1.4-1.3-2.1c2.3-1.4,3-2.5,3-4.6V8h-3V6h6v13.4C46,22.8,45,24.8,41.3,26.6z" />
				<path d="M65,18.4c0,1.1,0.8,1.3,1.4,1.3c0.5,0,2-0.2,2.6-0.4v2.1c-0.9,0.3-2.5,0.5-3.7,0.5c-1.5,0-3.2-0.5-3.2-3.1V12H60v-2h2.1V7.1 H65V10h4v2h-4V18.4z" />
				<path d="M71,10h3v1.3c1.1-0.8,1.9-1.3,3.3-1.3c2.5,0,4.5,1.8,4.5,5.6s-2.2,6.3-5.8,6.3c-0.9,0-1.3-0.1-2-0.3V28h-3V10z M76.5,12.3 c-0.8,0-1.6,0.4-2.5,1.2v5.9c0.6,0.1,0.9,0.2,1.8,0.2c2,0,3.2-1.3,3.2-3.9C79,13.4,78.1,12.3,76.5,12.3z" />
				<path d="M93,22h-3v-1.5c-0.9,0.7-1.9,1.5-3.5,1.5c-1.5,0-3.1-1.1-3.1-3.2c0-2.9,2.5-3.4,4.2-3.7l2.4-0.3v-0.3c0-1.5-0.5-2.3-2-2.3 c-0.7,0-2.3,0.5-3.7,1.1L84,11c1.2-0.4,3-1,4.4-1c2.7,0,4.6,1.4,4.6,4.7L93,22z M90,16.4l-2.2,0.4c-0.7,0.1-1.4,0.5-1.4,1.6 c0,0.9,0.5,1.4,1.3,1.4s1.5-0.5,2.3-1V16.4z" />
				<path d="M104.5,21.3c-1.1,0.4-2.2,0.6-3.5,0.6c-4.2,0-5.9-2.4-5.9-5.9c0-3.7,2.3-6,6.1-6c1.4,0,2.3,0.2,3.2,0.5V13 c-0.8-0.3-2-0.6-3.2-0.6c-1.7,0-3.2,0.9-3.2,3.6c0,2.9,1.5,3.8,3.3,3.8c0.9,0,1.9-0.2,3.2-0.7V21.3z" />
				<path d="M110,15.2c0.2-0.3,0.2-0.8,3.8-5.2h3.7l-4.6,5.7l5,6.3h-3.7l-4.2-5.8V22h-3V6h3V15.2z" />
				<path d="M58.5,21.3c-1.5,0.5-2.7,0.6-4.2,0.6c-3.6,0-5.8-1.8-5.8-6c0-3.1,1.9-5.9,5.5-5.9s4.9,2.5,4.9,4.9c0,0.8,0,1.5-0.1,2h-7.3 c0.1,2.5,1.5,2.8,3.6,2.8c1.1,0,2.2-0.3,3.4-0.7C58.5,19,58.5,21.3,58.5,21.3z M56,15c0-1.4-0.5-2.9-2-2.9c-1.4,0-2.3,1.3-2.4,2.9 C51.6,15,56,15,56,15z" />
			</svg>
			<span>Beta Tester</span></a>
	</div>
</div>
<div class="jetpack-beta-container" >
	<?php Jetpack_Beta_Admin::show_needed_updates(); ?>
	<?php if ( Jetpack_Beta::get_option() ) { ?>
		<div class="dops-foldable-card is-expanded has-expanded-summary dops-card is-compact">
			<div class="dops-foldable-card__header has-border">
				<span class="dops-foldable-card__main">
					<div class="dops-foldable-card__header-text">
						<div class="dops-foldable-card__header-text">Currently Running </div>
					</div>
				</span>
				<span class="dops-foldable-card__secondary">
					<?php Jetpack_Beta_Admin::show_toggle_emails(); ?>
					<?php if ( ! Jetpack_Beta::is_on_tag() ) : ?>
					<?php Jetpack_Beta_Admin::show_toggle_autoupdates(); ?>
					<?php endif; ?>
				</span>
			</div>
			<div class="dops-foldable-card__content">
				<p><?php echo Jetpack_Beta::get_jetpack_plugin_pretty_version(); ?>
					| <?php echo Jetpack_Beta::get_jetpack_plugin_version(); ?></p>
			</div>
		</div>
		<div class="dops-foldable-card has-expanded-summary dops-card">
			<div class="dops-foldable-card__header has-border">
			<span class="dops-foldable-card__main">
				<div class="dops-foldable-card__header-text">
					<div class="dops-foldable-card__header-text"><?php _e( 'Found a bug?', 'jetpack-beta' ); ?></div>
				</div>
			</span>
			<span class="dops-foldable-card__secondary" >
				<span class="dops-foldable-card__summary">
					<a
						type="button"
						href="<?php echo esc_url( JETPACK_BETA_REPORT_URL ); ?>"
						class="is-primary jp-form-button dops-button is-primary is-compact jptracks"
						data-jptracks-name="jetpack_beta_submit_report"
						data-jptracks-prop="<?php echo esc_attr( Jetpack_Beta::get_jetpack_plugin_version() ); ?>"
					>
						<?php _e( 'Report it!', 'jetpack-beta' ); ?>
					</a>
				</span>
			</span>
			</div>
		</div>

	<?php } else {
		Jetpack_Beta_Admin::start_notice();
	}
	?>
	<div class="jetpack-beta__wrap">
	<?php
		Jetpack_Beta_Admin::show_stable_branch();
		Jetpack_Beta_Admin::show_branch( __( 'Release Candidate' ), 'rc', null, 'rc' );
		Jetpack_Beta_Admin::show_branch( __( 'Bleeding Edge' ), 'master', null, 'master' );
		Jetpack_Beta_Admin::show_search_prs();
		Jetpack_Beta_Admin::show_branches( 'pr' );
		Jetpack_Beta_Admin::show_search_org_tags();
		Jetpack_Beta_Admin::show_tags( 'tags' );
	?>
	</div>

	<?php if ( $to_test = Jetpack_Beta_Admin::to_test_content() ) { ?>
		<div class="dops-foldable-card is-expanded has-expanded-summary dops-card is-compact">
			<div class="dops-foldable-card__header has-border">
				<span class="dops-foldable-card__main">
					<div class="dops-foldable-card__header-text">
						<div class="dops-foldable-card__header-text"><?php _e( 'To Test', 'jetpack-beta' ); ?></div>
					</div>
				</span>
			</div>
			<div class="dops-foldable-card__content">
				<?php echo $to_test ; ?>
			</div>
		</div>
	<?php } ?>

	<?php if ( $what_changed = Jetpack_Beta::what_changed()  ) { ?>
		<div class="dops-foldable-card is-expanded has-expanded-summary dops-card is-compact">
			<div class="dops-foldable-card__header has-border">
				<span class="dops-foldable-card__main">
					<div class="dops-foldable-card__header-text">
						<div class="dops-foldable-card__header-text"><?php _e( 'What changed', 'jetpack-beta' ); ?></div>
					</div>
				</span>
			</div>
			<div class="dops-foldable-card__content">
				<?php echo Jetpack_Beta_Admin::render_markdown( $what_changed ); ?>
			</div>
		</div>
	<?php } ?>
</div>
